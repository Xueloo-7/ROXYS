<?php
require_once __DIR__.'/BaseModel.php';

/**
 * 包含功能：增删改查，获取全部，和用id获取
 */
class Product extends BaseModel{
    protected string $table = 'products';

    public function findAll(): array {
        $sql = "SELECT * FROM products";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        $product = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $product ?: null;
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

    // 单独更新主表
    public function update(int $id, array $data): bool {
        $sql = "UPDATE products SET 
            name = :name,
            price = :price,
            discount = :discount,
            stock = :stock,
            description = :description,
            details = :details,
            image_url = :image_url,
            category = :category
            WHERE id = :id";
    
        // 准备语句
        $stmt = $this->pdo->prepare($sql);
    
        // 添加 id 到数据中（注意：key 是 'id'，不是 ':id'）
        $data['id'] = $id;
    
        return $stmt->execute($data);
    }

    // 单独更新color表
    public function setSizes(int $productId, array $sizes): bool {
        $sqlDelete = "DELETE FROM product_size WHERE product_id = :id";
        $this->pdo->prepare($sqlDelete)->execute([':id' => $productId]);
    
        $sqlInsert = "INSERT INTO product_size (product_id, size) VALUES (:product_id, :size)";
        $stmt = $this->pdo->prepare($sqlInsert);
    
        foreach ($sizes as $size) {
            if ($size !== '') {
                return $stmt->execute([
                    ':product_id' => $productId,
                    ':size' => $size
                ]);
            }
        }

        return false;
    }

    // 单独更新size表
    public function setColors(int $productId, array $colors): bool {
        $sqlDelete = "DELETE FROM product_color WHERE product_id = :id";
        $this->pdo->prepare($sqlDelete)->execute([':id' => $productId]);
    
        $sqlInsert = "INSERT INTO product_color (product_id, color_code) VALUES (:product_id, :color_code)";
        $stmt = $this->pdo->prepare($sqlInsert);
    
        foreach ($colors as $color) {
            if ($color !== '') {
                return $stmt->execute([
                    ':product_id' => $productId,
                    ':color_code' => $color
                ]);
            }
        }

        return false;
    }

    // 更新主表，size和color表
    public function updateFullProduct(int $id, array $data, array $sizes, array $colors): bool
    {
        // 开启事务避免部分出错和部分更新（意思是只有全部表都不出错才更新）
        $this->pdo->beginTransaction();
        try {
            $this->update($id, $data);
            $this->setSizes($id, $sizes);
            $this->setColors($id, $colors);
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            error_log(print_r($e));
            $this->pdo->rollBack();
            return false;
        }
    }

    public function createFullProduct(array $data, array $sizes, array $colors): bool
    {
        $this->pdo->beginTransaction();
        try {
            // 创建主产品
            $sql = "INSERT INTO products (name, price, discount, stock, description, details, image_url, category)
                    VALUES (:name, :price, :discount, :stock, :description, :details, :image_url, :category)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);

            // 获取新创建的 product_id
            $productId = (int)$this->pdo->lastInsertId();

            // 插入尺码
            $sqlSize = "INSERT INTO product_size (product_id, size) VALUES (:product_id, :size)";
            $stmtSize = $this->pdo->prepare($sqlSize);
            foreach ($sizes as $size) {
                if ($size !== '') {
                    $stmtSize->execute([
                        ':product_id' => $productId,
                        ':size' => $size
                    ]);
                }
            }

            // 插入颜色
            $sqlColor = "INSERT INTO product_color (product_id, color_code) VALUES (:product_id, :color_code)";
            $stmtColor = $this->pdo->prepare($sqlColor);
            foreach ($colors as $color) {
                if ($color !== '') {
                    $stmtColor->execute([
                        ':product_id' => $productId,
                        ':color_code' => $color
                    ]);
                }
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            error_log("创建产品失败：" . $e->getMessage());
            $this->pdo->rollBack();
            return false;
        }
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM products WHERE id = :id";
        $stm = $this->pdo->prepare($sql);
        return $stm->execute([':id' => $id]);
    }

    protected function buildFilterWhere(array $filters, array &$params): string {
        $where = [];
    
        if (isset($filters['sold_min'])) {
            $where[] = "sold >= :sold_min";
            $params[':sold_min'] = $filters['sold_min'];
        }
    
        if (isset($filters['category'])) {
            $where[] = "category = :category";
            $params[':category'] = $filters['category'];
        }
    
        if (isset($filters['keyword']) && $filters['keyword'] !== 'all') {
            $where[] = "(name LIKE :keyword OR description LIKE :keyword)";
            $params[':keyword'] = '%' . $filters['keyword'] . '%';
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
