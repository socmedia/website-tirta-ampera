<?php

namespace Modules\Common\Services;

use Exception;
use App\Traits\FileService;
use Illuminate\Support\Facades\DB;
use Modules\Common\Models\Category;
use Modules\Common\Transformers\CategoryTransformer;

class CategoryService
{
    use FileService;

    /**
     * The model instance for category.
     *
     * @var Category
     */
    protected Category $model;

    /**
     * Create a new CategoryService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Category();
    }

    /**
     * Get categories grouped by status with count, optionally filtered by group.
     *
     * @param string|null $groupFilter
     * @return array
     * @throws \RuntimeException
     */
    public function getTabs(?string $groupFilter = null): array
    {
        try {
            $query = $this->model->newQuery();

            // Apply group filter if provided
            if ($groupFilter !== null) {
                $query->where('group', $groupFilter);
            }

            // Use a single query to get all, active, and inactive counts for categories
            $counts = $query
                ->selectRaw('COUNT(*) as all_count')
                ->selectRaw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active_count')
                ->selectRaw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as inactive_count')
                ->whereNull('parent_id')
                ->first();

            $tabs = [
                [
                    'value' => 'all',
                    'label' => 'All',
                    'count' => (int) $counts->all_count,
                    'active' => true
                ],
                [
                    'value' => 'active',
                    'label' => 'Active',
                    'count' => (int) $counts->active_count,
                    'active' => false
                ],
                [
                    'value' => 'inactive',
                    'label' => 'Inactive',
                    'count' => (int) $counts->inactive_count,
                    'active' => false
                ]
            ];

            return $tabs;
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get category tabs: " . $e->getMessage());
        }
    }

    /**
     * Get categories by group and their children.
     *
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    public function getCategoriesByGroup(string $group)
    {
        return $this->model
            ->select([
                'categories.id',
                'categories.name',
                'categories.slug',
            ])
            ->where('categories.group', $group)
            ->whereNull('categories.parent_id')
            ->orderBy('categories.sort_order')
            ->with(['childs' => function ($query) {
                $query->select([
                    'categories.id',
                    'categories.parent_id',
                    'categories.name',
                ])->orderBy('categories.sort_order');
            }])
            ->get();
    }

    /**
     * Get public (active) categories by group with their children.
     *
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    public function getPublicCategoriesByGroup(string $group)
    {
        return $this->model
            ->select([
                'categories.id',
                'categories.name',
                'categories.slug',
            ])
            ->where('categories.group', $group)
            ->whereNull('categories.parent_id')
            ->where('categories.status', true)
            ->orderBy('categories.sort_order')
            ->with(['childs' => function ($query) {
                $query->select([
                    'categories.id',
                    'categories.parent_id',
                    'categories.name',
                ])
                    ->where('categories.status', true)
                    ->orderBy('categories.sort_order');
            }])
            ->get();
    }

    /**
     * Build the base query for listing categories.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildListingQuery(array $request)
    {
        return $this->model->newQuery()
            ->select([
                'categories.id',
                'categories.parent_id',
                'categories.name',
                'categories.slug',
                'categories.description',
                'categories.image_path',
                'categories.icon',
                'categories.sort_order',
                'categories.status',
                'categories.featured',
                'categories.group',
                'categories.created_by',
                'categories.updated_by',
                'categories.deleted_at',
                'categories.created_at',
                'categories.updated_at',
            ])
            ->whereNull('parent_id')
            ->when(isset($request['parent_id']), fn($q) => $q->where('categories.parent_id', $request['parent_id']))
            ->when(!empty($request['group']), fn($q) => $q->where('categories.group', $request['group']))
            ->when(isset($request['status']), function ($q) use ($request) {
                if ($request['status'] === 'active') {
                    $q->where('categories.status', 1);
                } elseif ($request['status'] === 'inactive') {
                    $q->where('categories.status', 0);
                }
            })
            ->when(!empty($request['keyword']), function ($q) use ($request) {
                // Example search on name or slug
                $q->where(function ($sub) use ($request) {
                    $sub->where('categories.name', 'like', '%' . $request['keyword'] . '%')
                        ->orWhere('categories.slug', 'like', '%' . $request['keyword'] . '%');
                });
            })
            ->when(!empty($request['sort']), fn($q) => $q->orderBy('categories.' . $request['sort'], $request['order'] ?? 'asc'));
    }

    /**
     * List categories with optional pagination.
     *
     * This method builds a query for categories based on the provided request filters.
     * If $paginate is true, it returns a paginated result set; otherwise, it returns a collection.
     *
     * @param array $request The filters and options for the listing (e.g., search, sort, per_page, page, status, etc.)
     * @param bool $paginate Whether to paginate the results (default: false)
     * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     * @throws \RuntimeException If the listing fails
     */
    public function listing(array $request, bool $paginate = false)
    {
        try {
            $query = $this->buildListingQuery($request);

            if ($paginate) {
                $perPage = isset($request['per_page']) && is_numeric($request['per_page']) ? (int)$request['per_page'] : 15;
                $paginator = $query->paginate($perPage);
                $paginator->getCollection()->transform(fn($item) => CategoryTransformer::transform($item)->toModel());
                return $paginator;
            }

            return $query->get()->map(fn($item) => CategoryTransformer::transform($item)->toModel());
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to list categories: " . $e->getMessage());
        }
    }

