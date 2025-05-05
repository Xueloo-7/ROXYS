<?php
require_once __DIR__.'/BaseModel.php';

class User extends BaseModel{
    protected string $table = 'users';

    protected function buildFilterWhere(array $filters, array &$params): string {
        $where = [];
    
        if (isset($filters['keyword']) && $filters['keyword'] !== 'all') {
            $where[] = "(name LIKE :keyword)";
            $params[':keyword'] = '%' . $filters['keyword'] . '%';
        }
    
        return implode(' AND ', $where);
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateRememberToken($userId, $token): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
        return $stmt->execute([':token' => $token, ':id' => $userId]);
    }

    public function create($data)
    {
        error_log("create");
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (:name, :email, :password, :created_at, :updated_at)");
        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':created_at' => date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function update($id, $data)
    {
        // 初始化字段数组和参数数组
        $fields = [];
        $params = [':id' => $id];
    
        // 遍历数据，将每个字段值添加到 SQL 更新语句中
        foreach ($data as $key => $value) {
            if (!empty($value) || $value === '0') {  // 允许空字符串 '0' 或数字 0 更新
                $fields[] = "$key = :$key";  // 拼接字段名和值
                $params[":$key"] = $value;   // 将每个字段值绑定到 params 中
            }
        }
    
        // 生成 SQL 语句
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
    
        // 准备 SQL 语句
        $stmt = $this->pdo->prepare($sql);
    
        // 执行 SQL 语句并返回结果
        return $stmt->execute($params);
    }
    

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function search($keyword)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE name LIKE :keyword OR email LIKE :keyword");
        $stmt->execute([':keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByName($name)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->execute([':name' => $name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 切换封锁状态
    public function toggleBlock($id)
    {
        $stmt = $this->pdo->prepare("SELECT active FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception("User not found");
        }

        $newStatus = $user['active'] ? 0 : 1;

        $stmt = $this->pdo->prepare("UPDATE users SET active = :status WHERE id = :id");
        return $stmt->execute([':status' => $newStatus, ':id' => $id]);
    }

}