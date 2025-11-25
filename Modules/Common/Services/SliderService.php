<?php

namespace Modules\Common\Services;

use Exception;
use Illuminate\Http\File;
use App\Traits\FileService;
use Modules\Common\Models\Slider;
use Illuminate\Support\Facades\DB;
use Modules\Common\Transformers\SliderTransformer;
use Modules\Common\Enums\SliderType;

class SliderService
{
    use FileService;

    /**
     * The model instance for slider.
     *
     * @var Slider
     */
    protected Slider $model;

    /**
     * Create a new SliderService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Slider();
    }

    /**
     * Get tabs grouped by group column with count.
     *
     * @param array $exceptGroup Groups to exclude from the results
     * @return array
     * @throws \RuntimeException
     */
    public function getTabs(array $exceptGroup = []): array
    {
        try {
            // Step 1: Get enum-based tab definitions
            $enumTabs = collect(SliderType::cases())
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
     * Build the base query for listing sliders.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildListingQuery(array $request)
    {
        return $this->model->newQuery()
            ->select([
                'sliders.id',
                'sliders.type',
                'sliders.heading',
                'sliders.sub_heading',
                'sliders.description',
                'sliders.alt',
                'sliders.desktop_media_path',
                'sliders.mobile_media_path',
                'sliders.sort_order',
                'sliders.status',
                'sliders.created_by',
                'sliders.updated_by',
                'sliders.created_at',
                'sliders.updated_at',
                'sliders.meta',
            ])
            // Filter by type if provided
            ->when(!empty($request['type']) && $request['type'] !== 'all', fn($q) => $q->where('sliders.type', $request['type']))
            // Filter by status if provided
            ->when(isset($request['status']), function ($q) use ($request) {
                if ($request['status'] === 'active') {
                    $q->where('sliders.status', 1);
                } elseif ($request['status'] === 'inactive') {
                    $q->where('sliders.status', 0);
                }
            })
            // Sort if sort field provided
            ->when(!empty($request['sort']), fn($q) => $q->orderBy('sliders.' . $request['sort'], $request['order'] ?? 'asc'));
    }

    /**
     * List sliders with optional pagination.
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
                $paginator->getCollection()->transform(fn($item) => SliderTransformer::transform($item)->toModel());
                return $paginator;
            }

            return $query->get()->map(fn($item) => SliderTransformer::transform($item)->toModel());
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to list sliders: " . $e->getMessage());
        }
    }

    /**
     * Get all sliders.
     *
     * @param string|null $type
     * @return \Illuminate\Support\Collection
     * @throws \RuntimeException
     */
    public function getPublicSlider(?string $type = null)
    {
        try {
            $query = $this->model
                ->select([
                    'sliders.id',
                    'sliders.type',
                    'sliders.heading',
                    'sliders.sub_heading',
                    'sliders.description',
                    'sliders.alt',
                    'sliders.desktop_media_path',
                    'sliders.mobile_media_path',
                    'sliders.sort_order',
                    'sliders.status',
                    'sliders.created_by',
                    'sliders.updated_by',
                    'sliders.created_at',
                    'sliders.updated_at',
                    'sliders.meta',
                ])
                ->where('sliders.status', 1);

            if (!empty($type)) {
                $query->where('sliders.type', $type);
            }

            $sliders = $query->orderBy('sliders.sort_order')->get();

            return $sliders->map(function ($slider) {
                return SliderTransformer::transform($slider)->toModel();
            });
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to fetch sliders: " . $e->getMessage(), 500, $e);
        }
    }

    /**
     * Get a slider by ID.
     *
     * @param string $id
     * @return array|null
     * @throws \RuntimeException
     */
    public function findByIdWithAll(string $id)
    {
        try {
            $slider = $this->model
                ->select([
                    'sliders.id',
                    'sliders.type',
                    'sliders.heading',
                    'sliders.sub_heading',
                    'sliders.description',
                    'sliders.alt',
                    'sliders.desktop_media_path',
                    'sliders.mobile_media_path',
                    'sliders.sort_order',
                    'sliders.status',
                    'sliders.created_by',
                    'sliders.updated_by',
                    'sliders.created_at',
                    'sliders.updated_at',
                    'sliders.meta',
                ])
                ->where('sliders.id', $id)
                ->first();

            if (!$slider) {
                throw new \RuntimeException("Slider not found with ID: {$id}");
            }

            return SliderTransformer::transform($slider)->toArray();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find slider by ID: " . $e->getMessage());
        }
    }

    /**
     * Get a slider by ID.
     *
     * @param string $id
     * @return Slider|null
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find slider by ID: " . $e->getMessage());
        }
    }

    /**
     * Create a new slider.
     *
     * @param array $data
     * @return Slider
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $mainData = $data;

            // Handle meta for slider (mainData)
            if (isset($mainData['meta']) && is_array($mainData['meta'])) {
                $mainData['meta'] = json_encode($mainData['meta']);
            }

            // Store desktop media path using FileService if present
            if (isset($mainData['desktop_media_path']) && is_array($mainData['desktop_media_path']) && !empty($mainData['desktop_media_path'][0])) {
                $file = new File($mainData['desktop_media_path'][0]['path']);
                $mainData['desktop_media_path'] = $this->storeFile($file, 'image');
            }

            // Fix sort order: set sort_order to last+1 if not provided
            if (!isset($mainData['sort_order'])) {
                $lastSortOrder = $this->getLastSortOrder();
                $mainData['sort_order'] = is_null($lastSortOrder) ? 1 : $lastSortOrder + 1;
            }

            $slider = $this->model->create($mainData);

            DB::commit();
            return $slider;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to create slider: " . $e->getMessage());
        }
    }

    /**
     * Update an existing slider.
     *
     * @param string $id
     * @param array $data
     * @return Slider
     * @throws \RuntimeException
     */
    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $model = $this->findById($id);

            if (!$model) {
                throw new \RuntimeException("Slider not found.");
            }

            $mainData = $data;

            // Handle meta for slider (mainData)
            if (isset($mainData['meta']) && is_array($mainData['meta'])) {
                $mainData['meta'] = json_encode($mainData['meta']);
            }

            // Remove old image if a new desktop_media_path is provided
            if (
                isset($mainData['desktop_media_path']) && !empty($mainData['desktop_media_path'][0])
            ) {
                // Remove old image if exists
                $this->removeFile('image', $model->desktop_media_path);

                $file = new File($mainData['desktop_media_path'][0]['path']);
                $mainData['desktop_media_path'] = $this->storeFile($file, 'image');
            }

            // Remove old_desktop_media_path from data if present
            if (isset($mainData['old_desktop_media_path'])) {
                unset($mainData['old_desktop_media_path']);
            }

            $model->update($mainData);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update slider: " . $e->getMessage());
        }
    }

