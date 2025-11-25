<?php

namespace Modules\Common\Services;

use App\Traits\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Modules\Common\Models\AppSetting;
use Illuminate\Support\Facades\Storage;

class AppSettingService
{
    use FileService;

    /**
     * The model instance for app setting.
     *
     * @var AppSetting
     */
    protected AppSetting $model;

    /**
     * Create a new AppSettingService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new AppSetting();
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
            return $this->model
                ->select('group', DB::raw('count(*) as count'))
                ->groupBy('group')
                ->when(!empty($exceptGroup), fn($query) => $query->whereNotIn('group', $exceptGroup))
                ->get()
                ->map(function ($item) {
                    return [
                        'group' => ($item->group),
                        'label' => str($item->group)->title(),
                        'count' => $item->count
                    ];
                })->toArray();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get tabs: " . $e->getMessage());
        }
    }

    /**
     * Get SEO tabs (pages) for settings, e.g. Homepage, About, etc.
     *
     * @param array $exceptGroup Groups to exclude from the results
     * @return array
     * @throws \RuntimeException
     */
    public function getSeoTabs(array $exceptGroup = []): array
    {
        try {
            // Get all unique page keys from SEO settings (e.g. seo_title_homepage, seo_description_about)
            $seoSettings = $this->model
                ->where('group', 'seo')
                ->when(!empty($exceptGroup), fn($query) => $query->whereNotIn('key', $exceptGroup))
                ->pluck('key')
                ->toArray();

            $pages = [];
            foreach ($seoSettings as $key) {
                // Extract the page part from the key, e.g. seo_title_homepage => homepage
                if (preg_match('/^seo_(title|description|image|keyword)_(.+)$/', $key, $matches)) {
                    $page = $matches[2];
                    $pages[$page] = true;
                }
            }

            // Build the tabs array
            $result = [];
            foreach (array_keys($pages) as $page) {
                $result[] = [
                    'group' => $page,
                    'label' => str($page)->replace('_', ' ')->title(),
                ];
            }

            return $result;
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get SEO tabs: " . $e->getMessage());
        }
    }

    /**
     * List all app settings with filters.
     *
     * @param array $request
     * @param int $total
     * @return Paginator
     * @throws \RuntimeException
     */
    public function paginatedListing(array $request, int $total = 10)
    {
        try {
            $query = $this->model->query()
                ->when($request['group'] ?? null, fn($q, $group) => $q->where('group', $group))
                ->when($request['keyword'] ?? null, function ($q, $keyword) {
                    return $q->where(function ($q) use ($keyword) {
                        $q->where('key', 'like', "%$keyword%")
                            ->orWhere('name', 'like', "%$keyword%");
                    });
                })
                ->when($request['sort'] ?? null, fn($q, $sort) => $q->orderBy($sort, $request['order'] ?? 'asc'));

            return $query->paginate($total);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to list app settings: " . $e->getMessage());
        }
    }

    /**
     * List all app settings.
     *
     * @param array $request
     * @return \Illuminate\Support\Collection
     * @throws \RuntimeException
     */
    public function listing(array $request)
    {
        try {
            $query = $this->model->newQuery()
                ->when(!empty($request['group']), fn($q) => $q->where('group', $request['group']))
                ->when(!empty($request['keyword']), function ($q) use ($request) {
                    $keyword = $request['keyword'];
                    $q->where(function ($q) use ($keyword) {
                        $q->where('key', 'like', "%$keyword%")
                            ->orWhere('name', 'like', "%$keyword%");
                    });
                })
                ->when(!empty($request['page']), function ($q) use ($request) {
                    $page = $request['page'];
                    $q->where('key', 'like', "%$page%");
                })
                ->when(!empty($request['sort']), fn($q) => $q->orderBy($request['sort'], $request['order'] ?? 'asc'));

            return $query->get()->map(function ($item) {
                $result = [
                    'id' => $item->id,
                    'group' => $item->group,
                    'key' => $item->key,
                    'display_key' => method_exists($item, 'getFormattedKey') ? $item->getFormattedKey() : $item->key,
                    'type' => $item->type,
                    'meta' => method_exists($item, 'getFormattedMeta') ? $item->getFormattedMeta() : $item->meta,
                    'name' => $item->name,
                    'value' => $item->value
                ];

                // If the type is an image input, optionally provide info for upload
                if (str_starts_with($item->type, 'input:image')) {
                    $result['uploaded_file'] = null;
                }

                return $result;
            });
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to list app settings: " . $e->getMessage());
        }
    }

