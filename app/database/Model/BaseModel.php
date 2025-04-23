<?php
require_once __DIR__.'/../../lib/SimplePager.php';

abstract class BaseModel {
    protected PDO $pdo;
    protected string $table;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findPage(int $limit, int $page, array $filters = []): SimplePager {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        $where = $this->buildFilterWhere($filters, $params);
        if ($where) $sql .= " WHERE $where";
        $sql .= " ORDER BY id ASC";
        return new SimplePager($this->pdo, $sql, $params, $limit, $page);
    }

    // 子类可覆盖这个方法以自定义过滤逻辑
    protected function buildFilterWhere(array $filters, array &$params): string {
        return '';
    }
}
