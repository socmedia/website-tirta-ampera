<?php

namespace Modules\Common\Services;

use Exception;
use Illuminate\Http\File;
use App\Traits\FileService;
use Modules\Common\Models\Post;
use Illuminate\Support\Facades\DB;
use Modules\Common\Transformers\PostTransformer;
use Modules\Common\Enums\PostType;

class PostService
{
    use FileService;

    /**
     * The model instance for post.
     *
     * @var Post
     */
    protected Post $model;

    /**
     * Create a new PostService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Post();
    }

    /**
     * Get tabs grouped by type column with count.
     *
     * @param array $exceptGroup Groups to exclude from the results
     * @return array
     * @throws \RuntimeException
     */
    public function getTabs(array $exceptGroup = []): array
    {
        try {
            // Step 1: Get enum-based tab definitions
            $enumTabs = collect(PostType::cases())
                ->mapWithKeys(fn($case) => [
                    $case->value => [
                        'label' => str($case->name)->replace('_', ' ')->title(),
                        'value' => $case->value,
                        'count' => 0,
                        'active' => false,
                    ],
                ]);

            // Step 2: Query DB counts by type
            $dbCounts = $this->model
                ->select('type', DB::raw('count(*) as count'))
                ->groupBy('type')
                ->when(!empty($exceptGroup), fn($query) => $query->whereNotIn('type', $exceptGroup))
                ->get()
                ->keyBy('type');

            // Step 3: Merge counts into enum-based tabs
            $tabs = $enumTabs->map(function ($tab, $type) use ($dbCounts) {
                if ($dbCounts->has($type)) {
                    $tab['count'] = $dbCounts[$type]->count;
                }
                return $tab;
            });

            // Step 4: Append DB-only types not in enum
            $dbCounts->each(function ($item, $type) use (&$tabs) {
                if (!$tabs->has($type)) {
                    $tabs->put($type, [
                        'label' => str($item->type)->title(),
                        'value' => $item->type,
                        'count' => $item->count,
                        'active' => false,
                    ]);
                }
            });

            return $tabs->values()->toArray(); // Optional: values() to reset numeric keys
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get tabs: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Build the base query for listing posts.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildListingQuery(array $request)
    {
        return $this->model->newQuery()
            ->select([
                'posts.id',
                'posts.category_id',
                'categories.name as category_name',
                'posts.title',
                'posts.slug',
                'posts.subject',
                'posts.content',
                'posts.meta_title',
                'posts.meta_description',
                'posts.type',
                'posts.thumbnail',
                'posts.tags',
                'posts.reading_time',
                'posts.number_of_views',
                'posts.number_of_shares',
                'posts.author',
                'authors.name as author_name',
                'posts.published_at',
                'posts.published_by',
                'publishers.name as published_by_name',
                'posts.archived_at',
                'posts.created_at',
                'posts.updated_at',
                'posts.deleted_at',
            ])
            ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
            ->leftJoin('users as authors', 'posts.author', '=', 'authors.id')
            ->leftJoin('users as publishers', 'posts.published_by', '=', 'publishers.id')
            ->when(
                !empty($request['keyword']) && $request['keyword'] !== 'all',
                fn($q) => $q->where(function ($query) use ($request) {
                    $kw = $request['keyword'];
                    $query->where('posts.title', 'like', "%{$kw}%")
                        ->orWhere('posts.subject', 'like', "%{$kw}%")
                        ->orWhere('posts.content', 'like', "%{$kw}%")
                        ->orWhere('categories.name', 'like', "%{$kw}%");
                })
            )
            // Filter by type if provided
            ->when(!empty($request['type']) && $request['type'] !== 'all', fn($q) => $q->where('posts.type', $request['type']))
            // Filter by status if provided
            ->when(isset($request['status']), function ($q) use ($request) {
                if ($request['status'] === 'active') {
                    $q->whereNull('posts.archived_at')->whereNull('posts.deleted_at');
                } elseif ($request['status'] === 'inactive') {
                    $q->whereNotNull('posts.archived_at');
                }
            })
            // Sort if sort field provided
            ->when(
                !empty($request['sort']),
                fn($q) => $q->orderBy(
                    in_array($request['sort'], [
                        'title',
                        'published_at',
                        'created_at',
                        'id',
                        'reading_time',
                        'number_of_views',
                        'number_of_shares',
                        'sort_order'
                    ]) ? ('posts.' . $request['sort']) : 'posts.created_at',
                    $request['order'] ?? 'asc'
                ),
                fn($q) => $q->orderBy('posts.created_at', 'desc')
            );
    }

    /**
     * List posts with optional pagination.
     *
     * @param array $request
     * @param bool $paginate
     * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     * @throws \RuntimeException
     */
    public function listing(array $request, bool $paginate = false)
    {
        try {
            $query = $this->buildListingQuery($request);

            if ($paginate) {
                $perPage = isset($request['per_page']) && is_numeric($request['per_page']) ? (int)$request['per_page'] : 15;

                $paginator = $query->paginate($perPage);
                $paginator->getCollection()->transform(fn($item) => PostTransformer::transform($item)->toModel());
                return $paginator;
            }

            return $query->get()->map(fn($item) => PostTransformer::transform($item)->toModel());
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to list posts: " . $e->getMessage());
        }
    }

    /**
     * Get published posts for public view.
     *
     * @param array $filters
     * @param bool $paginate
     * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     * @throws \RuntimeException
     */
    public function publicPosts(array $filters = [], bool $paginate = false)
    {
        try {
            $query = $this->model
                ->select([
                    'posts.id',
                    'posts.category_id',
                    'posts.title',
                    'posts.slug',
                    'posts.subject',
                    'posts.content',
                    'posts.meta_title',
                    'posts.meta_description',
                    'posts.type',
                    'posts.thumbnail',
                    'posts.tags',
                    'posts.reading_time',
                    'posts.number_of_views',
                    'posts.number_of_shares',
                    'posts.author',
                    'authors.name as author_name',
                    'posts.published_at',
                    'posts.published_by',
                    'publishers.name as published_by_name',
                    'posts.archived_at',
                    'posts.created_at',
                    'posts.updated_at',
                    'posts.deleted_at',
                    'categories.name as category_name',
                ])
                ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
                ->leftJoin('users as authors', 'posts.author', '=', 'authors.id')
                ->leftJoin('users as publishers', 'posts.published_by', '=', 'publishers.id')
                // Status filters (always applied)
                ->whereNotNull('posts.published_at')
                ->whereNull('posts.archived_at')
                ->whereNull('posts.deleted_at')
                ->where('posts.published_at', '<=', now())
                // Grouped optional filters
                ->where(function ($q) use ($filters) {
                    // 1. Exclude specific post
                    if (!empty($filters['except_id'])) {
                        $q->where('posts.id', '!=', $filters['except_id']);
                    }

                    // 2. Category filters
                    if (!empty($filters['category_id'])) {
                        $q->where('posts.category_id', $filters['category_id']);
                    }
                    if (!empty($filters['categories']) && is_array($filters['categories'])) {
                        $q->whereIn('posts.category_id', $filters['categories']);
                    }

                    // 3. Tag filters
                    if (!empty($filters['tag'])) {
                        $tag = trim($filters['tag']);
                        $q->whereRaw("posts.tags REGEXP ?", ['(^|,)' . preg_quote($tag, '/') . '($|,)']);
                    }
                    if (!empty($filters['tags'])) {
                        $tags = array_filter(array_map('trim', explode(',', $filters['tags'])));
                        if (!empty($tags)) {
                            $regexParts = [];
                            foreach ($tags as $tag) {
                                if ($tag !== '') {
                                    $regexParts[] = '(^|,)' . preg_quote($tag, '/') . '($|,)';
                                }
                            }
                            if (!empty($regexParts)) {
                                $regex = implode('|', $regexParts);
                                $q->orWhereRaw("posts.tags REGEXP ?", [$regex]);
                            }
                        }
                    }

                    // 4. Type filter
                    if (!empty($filters['type'])) {
                        $q->where('posts.type', $filters['type']);
                    }

                    // 5. Keyword search
                    if (!empty($filters['keyword'])) {
                        $q->where(function ($query) use ($filters) {
                            $kw = $filters['keyword'];
                            $query->where('posts.title', 'like', "%{$kw}%")
                                ->orWhere('posts.subject', 'like', "%{$kw}%")
                                ->orWhere('posts.content', 'like', "%{$kw}%")
                                ->orWhere('categories.name', 'like', "%{$kw}%");
                        });
                    }
                })
                // Sorting
                ->when(
                    !empty($filters['sort_option']),
                    function ($q) use ($filters) {
                        switch ($filters['sort_option']) {
                            case 'newest':
                                $q->orderBy('posts.published_at', 'desc');
                                break;
                            case 'oldest':
                                $q->orderBy('posts.published_at', 'asc');
                                break;
                            case 'title-asc':
                                $q->orderBy('posts.title', 'asc');
                                break;
                            case 'title-desc':
                                $q->orderBy('posts.title', 'desc');
                                break;
                            default:
                                $q->orderBy('posts.published_at', 'desc');
                        }
                    },
                    fn($q) => $q->orderBy('posts.published_at', 'desc')
                );

            $perPage = isset($filters['per_page']) && is_numeric($filters['per_page']) ? (int)$filters['per_page'] : 15;

            if ($paginate) {
                $paginator = $query->paginate($perPage);
                $paginator->getCollection()->transform(fn($item) => PostTransformer::transform($item)->toModel());
                return $paginator;
            }

            return $query->limit($perPage)->get()->map(fn($item) => PostTransformer::transform($item)->toModel());
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get published posts: " . $e->getMessage());
        }
    }

    /**
     * Public search for published posts.
     *
     * @param string $keyword
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function publicSearch(string $keyword, int $limit = 10)
    {
        $query = $this->model
            ->select([
                'posts.id',
                'posts.title',
                'posts.slug',
                'posts.subject',
                'posts.content',
                'posts.type',
                'posts.thumbnail',
                'posts.published_at',
                'categories.name as category_name',
            ])
            ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
            ->whereNotNull('posts.published_at')
            ->whereNull('posts.archived_at')
            ->whereNull('posts.deleted_at')
            ->where(function ($q) use ($keyword) {
                $q->where('posts.title', 'like', "%{$keyword}%")
                    ->orWhere('posts.subject', 'like', "%{$keyword}%")
                    ->orWhere('posts.content', 'like', "%{$keyword}%")
                    ->orWhere('categories.name', 'like', "%{$keyword}%");
            })
            ->orderBy('posts.published_at', 'desc');

        $paginator = $query->paginate($limit);

        $paginator->getCollection()->transform(function ($item) {
            $model = PostTransformer::transform($item)->toModel();
            // Append URL for public 'front.news.show' route using slug
            if (isset($model->slug)) {
                $model->url = route('front.news.show', ['slug' => $model->slug]);
            }
            return $model;
        });

        return $paginator;
    }

    /**
     * Get a post by ID.
     *
     * @param string $id
     * @return Post|null
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find post by ID: " . $e->getMessage());
        }
    }

    /**
     * Get a public post by slug.
     *
     * @param string $slug
     * @return Post|null
     * @throws \RuntimeException
     */
    public function findPublicBySlug(string $slug)
    {
        $post = $this->model
            ->select([
                'posts.*',
                'categories.name as category_name',
                'categories.slug as category_slug'
            ])
            ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
            ->where('posts.slug', $slug)
            ->whereNotNull('posts.published_at')
            ->whereNotNull('posts.published_by')
            ->whereNull('posts.archived_at')
            ->whereNull('posts.deleted_at')
            ->first();

        if (!$post) {
            abort(404, "Post not found with slug: {$slug}");
        }

        return PostTransformer::transform($post)->toModel();
    }

    /**
     * Create a new post.
     *
     * @param array $data
     * @return Post
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $mainData = $data;
            $mainData['reading_time'] = $data['reading_time'] ?? null;
            $mainData['number_of_views'] = $data['number_of_views'] ?? 0;
            $mainData['number_of_shares'] = $data['number_of_shares'] ?? 0;
            $mainData['author'] = auth('web')->id();
            $mainData['published_by'] = $data['status'] ? auth('web')->id() : null;
            $mainData['published_at'] = $data['status'] ? now()->toDateTimeString() : null;

            // Store desktop media path using FileService if present
            if (isset($mainData['thumbnail']) && is_array($mainData['thumbnail']) && !empty($mainData['thumbnail'][0])) {
                $file = new File($mainData['thumbnail'][0]['path']);
                $mainData['thumbnail'] = $this->storeFile($file, 'image');
            }

            $post = $this->model->create($mainData);

            DB::commit();
            return $post;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to create post: " . $e->getMessage());
        }
    }

    /**
     * Update an existing post.
     *
     * @param string $id
     * @param array $data
     * @return Post
     * @throws \RuntimeException
     */
    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $model = $this->findById($id);

            if (!$model) {
                throw new \RuntimeException("Post not found.");
            }

            $mainData = $data;
            $mainData['published_by'] = $data['status'] ? auth('web')->id() : null;
            $mainData['published_at'] = $data['status'] ? now()->toDateTimeString() : null;

            // Remove old image if a new thumbnail is provided
            if (
                isset($mainData['thumbnail']) && !empty($mainData['thumbnail'][0])
            ) {
                // Remove old image if exists
                $this->removeFile('image', $model->thumbnail);

                $file = new File($mainData['thumbnail'][0]['path']);
                $mainData['thumbnail'] = $this->storeFile($file, 'image');
            } else {
                // If thumbnail is empty, remove it from mainData
                unset($mainData['thumbnail']);
            }

            // Remove old_thumbnail from data if present
            if (isset($mainData['old_thumbnail'])) {
                unset($mainData['old_thumbnail']);
            }

            $model->update($mainData);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update post: " . $e->getMessage());
        }
    }