    /**
     * Update the order of sliders.
     *
     * @param array $orderedIds Array of slider data with order and value
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

                $slider = $this->findById($id);

                if (!$slider) {
                    throw new \RuntimeException("Slider with ID {$id} not found.");
                }

                $slider->sort_order = $order;
                $slider->save();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update slider order: " . $e->getMessage());
        }
    }

    /**
     * Soft delete a slider.
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
            throw new \RuntimeException("Failed to delete slider: " . $e->getMessage());
        }
    }

    /**
     * Permanently delete a slider (force delete).
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
            throw new \RuntimeException("Failed to force delete slider: " . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted slider.
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
            throw new \RuntimeException("Failed to restore slider: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of sliders based on specific request filters.
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
            throw new \RuntimeException("Failed to count sliders: " . $e->getMessage());
        }
    }

    /**
     * Bulk delete sliders by IDs.
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
            throw new \RuntimeException("Failed to bulk delete sliders: " . $e->getMessage());
        }
    }

    /**
     * Bulk update sliders.
     *
     * @param array $data
     * @param array $ids
     * @return bool
     * @throws \RuntimeException
     */
    public function bulkUpdate(array $data, array $ids)
    {
        try {
            // Handle meta for slider (mainData)
            if (isset($data['meta']) && is_array($data['meta'])) {
                $data['meta'] = json_encode($data['meta']);
            }
            return $this->model->whereIn('id', $ids)->update($data);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to bulk update sliders: " . $e->getMessage());
        }
    }

    /**
     * Check if a specific slider exists.
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
            throw new \RuntimeException("Failed to check if slider exists: " . $e->getMessage());
        }
    }

    /**
     * Get the last sort order among all sliders.
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
