<?php

namespace App\Services;

use App\Core\DuplicateRecordException;
use App\Repositories\OrderRepository;

class OrderService
{
    private OrderRepository $repository;

    public function __construct()
    {
        $this->repository = new OrderRepository();
    }

    public function list(string $keyword, int $page, int $limit): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;

        $orders = $this->repository->paginate($keyword, $limit, $offset);
        $total = $this->repository->count($keyword);
        $totalPages = max(1, (int) ceil($total / $limit));

        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
            $orders = $this->repository->paginate($keyword, $limit, $offset);
        }

        return [
            'orders' => $orders,
            'page' => $page,
            'totalPages' => $totalPages,
        ];
    }

    public function find(int $id): ?array
    {
        return $this->repository->find($id);
    }

    public function create(array $data): array
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $this->repository->create($data);

            return ['success' => true, 'errors' => []];
        } catch (DuplicateRecordException $e) {
            return [
                'success' => false,
                'errors' => ['general' => $e->getMessage()],
            ];
        }
    }

    public function update(int $id, array $data): array
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $this->repository->update($id, $data);

            return ['success' => true, 'errors' => []];
        } catch (DuplicateRecordException $e) {
            return [
                'success' => false,
                'errors' => ['general' => $e->getMessage()],
            ];
        }
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['order_code'] === '') {
            $errors['order_code'] = 'Order code is required.';
        }

        if ($data['lead_id'] === '' || !ctype_digit((string) $data['lead_id'])) {
            $errors['lead_id'] = 'Lead ID is required.';
        }

        if ($data['amount'] === '' || !is_numeric($data['amount']) || (float) $data['amount'] <= 0) {
            $errors['amount'] = 'Amount must be greater than 0.';
        }

        $allowedStatuses = ['pending', 'paid', 'cancelled'];

        if ($data['order_status'] === '') {
            $errors['order_status'] = 'Order status is required.';
        } elseif (!in_array($data['order_status'], $allowedStatuses, true)) {
            $errors['order_status'] = 'Invalid order status.';
        }

        return $errors;
    }
}