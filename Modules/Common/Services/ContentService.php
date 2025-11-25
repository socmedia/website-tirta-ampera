<?php

namespace Modules\Common\Services;

use App\Traits\FileService;
use Illuminate\Support\Facades\DB;
use Modules\Common\Models\Content;
use Modules\Common\Enums\InputType;
use Modules\Common\Enums\ContentType;

class ContentService
{
    use FileService;

    /**
     * The model instance for content.
     *
     * @var Content
     */
    protected Content $model;

    /**
     * Create a new ContentService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Content();
    }

    /**
     * Get tabs grouped by page column with count, and nest sections inside each page.
     * Optionally, return only pages without sections if $onlyPage is true.
     *
     * @param array $exceptPage Pages to exclude from the results
     * @param string|null $type Filter by content type: static_page, content, seo. If null, include all.
     * @param bool $onlyPage If true, return only page info without sections
     * @return array
     * @throws \RuntimeException
     */
    public function getTabs(array $exceptPage = [], ?string $type = null, bool $onlyPage = false): array
    {
        try {
            // Get all pages with their counts
            $pages = $this->model
                ->select('page', DB::raw('count(*) as count'))
                ->groupBy('page')
                ->when(!empty($exceptPage), fn($query) => $query->whereNotIn('page', $exceptPage))
                ->when($type, fn($query) => $query->where('type', $type))
                ->get();

            if ($onlyPage) {
                // Return only page info without sections
                return $pages->map(function ($item) {
                    return [
                        'value' => $item->page,
                        'label' => str($item->page)->title(),
                        'count' => $item->count,
                    ];
                })->values()->toArray();
            }

            // Get all sections grouped by page with their counts
            $sections = $this->model
                ->select('page', 'section', DB::raw('count(*) as count'))
                ->groupBy('page', 'section')
                ->whereIn('page', $pages->pluck('page')->toArray())
                ->when(!empty($exceptPage), fn($query) => $query->whereNotIn('page', $exceptPage))
                ->when(!is_null($type), fn($query) => $query->where('type', $type))
                ->get()
                ->groupBy('page');

            // Build nested structure
            return $pages->map(function ($item) use ($sections) {
                $pageSections = $sections->get($item->page, collect());
                $sectionsArray = $pageSections->map(function ($section) {
                    return [
                        'value' => $section->section,
                        'label' => str($section->section)->title(),
                        'count' => $section->count,
                    ];
                })->values()->toArray();

                return [
                    'value' => $item->page,
                    'label' => str($item->page)->title(),
                    'count' => $item->count,
                    'sections' => !empty($sectionsArray) ? $sectionsArray : [],
                ];
            })->values()->toArray();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get tabs: " . $e->getMessage());
        }
    }

