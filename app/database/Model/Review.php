<?php

/**
 * 包含功能：增删改，和用id获取
 */
class Review {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // 查找评论 by ID
    public function findById(int $id): ?array {
        $sql = "SELECT * FROM product_review WHERE id = :id";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([':id' => $id]);
        $review = $stm->fetch(PDO::FETCH_ASSOC);
        return $review ?: null;
    }

    // 创建评论
    public function create(array $data): bool {
        $sql = "INSERT INTO product_review (product_id, user_id, rating, review_text) 
                VALUES (:product_id, :user_id, :rating, :review_text)";
        $stm = $this->pdo->prepare($sql);
        return $stm->execute([
            ':product_id' => $data['product_id'],
            ':user_id' => $data['user_id'],
            ':rating' => $data['rating'],
            ':review_text' => $data['review_text'] ?? null,
        ]);
    }

    // 更新评论
    public function update(int $id, array $data): bool {
        $sql = "UPDATE product_review 
                SET rating = :rating, review_text = :review_text 
                WHERE id = :id";
        $stm = $this->pdo->prepare($sql);
        return $stm->execute([
            ':id' => $id,
            ':rating' => $data['rating'],
            ':review_text' => $data['review_text'] ?? null,
        ]);
    }

    // 删除评论
    public function delete(int $id): bool {
        $sql = "DELETE FROM product_review WHERE id = :id";
        $stm = $this->pdo->prepare($sql);
        return $stm->execute([':id' => $id]);
    }

    // 可选：获取某个产品的所有评论
    public function getByProductId(int $productId): array {
        $sql = "SELECT r.*, u.name, u.avatar AS user_avatar
                FROM product_review r 
                JOIN users u ON r.user_id = u.id
                WHERE r.product_id = :product_id
                ORDER BY r.created_at DESC";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([':product_id' => $productId]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}
