<?php

namespace Modules\Core\Services;

use Exception;
use Illuminate\Pagination\Paginator;
use App\Traits\FileService;
use Modules\Core\Models\User;

class UserService
{
    use FileService;

    /**
     * The model instance for user.
     *
     * @var User
     */
    protected User $model;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * Paginate users based on request.
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
                ->with('roles:id,name')
                ->search($request['keyword'])
                ->when($request['keyword'] ?? null, fn($q, $keyword) => $q->search($keyword))
                ->when($request['sort'] ?? null, fn($q, $sort) => $q->sort($sort, $request['order'] ?? null));

            return $query->paginate($total);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to paginate users: " . $e->getMessage());
        }
    }

    /**
     * Generate guard-based tab counts.
     *
     * @return array
     */
    public function getGuardTabs(): array
    {
        // $counts = $this->model->selectRaw('guard_name, COUNT(*) as count')
        //     ->groupBy('guard_name')
        //     ->pluck('count', 'guard_name');

        // $guards = Guards::cases();

        $tabs = collect([])->map(function ($guard) {
            return [
                'id' => $guard->value,
                'label' => $guard->capitalized(),
                // 'count' => $counts[$guard->value] ?? 0,
            ];
        });

        return $tabs->prepend([
            'id' => 'all',
            'label' => 'All',
            // 'count' => $counts->sum(),
        ])->values()->toArray();
    }

    /**
     * Get a user by ID.
     *
     * @param string $id
     * @return User
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            // Retrieve user by ID from database
            return $this->model->find($id);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to find user by ID: " . $e->getMessage());
        }
    }

    /**
     * Get a user by a specific column and value.
     *
     * @param string $column
     * @param string $value
     * @return User
     * @throws \RuntimeException
     */
    public function findByColumn(string $column, string $value)
    {
        try {
            // Query user by column and value
            return $this->model->where($column, $value)->first();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to find user by column: " . $e->getMessage());
        }
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        try {
            // Insert new user into database
            $data['id'] = $this->model->generateId();
            $data['email_verified_at'] = $data['email_verified_at']  ? now() : null;

            $user = $this->model->create($data);
            $user->id = $data['id'];

            $user->syncRoles($data['roles']);

            return $user;
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to create user: " . $e->getMessage());
        }
    }

    /**
     * Update an existing user.
     *
     * @param User $user
     * @param array $data
     * @return User
     * @throws \RuntimeException
     */
    public function update(User $user, array $data)
    {
        try {
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            $data['email_verified_at'] = $data['email_verified_at'] === true  ? now() : null;

            $user->update($data);
            $user->syncRoles($data['roles']);

            return $user;
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to update user: " . $e->getMessage());
        }
    }

    /**
     * Soft delete a user and destroy associated files if they exist.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function delete(string $id)
    {
        try {
            // Soft delete user and remove files
            $user = $this->findById($id);

            if (!$user) {
                throw new Exception('User tidak ditemukan, user gagal dihapus.', 404); // User not found
            }

            // Check if the user has an avatar
            if ($user->avatar) {
                // Remove existing avatar if needed
                $this->removeFile('images', $user->avatar ?? '');
            }

            return $user->delete();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to delete user: " . $e->getMessage());
        }
    }

    /**
     * Permanently delete a user (force delete).
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function forceDelete(string $id)
    {
        try {
            // Force delete user from database
            return $this->model->where('id', $id)->forceDelete();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to force delete user: " . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted user.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function restore(string $id)
    {
        try {
            // Restore soft deleted user
            return $this->model->withTrashed()->where('id', $id)->restore();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to restore user: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of users based on specific request filters.
     *
     * @param array $request
     * @return int
     * @throws \RuntimeException
     */
    public function count(array $request)
    {
        try {
            // Count user records with request
            return $this->model->where($request)->count();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to count users: " . $e->getMessage());
        }
    }

    /**
     * Bulk delete users by IDs.
     *
     * @param array $ids
     * @return bool
     * @throws \RuntimeException
     */
    public function bulkDelete(array $ids)
    {
        try {
            // Bulk soft delete users by IDs
            return $this->model->whereIn('id', $ids)->delete();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to bulk delete users: " . $e->getMessage());
        }
    }

    /**
     * Bulk update users.
     *
     * @param array $data
     * @param array $ids
     * @return bool
     * @throws \RuntimeException
     */
    public function bulkUpdate(array $data, array $ids)
    {
        try {
            // Bulk update user records
            return $this->model->whereIn('id', $ids)->update($data);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to bulk update users: " . $e->getMessage());
        }
    }

    /**
     * Check if a specific user exists.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function isExists(string $id)
    {
        try {
            // Check if user exists in database
            return $this->model->where('id', $id)->exists();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to check if user exists: " . $e->getMessage());
        }
    }

    /**
     * Update multiple users by keys.
     *
     * @param array $data
     * @param array $keys
     * @return bool
     * @throws \RuntimeException
     */
    public function updateByKeys(array $data, array $keys)
    {
        try {
            // Update user records by keys
            return $this->model->whereIn('key', $keys)->update($data);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to update users by keys: " . $e->getMessage());
        }
    }

    /**
     * Delete multiple users by keys.
     *
     * @param array $keys
     * @return bool
     * @throws \RuntimeException
     */
    public function deleteByKeys(array $keys)
    {
        try {
            // Delete user records by keys
            return $this->model->whereIn('key', $keys)->delete();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to delete users by keys: " . $e->getMessage());
        }
    }

    /**
     * Update user profile.
     *
     * @param User $user
     * @param array $data
     * @return bool
     * @throws \RuntimeException
     */
    public function updateProfile(User $user, array $data)
    {
        try {
            if (!empty($data['avatar'])) {
                $data['avatar'] = $this->storeFileFromBase64($data['avatar'], 'images', 400);
                $this->removeFile('images', $data['oldAvatar'] ?? null);
            }
            $user->update(array_filter($data));

            return true;
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to update user profile: " . $e->getMessage());
        }
    }

    /**
     * Update user password.
     *
     * @param string $id
     * @param User $user
     * @return bool
     * @throws \RuntimeException
     */
    public function updatePassword(User $user, array $data)
    {
        try {
            $data['password'] =  $data['password'] ? bcrypt($data['password']) : null;
            return $user->update(array_filter($data));
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to update user password: " . $e->getMessage());
        }
    }
}