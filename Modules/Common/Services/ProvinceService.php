<?php

namespace Modules\Common\Services;

use RuntimeException;
use Modules\Common\Models\Province;

class ProvinceService
{
    /**
     * The model instance.
     *
     * @var Province
     */
    protected Province $model;

    /**
     * Create a new ProvinceService instance.
     */
    public function __construct()
    {
        $this->model = new Province();
    }

    /**
     * Get all provinces.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Province[]
     */
    public function getAllProvinces()
    {
        try {
            return $this->model->orderBy('name')->get();
        } catch (\Exception $e) {
            throw new RuntimeException("Failed to get provinces: " . $e->getMessage());
        }
    }

    /**
     * Find province by ID.
     *
     * @param string $id
     * @return Province|null
     */
    public function findById(string $id)
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            throw new RuntimeException("Failed to find province by ID: " . $e->getMessage());
        }
    }

    /**
     * Find province by name.
     *
     * @param string $name
     * @return Province|null
     */
    public function findByName(string $name)
    {
        try {
            return $this->model->where('name', 'like', $name)->first();
        } catch (\Exception $e) {
            throw new RuntimeException("Failed to find province by name: " . $e->getMessage());
        }
    }

    /**
     * Search provinces with pagination.
     *
     * @param string|null $keyword
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(?string $keyword = null, int $perPage = 15)
    {
        try {
            $query = $this->model->query();

            if ($keyword) {
                $query->where('name', 'like', "%$keyword%");
            }

            return $query->orderBy('name')->paginate($perPage);
        } catch (\Exception $e) {
            throw new RuntimeException("Failed to paginate provinces: " . $e->getMessage());
        }
    }
}
