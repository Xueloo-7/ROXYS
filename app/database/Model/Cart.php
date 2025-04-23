<?php
require_once __DIR__.'/BaseModel.php';

class Cart extends BaseModel{
    protected string $table = 'shopping_cart';

    // 添加商品进购物车（有重复就加数量）
    public function addItem(array $data) {
        $stmt = $this->pdo->prepare("SELECT id, quantity FROM shopping_cart 
            WHERE user_id = :user_id AND product_id = :product_id AND color_code = :color AND size = :size LIMIT 1");
        $stmt->execute([
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
            'color' => $data['color_code'],
            'size' => $data['size']
        ]);
    
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($existing) {
            $newQty = $existing['quantity'] + ($data['quantity'] ?? 1);
            $updateStmt = $this->pdo->prepare("UPDATE shopping_cart SET quantity = :quantity WHERE id = :id");
            $updateStmt->execute([
                'quantity' => $newQty,
                'id' => $existing['id']
            ]);
        } else {
            $insertStmt = $this->pdo->prepare("INSERT INTO shopping_cart (user_id, product_id, quantity, color_code, size) 
                VALUES (:user_id, :product_id, :quantity, :color, :size)");
            $insertStmt->execute([
                'user_id' => $data['user_id'],
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'] ?? 1,
                'color' => $data['color_code'],
                'size' => $data['size']
            ]);
        }
    }    

    // 删除某项
    public function removeItem($userId, $cartId) {
        $stmt = $this->pdo->prepare("DELETE FROM shopping_cart WHERE id = :id AND user_id = :user_id");
        $stmt->execute(['id' => $cartId, 'user_id' => $userId]);
    }

    // 获取某个用户的购物车
    public function getCartItemsByUserId($userId) {
        $stmt = $this->pdo->prepare("
            SELECT sc.*, p.name, p.image_url, p.price, p.original_price
            FROM shopping_cart sc
            JOIN products p ON sc.product_id = p.id
            WHERE sc.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 计算总额
    public function calculateTotals(array $cartItems): array {
        $subtotal = 0;
        $originalSubtotal = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $originalSubtotal += $item['original_price'] * $item['quantity'];
        }

        $deliveryFee = $subtotal >= 100 ? 0 : 8; // 示例逻辑：满100免运费
        $totalPayable = $subtotal + $deliveryFee;

        return [
            'original_subtotal' => $originalSubtotal,
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total_payable' => $totalPayable,
        ];
    }

    // 清空购物车
    public function clearCart($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM shopping_cart WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }
}