    /**
     * Get all unique pages.
     *
     * @param array $exceptPage Pages to exclude from the results
     * @param string|null $type Filter by content type: static_page, content, seo. If null, include all.
     * @return array
     */
    public function getPages(array $exceptPage = [], ?string $type = null): array
    {
        return $this->model
            ->select('page')
            ->when(!empty($exceptPage), fn($query) => $query->whereNotIn('page', $exceptPage))
            ->when(!is_null($type), fn($query) => $query->where('type', $type))
            ->distinct()
            ->orderBy('page')
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->page,
                    'label' => str($item->page)->title(),
                ];
            })
            ->values()
            ->toArray();
    }

    /**
     * Get all unique sections for a given page.
     *
     * @param string $page
     * @param string|null $type Filter by content type: static_page, content, seo. If null, include all.
     * @return array
     */
    public function getSections(string $page, ?string $type = null): array
    {
        return $this->model
            ->select('section')
            ->where('page', $page)
            ->when(!is_null($type), fn($query) => $query->where('type', $type))
            ->distinct()
            ->orderBy('section')
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->section,
                    'label' => str($item->section)->title(),
                ];
            })
            ->values()
            ->toArray();
    }

    /**
     * Build the base query for listing content.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildListingQuery(array $request)
    {
        return $this->model->newQuery()
            ->when(!empty($request['type']), function ($q) use ($request) {
                $q->where('type', $request['type']);
            })
            ->when(!empty($request['page']), function ($q) use ($request) {
                $q->where('page', $request['page']);
            })
            ->when(!empty($request['section']), function ($q) use ($request) {
                $q->where('section', $request['section']);
            })
            ->when(!empty($request['keyword']), function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $keyword = '%' . $request['keyword'] . '%';
                    $query
                        ->orWhere('name', 'like', $keyword)
                        ->orWhere('key', 'like', $keyword)
                        ->orWhere('value', 'like', $keyword);
                });
            })
            ->when(!empty($request['sort']), function ($q) use ($request) {
                $q->orderBy($request['sort'], $request['order'] ?? 'asc');
            })
            ->addSelect([
                'id',
                'page',
                'section',
                'key',
                'type',
                'input_type',
                'meta',
                'name',
                'value',
                'created_at',
                'updated_at'
            ]);
    }

    /**
     * List all content with pagination.
     *
     * @param array $request
     * @param int $total
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \RuntimeException
     */
    public function paginatedListing(array $request, int $total = 10)
    {
        try {
            $query = $this->buildListingQuery($request);

            $paginator = $query->paginate($total);

            // Items can be mapped/transformed here if necessary, otherwise returned as is.
            return $paginator;
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to list content: " . $e->getMessage());
        }
    }

    /**
     * List all content.
     *
     * @param array $request
     * @return \Illuminate\Support\Collection
     * @throws \RuntimeException
     */
    public function listing(array $request)
    {
        try {
            $query = $this->buildListingQuery($request);

            return $query->get();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to list content: " . $e->getMessage());
        }
    }

    /**
     * Get a content by ID.
     *
     * @param string $id
     * @return Content
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find content by ID: " . $e->getMessage());
        }
    }

    /**
     * Get a content by a specific column and value.
     *
     * @param string $column
     * @param string $value
     * @return Content
     * @throws \RuntimeException
     */
    public function findByColumn(string $column, string $value)
    {
        try {
            return $this->model->where($column, $value)->first();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find content by column: " . $e->getMessage());
        }
    }

    /**
     * Create a new content entry.
     *
     * @param array $data
     * @return Content
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            // Set default values for type and input_type if not provided
            if (!isset($data['type'])) {
                $data['type'] = ContentType::CONTENT;
            }
            if (!isset($data['input_type'])) {
                $data['input_type'] = InputType::INPUT_TEXT;
            }

            // Handle file upload for image type
            if (
                ($data['input_type'] === InputType::INPUT_IMAGE || $data['type'] === InputType::INPUT_IMAGE)
                && isset($data['value']) && $data['value'] instanceof \Illuminate\Http\UploadedFile
            ) {
                // Save new file using fileService
                $data['value'] = '/storage' . $this->storeFile($data['value'], 'image');
            }

            $content = $this->model->create($data);

            DB::commit();
            return $content;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to create content: " . $e->getMessage());
        }
    }

    /**
     * Update an existing content entry.
     *
     * @param string $id
     * @param array $data
     * @return Content
     * @throws \RuntimeException
     */
    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $model = $this->findById($id);

            if (!$model) {
                throw new \RuntimeException("Content not found.");
            }


            // Handle file upload for image type
            if (
                isset($data['value']) && $data['value'] instanceof \Illuminate\Http\UploadedFile
            ) {
                // Remove old file if exists
                if ($model->value) {
                    $this->removeFile('image', $model->value);
                }
                // Save new file using fileService
                $data['value'] = '/storage' . $this->storeFile($data['value'], 'image');
            }

            $model->update($data);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update content: " . $e->getMessage());
        }
    }

    /**
     * Soft delete a content and destroy associated file if it exists (for images).
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function delete(string $id)
    {
        try {
            $model = $this->findById($id);

            // Remove file for image type
            if (
                ($model->input_type === InputType::INPUT_IMAGE || $model->type === InputType::INPUT_IMAGE)
                && isset($model->value) && $model->value
            ) {
                $this->removeFile('image', $model->value);
            }

            return $model->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to delete content: " . $e->getMessage());
        }
    }

    /**
     * Delete all SEO content for a given page (tab) - helper for SEO listings.
     *
     * @param string $pageValue
     * @return int Number of deleted records
     * @throws \RuntimeException
     */
    public function deleteSeoByPage(string $pageValue)
    {
        try {
            $items = $this->model
                ->where('page', $pageValue)
                ->where('type', ContentType::SEO)
                ->get();

            foreach ($items as $item) {
                // Remove file for image type if exists
                if (
                    ($item->input_type === InputType::INPUT_IMAGE || $item->type === InputType::INPUT_IMAGE)
                    && isset($item->value) && $item->value
                ) {
                    $this->removeFile('image', $item->value);
                }
                $item->delete();
            }

            return count($items);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to delete SEO content for page: " . $e->getMessage());
        }
    }

    /**
     * Permanently delete a content (force delete).
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
            throw new \RuntimeException("Failed to force delete content: " . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted content.
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
            throw new \RuntimeException("Failed to restore content: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of content based on specific request filters.
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
            throw new \RuntimeException("Failed to count content: " . $e->getMessage());
        }
    }

    /**
     * Bulk delete content by IDs.
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
            throw new \RuntimeException("Failed to bulk delete content: " . $e->getMessage());
        }
    }

    /**
     * Bulk update content.
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
            throw new \RuntimeException("Failed to bulk update content: " . $e->getMessage());
        }
    }

    /**
     * Archive a content.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function archive(string $id)
    {
        try {
            $model = $this->findById($id);
            $model->archived_at = now();
            return $model->save();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to archive content: " . $e->getMessage());
        }
    }

    /**
     * Restore archived content.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function restoreArchived(string $id)
    {
        try {
            $model = $this->findById($id);
            $model->archived_at = null;
            return $model->save();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to restore archived content: " . $e->getMessage());
        }
    }

    /**
     * Check if a specific content exists.
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
            throw new \RuntimeException("Failed to check if content exists: " . $e->getMessage());
        }
    }

    /**
     * Update multiple content by keys.
     *
     * @param array $data
     * @param array $keys
     * @return bool
     * @throws \RuntimeException
     */
    public function updateByKeys(array $data, array $keys)
    {
        try {
            return $this->model->whereIn('key', $keys)->update($data);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to update content by keys: " . $e->getMessage());
        }
    }

    /**
     * Delete multiple content by keys.
     *
     * @param array $keys
     * @return bool
     * @throws \RuntimeException
     */
    public function deleteByKeys(array $keys)
    {
        try {
            return $this->model->whereIn('key', $keys)->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to delete content by keys: " . $e->getMessage());
        }
    }
}
