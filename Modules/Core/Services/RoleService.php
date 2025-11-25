<?php

namespace Modules\Core\Services;

use Exception;
use App\Traits\FileService;
use Modules\Core\Models\Role;
use Modules\Core\App\Enums\Guards;
use Illuminate\Pagination\Paginator;

class RoleService
{
    use FileService;

    /**
     * The model instance for role.
     *
     * @var Role
     */
    protected Role $model;

    /**
     * RoleService constructor.
     */
    public function __construct()
    {
        $this->model = new Role();
    }

    /**
     * Paginate roles based on request.
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
                ->withCount('permissions')
                ->when($request['keyword'] ?? null, fn($q, $keyword) => $q->search($keyword))
                ->when($request['sort'] ?? null, fn($q, $sort) => $q->sort($sort, $request['order'] ?? null))
                ->when(
                    !empty($request['guard_name']) && $request['guard_name'] !== 'all',
                    fn($q) => $q->where('guard_name', $request['guard_name'])
                );

            return $query->paginate($total);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to paginate roles: " . $e->getMessage());
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
     * Get roles by guard name.
     *
     * @param string $guardName
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \RuntimeException
     */
    public function getRolesByGuard(string $guardName)
    {
        try {
            $user = auth('web')->user()->hasRole('Developer');
            return $this->model
                ->where('guard_name', $guardName)
                ->when(!$user, fn($query) => $query->where('name', '!=', 'Developer'))
                ->get();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get roles by guard: " . $e->getMessage());
        }
    }

    /**
     * Get a role by ID.
     *
     * @param string $id
     * @return Role
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            // Retrieve role by ID from database
            return $this->model->find($id);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to find role by ID: " . $e->getMessage());
        }
    }

    /**
     * Create a new role.
     *
     * @param array $data
     * @return Role
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        try {
            // Insert new role into database
            $role = $this->model->create($data);
            $role->syncPermissions($data['permissions']);
            return $role;
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to create role: " . $e->getMessage());
        }
    }

    /**
     * Update an existing role.
     *
     * @param Role $role
     * @param array $data
     * @return Role
     * @throws \RuntimeException
     */
    public function update(Role $role, array $data)
    {
        try {
            $role->update($data);
            $role->syncPermissions($data['permissions']);
            return $role->refresh();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to update role: " . $e->getMessage());
        }
    }

    /**
     * Delete a role.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function delete(string $id)
    {
        try {
            // Delete role from database
            $role = $this->findById($id);

            if (!$role) {
                throw new Exception('Role not found, deletion failed.', 404); // Role not found
            }

            return $role->delete();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to delete role: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of roles based on specific request filters.
     *
     * @param array $request
     * @return int
     * @throws \RuntimeException
     */
    public function count(array $request)
    {
        try {
            // Count role records with request
            return $this->model->where($request)->count();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to count roles: " . $e->getMessage());
        }
    }
}