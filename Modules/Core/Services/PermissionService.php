<?php

namespace Modules\Core\Services;

use Exception;
use App\Traits\FileService;
use Modules\Core\App\Enums\Guards;
use Modules\Core\Models\Permission;
use Illuminate\Pagination\Paginator;

class PermissionService
{
    use FileService;

    /**
     * The model instance for permission.
     *
     * @var Permission
     */
    protected Permission $model;

    /**
     * PermissionService constructor.
     */
    public function __construct()
    {
        $this->model = new Permission();
    }

    /**
     * List all permissions.
     *
     * @param array $request
     * @param int $total
     * @return Paginator
     * @throws \RuntimeException
     */
    public function paginatedListing(array $request, int $total = 10)
    {
        try {
            // Fetch and paginate permission records
            $query = $this->model->query()
                ->when($request['keyword'] ?? null, fn($q, $keyword) => $q->search($keyword))
                ->when($request['sort'] ?? null, fn($q, $sort) => $q->sort($sort, $request['order'] ?? null))
                ->when(
                    !empty($request['guard_name']) && $request['guard_name'] !== 'all',
                    fn($q) => $q->where('guard_name', $request['guard_name'])
                );

            return $query->paginate($total);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to list permissions: " . $e->getMessage());
        }
    }

    /**
     * Generate guard-based tab counts.
     *
     * @return array
     */
    public function getGuardTabs(): array
    {
        $counts = $this->model->selectRaw('guard_name, COUNT(*) as count')
            ->groupBy('guard_name')
            ->pluck('count', 'guard_name');

        $guards = Guards::cases();

        $tabs = collect($guards)->map(function ($guard) use ($counts) {
            return [
                'id' => $guard->value,
                'label' => $guard->capitalized(),
                'count' => $counts[$guard->value] ?? 0,
            ];
        });

        return $tabs->prepend([
            'id' => 'all',
            'label' => 'All',
            'count' => $counts->sum(),
        ])->values()->toArray();
    }

    /**
     * Get a permission by ID.
     *
     * @param string $id
     * @return Permission
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            // Retrieve permission by ID from database
            return $this->model->find($id);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to find permission by ID: " . $e->getMessage());
        }
    }

    /**
     * Create a new permission.
     *
     * @param array $data
     * @return Permission
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        try {
            // Insert new permission into database
            return $this->model->create($data);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to create permission: " . $e->getMessage());
        }
    }

    /**
     * Update an existing permission.
     *
     * @param Permission $permission
     * @param array $data
     * @return Permission
     * @throws \RuntimeException
     */
    public function update(Permission $permission, array $data)
    {
        try {
            $permission->update($data);
            return $permission->refresh();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to update permission: " . $e->getMessage());
        }
    }

    /**
     * Delete a permission.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function delete(string $id)
    {
        try {
            // Delete permission from database
            $permission = $this->findById($id);

            if (!$permission) {
                throw new Exception('Permission not found, deletion failed.', 404); // Permission not found
            }

            return $permission->delete();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to delete permission: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of permissions based on specific request filters.
     *
     * @param array $request
     * @return int
     * @throws \RuntimeException
     */
    public function count(array $request)
    {
        try {
            // Count permission records with request
            return $this->model->where($request)->count();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to count permissions: " . $e->getMessage());
        }
    }
}
