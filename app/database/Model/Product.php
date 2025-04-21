<?php
require_once __DIR__.'/../../lib/SimplePager.php';

/**
 * 包含功能：增删改查，获取全部，和用id获取
 */
class Product {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findAll(int $limit, int $page, array $filters = []): SimplePager {
        $sql = "SELECT * FROM products";
        $params = [];
        $where = $this->buildFilterWhere($filters, $params);
        if ($where) $sql .= " WHERE $where";
        $sql .= " ORDER BY id ASC";
        return new SimplePager($this->pdo, $sql, $params, $limit, $page);
    }

    public function findById(int $id): ?array {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([':id' => $id]);
        $product = $stm->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    public function search(string $keyword, int $limit, int $page): SimplePager {
        $sql = "SELECT * FROM products WHERE name LIKE :kw OR description LIKE :kw";
        $params = [':kw' => "%$keyword%"];
        return new SimplePager($this->pdo, $sql, $params, $limit, $page);
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO products (name, price, stock, ...) VALUES (:name, :price, :stock, ...)";
        $stm = $this->pdo->prepare($sql);
        return $stm->execute($data);
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id";
        $data[':id'] = $id;
        $stm = $this->pdo->prepare($sql);
        return $stm->execute($data);
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM products WHERE id = :id";
        $stm = $this->pdo->prepare($sql);
        return $stm->execute([':id' => $id]);
    }

    private function buildFilterWhere(array $filters, array &$params): string {
        $where = [];
        if (isset($filters['sold_min'])) {
            $where[] = "sold >= :sold_min";
            $params[':sold_min'] = $filters['sold_min'];
        }
        if (isset($filters['category'])) {
            $where[] = "category = :category";
            $params[':category'] = $filters['category'];
        }
        return implode(' AND ', $where);
    }

    public function getSizes(int $product_id): array {
        $sql = "SELECT size FROM product_size WHERE product_id = :id";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([':id' => $product_id]);
        return $stm->fetchAll(PDO::FETCH_COLUMN); // 只返回 size 列的数组
    }
    
    public function getColors(int $product_id): array {
        $sql = "SELECT color_code FROM product_color WHERE product_id = :id";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([':id' => $product_id]);
        return $stm->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getReviews(int $product_id): array {
        $sql = "SELECT rating, review_text, created_at FROM product_review WHERE product_id = :id ORDER BY created_at DESC";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([':id' => $product_id]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSizes(array $productIds): array {
        $in = implode(',', array_fill(0, count($productIds), '?'));
        $sql = "SELECT * FROM product_size WHERE product_id IN ($in)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute($productIds);
        $all = $stm->fetchAll(PDO::FETCH_ASSOC);
    
        // 组织成 product_id => [sizes...]
        $result = [];
        foreach ($all as $row) {
            $result[$row['product_id']][] = $row;
        }
        return $result;
    }

    public function getAllColors(array $productIds): array {
        $in = implode(',', array_fill(0, count($productIds), '?'));
        $sql = "SELECT * FROM product_color WHERE product_id IN ($in)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute($productIds);
        $all = $stm->fetchAll(PDO::FETCH_ASSOC);
    
        // 组织成 product_id => [color...]
        $result = [];
        foreach ($all as $row) {
            $result[$row['product_id']][] = $row;
        }
        return $result;
    }

    public function getAllReviews(array $productIds): array {
        $in = implode(',', array_fill(0, count($productIds), '?'));
        $sql = "SELECT * FROM product_review WHERE product_id IN ($in)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute($productIds);
        $all = $stm->fetchAll(PDO::FETCH_ASSOC);
    
        // 组织成 product_id => [review...]
        $result = [];
        foreach ($all as $row) {
            $result[$row['product_id']][] = $row;
        }
        return $result;
    }

    public function getTop5BySold(){
        $sql = "SELECT * FROM products ORDER BY sold DESC LIMIT 5";
        $stm = $this->pdo->query($sql);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}