    /**
     * Get a app setting by ID.
     *
     * @param string $id
     * @return AppSetting|null
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find app setting by ID: " . $e->getMessage());
        }
    }

    /**
     * Get a app setting by a specific column and value.
     *
     * @param string $column
     * @param string $value
     * @return AppSetting|null
     * @throws \RuntimeException
     */
    public function findByColumn(string $column, string $value)
    {
        try {
            return $this->model->where($column, $value)->first();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find app setting by column: " . $e->getMessage());
        }
    }

    /**
     * Create a new app setting.
     *
     * @param array $data
     * @return AppSetting
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            // Slugify 'group' and 'key' if present
            if (isset($data['group'])) {
                $data['group'] = str($data['group'])->slug('_')->toString();
            }
            if (isset($data['key'])) {
                $data['key'] = str($data['key'])->slug('_')->toString();
            }

            // Handle file upload for image type
            if (
                ($data['type'] ?? null) === 'input:image' &&
                isset($data['value']) &&
                $data['value'] instanceof \Illuminate\Http\UploadedFile
            ) {
                $data['value'] = '/storage' . $this->storeFile($data['value'], 'image');
            }

            $appSetting = $this->model->create($data);

            DB::commit();
            return $appSetting;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to create app setting: " . $e->getMessage());
        }
    }

    /**
     * Update an existing app setting.
     *
     * @param string $id
     * @param array $data
     * @return AppSetting
     * @throws \RuntimeException
     */
    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $model = $this->findById($id);

            if (!$model) {
                throw new \RuntimeException("App setting not found.");
            }

            // Slugify 'group' and 'key' if present
            if (isset($data['group'])) {
                $data['group'] = str($data['group'])->slug('_')->toString();
            }
            if (isset($data['key'])) {
                $data['key'] = str($data['key'])->slug('_')->toString();
            }

            // Handle file upload for image type
            if (
                $model->type === 'input:image' &&
                isset($data['value']) &&
                $data['value'] instanceof \Illuminate\Http\UploadedFile
            ) {
                // Remove old file if exists
                if (!empty($model->value)) {
                    $this->removeFile('image', $model->value);
                }
                $data['value'] = '/storage' . $this->storeFile($data['value'], 'image');
            }

            $model->update($data);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update app setting: " . $e->getMessage());
        }
    }

    /**
     * Soft delete an app setting and destroy associated file if it exists.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function delete(string $id)
    {
        try {
            $model = $this->findById($id);

            // Remove file if type is image
            if ($model && $model->type === 'input:image') {
                if (!empty($model->value)) {
                    $this->removeFile('image', $model->value);
                }
            }

            return $model->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to delete app setting: " . $e->getMessage());
        }
    }

    /**
     * Permanently delete a app setting (force delete).
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
            throw new \RuntimeException("Failed to force delete app setting: " . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted app setting.
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
            throw new \RuntimeException("Failed to restore app setting: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of app settings based on specific request filters.
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
            throw new \RuntimeException("Failed to count app settings: " . $e->getMessage());
        }
    }

    /**
     * Bulk delete app settings by IDs.
     *
     * @param array $ids
     * @return bool
     * @throws \RuntimeException
     */
    public function bulkDelete(array $ids)
    {
        try {
            // Remove images for all in ids if they are image type
            foreach ($this->model->whereIn('id', $ids)->get() as $setting) {
                if ($setting->type === 'input:image' && !empty($setting->value)) {
                    $this->removeFile('image', $setting->value);
                }
            }
            return $this->model->whereIn('id', $ids)->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to bulk delete app settings: " . $e->getMessage());
        }
    }

    /**
     * Bulk update app settings.
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
            throw new \RuntimeException("Failed to bulk update app settings: " . $e->getMessage());
        }
    }

    /**
     * Archive an app setting.
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
            throw new \RuntimeException("Failed to archive app setting: " . $e->getMessage());
        }
    }

    /**
     * Restore archived app setting.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function restoreArchived(string $id)
    {
        try {
            $model = $this->findById($id);
            $model->archived_at = false;
            return $model->save();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to restore archived app setting: " . $e->getMessage());
        }
    }

    /**
     * Check if a specific app setting exists.
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
            throw new \RuntimeException("Failed to check if app setting exists: " . $e->getMessage());
        }
    }

    /**
     * Update multiple app settings by keys.
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
            throw new \RuntimeException("Failed to update app settings by keys: " . $e->getMessage());
        }
    }

    /**
     * Delete multiple app settings by keys.
     *
     * @param array $keys
     * @return bool
     * @throws \RuntimeException
     */
    public function deleteByKeys(array $keys)
    {
        try {
            // Remove images for all in keys if they are image type
            foreach ($this->model->whereIn('key', $keys)->get() as $setting) {
                if ($setting->type === 'input:image' && !empty($setting->value)) {
                    $this->removeFile('image', $setting->value);
                }
            }
            return $this->model->whereIn('key', $keys)->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to delete app settings by keys: " . $e->getMessage());
        }
    }
}
