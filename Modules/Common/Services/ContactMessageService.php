<?php

namespace Modules\Common\Services;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Common\Models\ContactMessage;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Common\Transformers\TransformerResult;
use Modules\Common\Transformers\ContactMessageTransformer;

class ContactMessageService
{
    /**
     * The model instance for contact message.
     *
     * @var ContactMessage
     */
    protected ContactMessage $model;

    /**
     * Create a new ContactMessageService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new ContactMessage();
    }

    /**
     * Build the base query for listing contact messages with filters.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildListingQuery(array $request)
    {
        $query = $this->model->newQuery()
            // Keyword search (search in name, email, subject, message)
            ->when(!empty($request['keyword']), function ($q) use ($request) {
                $q->search($request['keyword']);
            })
            // Seen/unseen filter
            ->when(isset($request['seen']), function ($q) use ($request) {
                if ($request['seen']) {
                    $q->whereNotNull('seen_at');
                } else {
                    $q->whereNull('seen_at');
                }
            })
            // Date range filter
            ->when(!empty($request['date_from']), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request['date_from']);
            })
            ->when(!empty($request['date_to']), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request['date_to']);
            });

        // Sorting
        if (!empty($request['sort'])) {
            $query->orderBy($request['sort'], $request['order'] ?? 'asc');
        } else {
            $query->orderByDesc('created_at');
        }

        return $query;
    }

    /**
     * List contact messages with optional pagination and filters.
     *
     * @param array $request
     * @param bool $paginate
     * @return Collection|LengthAwarePaginator
     * @throws \RuntimeException
     */
    public function listing(array $request = [], bool $paginate = false)
    {
        try {
            $query = $this->buildListingQuery($request);

            if ($paginate) {
                $perPage = isset($request['per_page']) && is_numeric($request['per_page']) ? (int)$request['per_page'] : 15;
                $paginator = $query->paginate($perPage);

                // Transform each item in the paginator
                $paginator->getCollection()->transform(function ($item) {
                    return ContactMessageTransformer::transform($item)->toModel();
                });

                return $paginator;
            }

            $collection = $query->get();

            // Transform each item in the collection
            return $collection->map(function ($item) {
                return ContactMessageTransformer::transform($item)->toModel();
            });
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to list contact messages: " . $e->getMessage());
        }
    }

    /**
     * Get a contact message by ID.
     *
     * @param int $id
     * @return ContactMessage|null
     * @throws \RuntimeException
     */
    public function findById(int $id)
    {
        try {
            $model = $this->model->find($id);
            return $model ? ContactMessageTransformer::transform($model)->toModel() : null;
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find contact message by ID: " . $e->getMessage());
        }
    }

    /**
     * Create a new contact message.
     *
     * @param array $data
     * @return ContactMessage
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $contactMessage = $this->model->create($data);
            DB::commit();
            return $contactMessage;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to create contact message: " . $e->getMessage());
        }
    }

    /**
     * Update an existing contact message.
     *
     * @param int $id
     * @param array $data
     * @return ContactMessage
     * @throws \RuntimeException
     */
    public function update(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $model = $this->model->find($id);

            if (!$model) {
                throw new \RuntimeException("Contact message not found.");
            }

            $model->update($data);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update contact message: " . $e->getMessage());
        }
    }

    /**
     * Mark a contact message as seen.
     *
     * @param int $id
     * @param string|null $seenBy
     * @return ContactMessage
     * @throws \RuntimeException
     */
    public function markAsSeen(int $id, ?string $seenBy = null)
    {
        DB::beginTransaction();
        try {
            $model = $this->model->find($id);

            if (!$model) {
                throw new \RuntimeException("Contact message not found.");
            }

            $model->seen_at = now();
            $model->seen_by = $seenBy;
            $model->save();

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to mark contact message as seen: " . $e->getMessage());
        }
    }

    /**
     * Mark a contact message as unseen.
     *
     * @param int $id
     * @return ContactMessage|null
     * @throws \RuntimeException
     */
    public function markAsUnseen(int $id)
    {
        DB::beginTransaction();
        try {
            $model = $this->model->find($id);

            if (!$model) {
                throw new \RuntimeException("Contact message not found.");
            }

            $model->seen_at = null;
            $model->seen_by = null;
            $model->save();

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to mark contact message as unseen: " . $e->getMessage());
        }
    }

    /**
     * Delete a contact message.
     *
     * @param int $id
     * @return bool
     * @throws \RuntimeException
     */
    public function delete(int $id)
    {
        try {
            $model = $this->model->find($id);
            if (!$model) {
                throw new \RuntimeException("Contact message not found.");
            }
            return $model->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to delete contact message: " . $e->getMessage());
        }
    }

    /**
     * Bulk delete contact messages by IDs.
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
            throw new \RuntimeException("Failed to bulk delete contact messages: " . $e->getMessage());
        }
    }

    /**
     * Bulk update contact messages.
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
            throw new \RuntimeException("Failed to bulk update contact messages: " . $e->getMessage());
        }
    }

    /**
     * Check if a specific contact message exists.
     *
     * @param int $id
     * @return bool
     * @throws \RuntimeException
     */
    public function isExists(int $id)
    {
        try {
            return $this->model->where('id', $id)->exists();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to check if contact message exists: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of contact messages based on specific request filters.
     *
     * @param array $request
     * @return int
     * @throws \RuntimeException
     */
    public function count(array $request = [])
    {
        try {
            $query = $this->model->newQuery();

            if (!empty($request['seen'])) {
                if ($request['seen']) {
                    $query->whereNotNull('seen_at');
                } else {
                    $query->whereNull('seen_at');
                }
            }

            return $query->count();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to count contact messages: " . $e->getMessage());
        }
    }

    /**
     * Get the last sort order among all contact messages.
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