    /**
     * Get a category by ID with its subcategories.
     *
     * @param string $id
     * @return array|null
     * @throws \RuntimeException
     */
    public function findByIdWithSubcategories(string $id)
    {
        try {
            $select = [
                'categories.id',
                'categories.parent_id',
                'categories.name',
                'categories.slug',
                'categories.description',
                'categories.image_path',
                'categories.icon',
                'categories.sort_order',
                'categories.status',
                'categories.featured',
                'categories.group',
                'categories.created_by',
                'categories.updated_by',
                'categories.deleted_at',
                'categories.created_at',
                'categories.updated_at',
            ];

            // Main category
            $category = $this->model
                ->select($select)
                ->where('categories.id', $id)
                ->with(['childs'])
                ->first();

            if (!$category) {
                throw new \RuntimeException("Category not found with ID: {$id}");
            }

            // Load subcategories (only direct children)
            $subcategories = $this->model
                ->select($select)
                ->where('categories.parent_id', $id)
                ->orderBy('categories.sort_order')
                ->get();

            // Inject subcategories manually to support transformer recursion
            $category->setRelation('childs', $subcategories);

            // Transform
            return CategoryTransformer::transform($category)->toArray();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find category with subcategories: " . $e->getMessage());
        }
    }

    /**
     * Get a category by ID.
     *
     * @param string $id
     * @return Category|null
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find category by ID: " . $e->getMessage());
        }
    }

    /**
     * Get a category by a specific column and value.
     *
     * @param string $column
     * @param string $value
     * @return Category|null
     * @throws \RuntimeException
     */
    public function findByColumn(string $column, string $value)
    {
        try {
            return $this->model->where($column, $value)->first();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find category by column: " . $e->getMessage());
        }
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $mainData = $data;

            // Handle file upload for image (support both 'image' and 'image_path' keys)
            if (isset($mainData['image']) && $mainData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $mainData['image_path'] = '/storage' . $this->storeFile($mainData['image'], 'category');
                unset($mainData['image']);
            } elseif (isset($mainData['image_path']) && $mainData['image_path'] instanceof \Illuminate\Http\UploadedFile) {
                $mainData['image_path'] = '/storage' . $this->storeFile($mainData['image_path'], 'category');
            }

            // Slugify 'slug' if present or auto by name
            if (isset($mainData['slug']) && $mainData['slug']) {
                $mainData['slug'] = str($mainData['slug'])->slug('-')->toString();
            } elseif (isset($mainData['name'])) {
                $mainData['slug'] = str($mainData['name'])->slug('-')->toString();
            }

            // Fix sort order: set sort_order to last+1 if not provided
            if (!isset($mainData['sort_order'])) {
                $group = $mainData['group'] ?? null;
                $parentId = $mainData['parent_id'] ?? null;
                if ($group !== null) {
                    if ($parentId === null) {
                        // Parent category
                        $lastSortOrder = $this->getParentLastSortOrder($group);
                    } else {
                        // Child category
                        $lastSortOrder = $this->getChildLastSortOrder($group, $parentId);
                    }
                    $mainData['sort_order'] = is_null($lastSortOrder) ? 1 : $lastSortOrder + 1;
                }
            }

            $category = $this->model->create($mainData);

            DB::commit();
            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to create category: " . $e->getMessage());
        }
    }

    /**
     * Update an existing category.
     *
     * @param string $id
     * @param array $data
     * @return Category
     * @throws \RuntimeException
     */
    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $model = $this->findById($id);

            if (!$model) {
                throw new \RuntimeException("Category not found.");
            }

            $mainData = $data;

            // Slugify 'slug' if present or use name
            if (isset($mainData['slug'])) {
                $mainData['slug'] = str($mainData['slug'])->slug('-')->toString();
            } elseif (isset($mainData['name']) && empty($model->slug)) {
                $mainData['slug'] = str($mainData['name'])->slug('-')->toString();
            }

            // Handle file upload for image_path
            if (isset($mainData['image_path']) && $mainData['image_path'] instanceof \Illuminate\Http\UploadedFile) {
                // Remove old file if exists
                if ($model->image_path) {
                    $this->removeFile('category', $model->image_path);
                }
                $mainData['image_path'] = '/storage' . $this->storeFile($mainData['image_path'], 'category');
            }

            $model->update($mainData);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update category: " . $e->getMessage());
        }
    }

    /**
     * Update the order of categories.
     *
     * @param array $orderedIds Array of category data with order and value
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

                $category = $this->findById($id);

                if (!$category) {
                    throw new \RuntimeException("Category with ID {$id} not found.");
                }

                // Update order for all categories regardless of parent_id
                $category->sort_order = $order;
                $category->save();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update category order: " . $e->getMessage());
        }
    }

    /**
     * Soft delete a category and destroy associated files if they exist.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function delete(string $id)
    {
        try {
            $model = $this->findById($id);

            // Remove image_path file if exists
            if ($model->image_path) {
                $this->removeFile('category', $model->image_path);
            }

            return $model->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to delete category: " . $e->getMessage());
        }
    }

    /**
     * Permanently delete a category (force delete).
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
            throw new \RuntimeException("Failed to force delete category: " . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted category.
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
            throw new \RuntimeException("Failed to restore category: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of categories based on specific request filters.
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
            throw new \RuntimeException("Failed to count categories: " . $e->getMessage());
        }
    }

    /**
     * Bulk delete categories by IDs.
     *
     * @param array $ids
     * @return bool
     * @throws \RuntimeException
     */
    public function bulkDelete(array $ids)
    {
        try {
            $categories = $this->model->whereIn('id', $ids)->get();
            foreach ($categories as $category) {
                if ($category->image_path) {
                    $this->removeFile('category', $category->image_path);
                }
            }
            return $this->model->whereIn('id', $ids)->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to bulk delete categories: " . $e->getMessage());
        }
    }

    /**
     * Bulk update categories.
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
            throw new \RuntimeException("Failed to bulk update categories: " . $e->getMessage());
        }
    }

    /**
     * Archive a category.
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
            throw new \RuntimeException("Failed to archive category: " . $e->getMessage());
        }
    }

    /**
     * Restore archived category.
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
            throw new \RuntimeException("Failed to restore archived category: " . $e->getMessage());
        }
    }

    /**
     * Check if a specific category exists.
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
            throw new \RuntimeException("Failed to check if category exists: " . $e->getMessage());
        }
    }

    /**
     * Update multiple categories by slugs.
     *
     * @param array $data
     * @param array $slugs
     * @return bool
     * @throws \RuntimeException
     */
    public function updateBySlugs(array $data, array $slugs)
    {
        try {
            return $this->model->whereIn('slug', $slugs)->update($data);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to update categories by slugs: " . $e->getMessage());
        }
    }

    /**
     * Delete multiple categories by slugs.
     *
     * @param array $slugs
     * @return bool
     * @throws \RuntimeException
     */
    public function deleteBySlugs(array $slugs)
    {
        try {
            $categories = $this->model->whereIn('slug', $slugs)->get();
            foreach ($categories as $category) {
                if ($category->image_path) {
                    $this->removeFile('category', $category->image_path);
                }
            }
            return $this->model->whereIn('slug', $slugs)->delete();
        } catch (Exception $e) {
            throw new \RuntimeException("Failed to delete categories by slugs: " . $e->getMessage());
        }
    }

    /**
     * Get the last sort order among parent categories for a given group.
     *
     * @param string $group
     * @return int|null
     * @throws \RuntimeException
     */
    public function getParentLastSortOrder(string $group)
    {
        try {
            return $this->model
                ->where('group', $group)
                ->whereNull('parent_id')
                ->max('sort_order');
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get parent last sort order: " . $e->getMessage());
        }
    }

    /**
     * Get the last sort order among child categories for a given group and parent.
     *
     * @param string $group
     * @param string|int $parentId
     * @return int|null
     * @throws \RuntimeException
     */
    public function getChildLastSortOrder(string $group, $parentId)
    {
        try {
            return $this->model
                ->where('group', $group)
                ->where('parent_id', $parentId)
                ->max('sort_order');
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get child last sort order: " . $e->getMessage());
        }
    }
}
