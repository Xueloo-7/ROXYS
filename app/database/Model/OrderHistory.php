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

    public function getUserNameByOrderId(int $id): string{
        $stmt = $this->pdo->prepare("SELECT name FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['name'] ?? 'none';
    }
    
    public function getProductNameByOrderId(int $id): string{
        $stmt = $this->pdo->prepare("SELECT name FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['name'] ?? 'none';
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

    public function create(array $data) {

    }    

    // 删除某项
    public function delete($id) {
        $sql = "DELETE FROM orders WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }    

    // 获取某个用户的订单历史
    public function getOrdersByUserId($userId) {

    }
}
