<?php

namespace Modules\Core\Services;

use Exception;
use Illuminate\Pagination\Paginator;
use App\Traits\FileService;
use Modules\Core\Models\Session;

class SessionService
{
    use FileService;

    /**
     * The model instance for session.
     *
     * @var Session
     */
    protected Session $model;

    /**
     * SessionService constructor.
     */
    public function __construct()
    {
        $this->model = new Session();
    }

    /**
     * List all sessions.
     *
     * @param array $request
     * @param int $total
     * @return Paginator
     * @throws \RuntimeException
     */
    public function listing(array $request, int $total = 10)
    {
        try {
            // Fetch and paginate session records
            return $this->model->query()
                ->when($request['keyword'] ?? null, fn($q, $keyword) => $q->search($keyword))
                ->when($request['sort'] ?? null, fn($q, $sort) => $q->sort($sort, $request['order'] ?? null))
                ->paginate($total);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to list sessions: " . $e->getMessage());
        }
    }

    /**
     * Get a session by ID.
     *
     * @param string $id
     * @return Session
     * @throws \RuntimeException
     */
    public function findById(string $id)
    {
        try {
            // Retrieve session by ID from database
            return $this->model->find($id);
        } catch (\Exception $e) {
            // Handle exception
            throw new \RuntimeException("Failed to find session by ID: " . $e->getMessage());
        }
    }
}