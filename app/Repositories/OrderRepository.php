<?php

namespace App\Repositories;

use App\Core\Database;
use App\Core\DuplicateRecordException;
use PDO;
use PDOException;

class OrderRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function paginate(string $keyword, int $limit, int $offset): array
    {
        $sql = "
            SELECT orders.*, leads.full_name AS lead_name
            FROM orders
            LEFT JOIN leads ON orders.lead_id = leads.id
        ";

        if ($keyword !== '') {
            $sql .= "
                WHERE orders.order_code LIKE :keyword
                   OR leads.full_name LIKE :keyword
                   OR orders.order_status LIKE :keyword
            ";
        }

        $allowedSorts = [
            'id' => 'orders.id',
            'order_code' => 'orders.order_code',
            'amount' => 'orders.amount',
            'order_status' => 'orders.order_status',
            'created_at' => 'orders.created_at',
        ];

        $sort = $_GET['sort'] ?? 'id';
        $direction = strtoupper($_GET['direction'] ?? 'DESC');

        $sortColumn = $allowedSorts[$sort] ?? 'orders.id';

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'DESC';
        }

        $sql .= "
            ORDER BY $sortColumn $direction
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);

        if ($keyword !== '') {
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function count(string $keyword = ''): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM orders
            LEFT JOIN leads ON orders.lead_id = leads.id
        ";

        if ($keyword !== '') {
            $sql .= "
                WHERE orders.order_code LIKE :keyword
                   OR leads.full_name LIKE :keyword
                   OR orders.order_status LIKE :keyword
            ";
        }

        $stmt = $this->pdo->prepare($sql);

        if ($keyword !== '') {
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM orders
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO orders
                (
                    order_code,
                    lead_id,
                    amount,
                    order_status
                )
                VALUES
                (
                    :order_code,
                    :lead_id,
                    :amount,
                    :order_status
                )
            ");

            $stmt->execute([
                'order_code' => $data['order_code'],
                'lead_id' => $data['lead_id'],
                'amount' => $data['amount'],
                'order_status' => $data['order_status'],
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new DuplicateRecordException(
                    'Order code already exists.'
                );
            }

            throw $e;
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE orders
                SET
                    order_code = :order_code,
                    lead_id = :lead_id,
                    amount = :amount,
                    order_status = :order_status
                WHERE id = :id
            ");

            $stmt->execute([
                'id' => $id,
                'order_code' => $data['order_code'],
                'lead_id' => $data['lead_id'],
                'amount' => $data['amount'],
                'order_status' => $data['order_status'],
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new DuplicateRecordException(
                    'Order code already exists.'
                );
            }

            throw $e;
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM orders
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}