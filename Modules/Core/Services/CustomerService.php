<?php

namespace Modules\Core\Services;

use Exception;
use Illuminate\Pagination\Paginator;
use App\Traits\FileService;
use Modules\Core\Models\Customer;

class CustomerService
{
    use FileService;

    /**
     * The model instance for customer.
     *
     * @var Customer
     */
    protected Customer $model;

    /**
     * CustomerService constructor.
     */
    public function __construct()
    {
        $this->model = new Customer();
    }

    /**
     * Paginate customers based on request.
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
            throw new \RuntimeException("Failed to paginate customers: " . $e->getMessage());
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
     * Get a customer by ID.
     *
     * @param string $id
     * @return Customer
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            // Retrieve customer by ID from database
            return $this->model->find($id);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to find customer by ID: " . $e->getMessage());
        }
    }

    /**
     * Get a customer by a specific column and value.
     *
     * @param string $column
     * @param string $value
     * @return Customer
     * @throws \RuntimeException
     */
    public function findByColumn(string $column, string $value)
    {
        try {
            // Query customer by column and value
            return $this->model->where($column, $value)->first();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to find customer by column: " . $e->getMessage());
        }
    }

    /**
     * Create a new customer.
     *
     * @param array $data
     * @return Customer
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        try {
            // Insert new customer into database
            $data['id'] = $this->model->generateId();
            $data['email_verified_at'] = $data['email_verified_at']  ? now() : null;

            $customer = $this->model->create($data);
            $customer->id = $data['id'];

            $customer->syncRoles($data['roles']);

            return $customer;
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to create customer: " . $e->getMessage());
        }
    }

    /**
     * Update an existing customer.
     *
     * @param Customer $customer
     * @param array $data
     * @return Customer
     * @throws \RuntimeException
     */
    public function update(Customer $customer, array $data)
    {
        try {
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            $data['email_verified_at'] = $data['email_verified_at'] === true  ? now() : null;

            $customer->update($data);
            $customer->syncRoles($data['roles']);

            return $customer;
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to update customer: " . $e->getMessage());
        }
    }

    /**
     * Soft delete a customer and destroy associated files if they exist.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function delete(string $id)
    {
        try {
            // Soft delete customer and remove files
            $customer = $this->findById($id);

            if (!$customer) {
                throw new Exception('Customer tidak ditemukan, customer gagal dihapus.', 404); // Customer not found
            }

            // Check if the customer has an avatar
            if ($customer->avatar) {
                // Remove existing avatar if needed
                $this->removeFile('images', $customer->avatar ?? '');
            }

            return $customer->delete();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to delete customer: " . $e->getMessage());
        }
    }

    /**
     * Permanently delete a customer (force delete).
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function forceDelete(string $id)
    {
        try {
            // Force delete customer from database
            return $this->model->where('id', $id)->forceDelete();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to force delete customer: " . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted customer.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function restore(string $id)
    {
        try {
            // Restore soft deleted customer
            return $this->model->withTrashed()->where('id', $id)->restore();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to restore customer: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of customers based on specific request filters.
     *
     * @param array $request
     * @return int
     * @throws \RuntimeException
     */
    public function count(array $request)
    {
        try {
            // Count customer records with request
            return $this->model->where($request)->count();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to count customers: " . $e->getMessage());
        }
    }

    /**
     * Bulk delete customers by IDs.
     *
     * @param array $ids
     * @return bool
     * @throws \RuntimeException
     */
    public function bulkDelete(array $ids)
    {
        try {
            // Bulk soft delete customers by IDs
            return $this->model->whereIn('id', $ids)->delete();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to bulk delete customers: " . $e->getMessage());
        }
    }

    /**
     * Bulk update customers.
     *
     * @param array $data
     * @param array $ids
     * @return bool
     * @throws \RuntimeException
     */
    public function bulkUpdate(array $data, array $ids)
    {
        try {
            // Bulk update customer records
            return $this->model->whereIn('id', $ids)->update($data);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to bulk update customers: " . $e->getMessage());
        }
    }

    /**
     * Check if a specific customer exists.
     *
     * @param string $id
     * @return bool
     * @throws \RuntimeException
     */
    public function isExists(string $id)
    {
        try {
            // Check if customer exists in database
            return $this->model->where('id', $id)->exists();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to check if customer exists: " . $e->getMessage());
        }
    }

    /**
     * Update multiple customers by keys.
     *
     * @param array $data
     * @param array $keys
     * @return bool
     * @throws \RuntimeException
     */
    public function updateByKeys(array $data, array $keys)
    {
        try {
            // Update customer records by keys
            return $this->model->whereIn('key', $keys)->update($data);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to update customers by keys: " . $e->getMessage());
        }
    }

    /**
     * Delete multiple customers by keys.
     *
     * @param array $keys
     * @return bool
     * @throws \RuntimeException
     */
    public function deleteByKeys(array $keys)
    {
        try {
            // Delete customer records by keys
            return $this->model->whereIn('key', $keys)->delete();
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to delete customers by keys: " . $e->getMessage());
        }
    }

    /**
     * Update customer profile.
     *
     * @param Customer $customer
     * @param array $data
     * @return bool
     * @throws \RuntimeException
     */
    public function updateProfile(Customer $customer, array $data)
    {
        try {
            if (!empty($data['avatar'])) {
                $data['avatar'] = $this->storeFileFromBase64($data['avatar'], 'images', 400);
                $this->removeFile('images', $data['oldAvatar'] ?? null);
            }
            $customer->update(array_filter($data));

            return true;
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to update customer profile: " . $e->getMessage());
        }
    }

    /**
     * Update customer password.
     *
     * @param string $id
     * @param Customer $customer
     * @return bool
     * @throws \RuntimeException
     */
    public function updatePassword(Customer $customer, array $data)
    {
        try {
            $data['password'] =  $data['password'] ? bcrypt($data['password']) : null;
            return $customer->update(array_filter($data));
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to update customer password: " . $e->getMessage());
        }
    }
}