    /**
     * Update the order of posts.
     *
     * @param array $orderedIds Array of post data with order and value
     * @return bool
     * @throws \RuntimeException
     */
    public function updateOrder(array $orderedIds)
    {
        DB::beginTransaction();
        try {
            foreach ($orderedIds as $item) {
                $id = $item['value'];
                $order = $item['order'];

                $post = $this->findById($id);

                if (!$post) {
                    throw new \RuntimeException("Post with ID {$id} not found.");
                }

                // If you want to use a sort_order field, you can add it to the posts table and update here.
                $post->sort_order = $order;
                $post->save();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update post order: " . $e->getMessage());
        }
    }

    /**
     * Soft delete a post.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function delete(string $id)
    {
        try {
            $model = $this->findById($id);
            return $model->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to delete post: " . $e->getMessage());
        }
    }

    /**
     * Permanently delete a post (force delete).
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function forceDelete(string $id)
    {
        try {
            return $this->model->where('id', $id)->forceDelete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to force delete post: " . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted post.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function restore(string $id)
    {
        try {
            return $this->model->withTrashed()->where('id', $id)->restore();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to restore post: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of posts based on specific request filters.
     *
     * @param array $request
     * @return int
     * @throws \RuntimeException
     */
    public function count(array $request)
    {
        try {
            return $this->model->where($request)->count();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to count posts: " . $e->getMessage());
        }
    }

    /**
     * Bulk delete posts by IDs.
     *
     * @param array $ids
     * @return bool
     * @throws \RuntimeException
     */
    public function bulkDelete(array $ids)
    {
        try {
            return $this->model->whereIn('id', $ids)->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to bulk delete posts: " . $e->getMessage());
        }
    }

    /**
     * Bulk update posts.
     *
     * @param array $data
     * @param array $ids
     * @return bool
     * @throws \RuntimeException
     */
    public function bulkUpdate(array $data, array $ids)
    {
        try {
            return $this->model->whereIn('id', $ids)->update($data);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to bulk update posts: " . $e->getMessage());
        }
    }

    /**
     * Check if a specific post exists.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function isExists(string $id)
    {
        try {
            return $this->model->where('id', $id)->exists();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to check if post exists: " . $e->getMessage());
        }
    }

    /**
     * Get the last sort order among all posts.
     *
     * @return int|null
     * @throws \RuntimeException
     */
    public function getLastSortOrder()
    {
        try {
            return $this->model->max('sort_order');
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get last sort order: " . $e->getMessage());
        }
    }
}
