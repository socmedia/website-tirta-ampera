<?php

namespace Modules\Common\Services;

use Exception;
use Modules\Common\Models\Faq;
use Illuminate\Support\Facades\DB;

class FaqService
{
    /**
     * The model instance for faq.
     *
     * @var Faq
     */
    protected Faq $model;

    /**
     * Create a new FaqService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Faq();
    }

    /**
     * Get FAQs grouped by active status with count.
     *
     * @return array
     * @throws \RuntimeException
     */
    public function getTabs(): array
    {
        try {
            $counts = $this->model->newQuery()
                ->selectRaw('COUNT(*) as all_count')
                ->selectRaw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active_count')
                ->selectRaw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as inactive_count')
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
            throw new \RuntimeException("Failed to get FAQ tabs: " . $e->getMessage());
        }
    }

    /**
     * Build the base query for listing FAQs with category info.
     *
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildListingQuery(array $request)
    {
        return $this->model->newQuery()
            ->select([
                'faqs.id',
                'faqs.category_id',
                'faqs.question',
                'faqs.answer',
                'faqs.slug',
                'faqs.sort_order',
                'faqs.featured',
                'faqs.status',
                'faqs.created_at',
                'faqs.updated_at',
            ])
            ->when(!empty($request['category_id']), fn($q) => $q->where('faqs.category_id', $request['category_id']))
            ->when(isset($request['status']), function ($q) use ($request) {
                if ($request['status'] === 'active') {
                    $q->where('faqs.status', 1);
                } elseif ($request['status'] === 'inactive') {
                    $q->where('faqs.status', 0);
                }
            })
            ->when(!empty($request['keyword']), function ($q) use ($request) {
                $q->where(function ($qr) use ($request) {
                    $keyword = $request['keyword'];
                    $qr->where('faqs.question', 'like', '%' . $keyword . '%')
                        ->orWhere('faqs.answer', 'like', '%' . $keyword . '%');
                });
            })
            ->when(!empty($request['sort']), fn($q) => $q->orderBy('faqs.' . $request['sort'], $request['order'] ?? 'asc'));
    }

    /**
     * List FAQs with optional pagination.
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
                return $query->paginate($perPage);
            }

            return $query->get();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to list FAQs: " . $e->getMessage());
        }
    }

    /**
     * Get published FAQs for public view.
     *
     * @param array $filters
     * @param bool $paginate
     * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     * @throws \RuntimeException
     */
    public function publicFaqs(array $filters = [], bool $paginate = false)
    {
        try {
            $query = $this->model
                ->select([
                    'faqs.id',
                    'faqs.category_id',
                    'faqs.question',
                    'faqs.answer',
                    'faqs.slug',
                    'faqs.sort_order',
                    'faqs.featured',
                    'faqs.status',
                    'faqs.created_at',
                    'faqs.updated_at',
                    'faqs.deleted_at',
                ])
                ->where('faqs.status', 1)
                ->whereNull('faqs.deleted_at')
                ->when(!empty($filters['except_id']), fn($q) => $q->where('faqs.id', '!=', $filters['except_id']))
                ->when(!empty($filters['category']), fn($q) => $q->where('faqs.category_id', $filters['category']))
                ->when(!empty($filters['keyword']), function ($q) use ($filters) {
                    $keyword = $filters['keyword'];
                    $q->where(function ($qr) use ($keyword) {
                        $qr->where('faqs.question', 'like', '%' . $keyword . '%')
                            ->orWhere('faqs.answer', 'like', '%' . $keyword . '%');
                    });
                });

            if (!empty($filters['sort_option'])) {
                switch ($filters['sort_option']) {
                    case 'newest':
                        $query->orderBy('faqs.created_at', 'desc');
                        break;
                    case 'oldest':
                        $query->orderBy('faqs.created_at', 'asc');
                        break;
                    case 'question-asc':
                        $query->orderBy('faqs.question', 'asc');
                        break;
                    case 'question-desc':
                        $query->orderBy('faqs.question', 'desc');
                        break;
                    default:
                        $query->orderBy('faqs.created_at', 'desc');
                }
            } else {
                $query->orderBy('faqs.created_at', 'desc');
            }

            $perPage = isset($filters['per_page']) && is_numeric($filters['per_page']) ? (int)$filters['per_page'] : 15;

            if ($paginate) {
                return $query->paginate($perPage);
            }

            return $query->limit($perPage)->get();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get published FAQs: " . $e->getMessage());
        }
    }

    /**
     * Get a FAQ by ID.
     *
     * @param string $id
     * @return Faq|null
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to find FAQ by ID: " . $e->getMessage());
        }
    }

    /**
     * Create a new FAQ.
     *
     * @param array $data
     * @return Faq
     * @throws \RuntimeException
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            if (!isset($data['sort_order'])) {
                $lastSortOrder = $this->getLastSortOrder();
                $data['sort_order'] = is_null($lastSortOrder) ? 1 : $lastSortOrder + 1;
            }

            $faq = $this->model->create($data);

            DB::commit();
            return $faq;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to create FAQ: " . $e->getMessage());
        }
    }

    /**
     * Update an existing FAQ.
     *
     * @param string $id
     * @param array $data
     * @return Faq
     * @throws \RuntimeException
     */
    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $model = $this->findById($id);

            if (!$model) {
                throw new \RuntimeException("FAQ not found.");
            }

            $model->update($data);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update FAQ: " . $e->getMessage());
        }
    }

    /**
     * Update the order of FAQs.
     *
     * @param array $orderedIds Array of FAQ data with order and value
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

                $faq = $this->findById($id);

                if (!$faq) {
                    throw new \RuntimeException("FAQ with ID {$id} not found.");
                }

                $faq->sort_order = $order;
                $faq->save();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \RuntimeException("Failed to update FAQ order: " . $e->getMessage());
        }
    }

    /**
     * Soft delete a FAQ.
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
            throw new \RuntimeException("Failed to delete FAQ: " . $e->getMessage());
        }
    }

    /**
     * Permanently delete a FAQ (force delete).
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
            throw new \RuntimeException("Failed to force delete FAQ: " . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted FAQ.
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
            throw new \RuntimeException("Failed to restore FAQ: " . $e->getMessage());
        }
    }

    /**
     * Count the total number of FAQs based on specific request filters.
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
            throw new \RuntimeException("Failed to count FAQs: " . $e->getMessage());
        }
    }

    /**
     * Bulk delete FAQs by IDs.
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
            throw new \RuntimeException("Failed to bulk delete FAQs: " . $e->getMessage());
        }
    }

    /**
     * Bulk update FAQs.
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
            throw new \RuntimeException("Failed to bulk update FAQs: " . $e->getMessage());
        }
    }

    /**
     * Check if a specific FAQ exists.
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
            throw new \RuntimeException("Failed to check if FAQ exists: " . $e->getMessage());
        }
    }

    /**
     * Get the last sort order among all FAQs.
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
