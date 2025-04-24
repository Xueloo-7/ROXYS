<?php
require_once __DIR__.'/BaseModel.php';

class OrderHistory extends BaseModel{
    protected string $table = 'orders';

    protected function buildFilterWhere(array $filters, array &$params): string {
        $where = [];
    
        if (isset($filters['keyword']) && $filters['keyword'] !== 'all') {
            $where[] = "(id LIKE :keyword)";
            $params[':keyword'] = '%' . $filters['keyword'] . '%';
        }
    
        return implode(' AND ', $where);
    }

    public function getUserById(int $id): array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: [];  // 返回用户信息或空数组
    }
    
    public function getProductById(int $id): array {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: [];  // 返回产品信息或空数组
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE orders SET 
                    quantity = :quantity,
                    payment_method = :payment_method,
                    order_status = :order_status,
                    delivery_detail = :delivery_detail,
                    paid_date = :paid_date,
                    shipped_date = :shipped_date,
                    delivered_date = :delivered_date,
                    completed_date = :completed_date
                WHERE id = :id");
    
        return $stmt->execute([
            ':quantity' => $data['quantity'],
            ':payment_method' => $data['payment_method'],
            ':order_status' => $data['order_status'],
            ':delivery_detail' => $data['delivery_detail'],
            ':paid_date' => $data['paid_date'],
            ':shipped_date' => $data['shipped_date'],
            ':delivered_date' => $data['delivered_date'],
            ':completed_date' => $data['completed_date'],
            ':id' => $id,
        ]);
    }

    // 支付成功，将物品收入该用户的订单历史
    public function checkout(array $data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders 
                (user_id, product_id, quantity, payment_method, order_status, delivery_detail, place_date, paid_date, shipped_date, delivered_date, completed_date)
             VALUES 
                (:user_id, :product_id, :quantity, :payment_method, :order_status, :delivery_detail, :place_date, :paid_date, :shipped_date, :delivered_date, :completed_date)"
        );

        try {
            $this->pdo->beginTransaction();

            foreach ($data['cart'] as $item) {
                $stmt->execute([
                    ':user_id' => $data['user_id'],
                    ':product_id' => $item['product_id'],
                    ':quantity' => $item['quantity'],
                    ':payment_method' => $data['payment_method'],
                    ':order_status' => $data['order_status'],
                    ':delivery_detail' => $data['delivery_detail'],
                    ':place_date' => $data['place_date'],
                    ':paid_date' => $data['place_date'],
                    ':shipped_date' => $data['place_date'],
                    ':delivered_date' => $data['place_date'],
                    ':completed_date' => $data['place_date'],
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Checkout Error: " . $e->getMessage());
            return false;
        }
    }

    // 删除某项
    public function delete($id) {
        $sql = "DELETE FROM orders WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }    

    // 获取某个用户的订单历史
    public function getOrdersByUserId($userId) {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY place_date DESC";
    
        // 准备和执行查询
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        // 获取结果
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // 返回查询结果
        return $orders;
    }
}
