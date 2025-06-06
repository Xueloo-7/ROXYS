<?php

class SimplePager {
    public $limit;
    public $page;
    public $item_count;
    public $page_count;
    public $result;
    public $count;

    private $pdo;
    private $base_sql;
    private $params;

    public function __construct(PDO $pdo, $base_sql, $params, $limit, $page) {
        $this->pdo = $pdo;
        $this->base_sql = $base_sql;
        $this->params = $params;

        // 页大小和当前页处理
        $this->limit = ctype_digit((string)$limit) ? max((int)$limit, 1) : 10;
        $this->page = ctype_digit((string)$page) ? max((int)$page, 1) : 1;

        // 获取总条数（需要你传入 like: "SELECT * FROM products WHERE ..."）
        $count_sql = "SELECT COUNT(*) FROM (" . $base_sql . ") AS subquery";
        $stm = $this->pdo->prepare($count_sql);
        $stm->execute($params);
        $this->item_count = (int)$stm->fetchColumn();

        $this->page_count = max(ceil($this->item_count / $this->limit), 1);

        $offset = ($this->page - 1) * $this->limit;

        // 获取当前页结果
        $paged_sql = $base_sql . " LIMIT :offset, :limit";
        $stm = $this->pdo->prepare($paged_sql);
        foreach ($params as $key => $val) {
            $stm->bindValue($key, $val);
        }
        $stm->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stm->bindValue(':limit', $this->limit, PDO::PARAM_INT);
        $stm->execute();
        $this->result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $this->count = count($this->result);
    }
    
    public function getResult(): array {
        return $this->result;
    }
    
    public function setResult(array $items): void {
        $this->result = $items;
        $this->count = count($items);
    }

    /**
     * 输出：
     *  <nav class='pager'>
     *      <a href='?page=1'>First</a>
     *      <a href='?page=2'>Prev</a>
     *      <a href='?page=1'>1</a>
     *      <a href='?page=2'>2</a>
     *      <a href='?page=3' class='active'>3</a>
     *      <a href='?page=4'>4</a>
     *      <a href='?page=5'>5</a>
     *      <a href='?page=4'>Next</a>
     *      <a href='?page=10'>Last</a>
     *  </nav>
     * @param string href, 带参数，如$href='limit=10'，就会出现?limit=10
     * @param string attr, nav的属性，如$attr='style="text-align:center"', 相当于<nav class="pager" style="text-align:center">
     */
    public function render(string $href = '', string $attr = '', string $basePath = '') {
        // 如果页面总数小于等于1，返回空
        if ($this->page_count <= 1) return '';
        
        // 如果没有传递basePath，使用当前请求的路径
        if (!$basePath) {
            $basePath = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        }
        
        // 构建HTML的开始部分
        $html = "<nav class='pager' $attr>";
        
        // 计算前一页和后一页的页码
        $prev = max($this->page - 1, 1);
        $next = min($this->page + 1, $this->page_count);
        
        // 获取当前页面的查询字符串部分，并移除 "page" 参数
        $urlParams = $_GET;
        unset($urlParams['page']);
        $queryString = http_build_query($urlParams);
        
        // 如果查询字符串不为空，确保参数前有?或&，否则保持空
        if ($queryString) {
            $queryString = '?' . $queryString;
        }
        
        // 渲染"首页"和"上一页"链接
        $html .= "<a href='" . BASE_URL . "$basePath/1$queryString'>First</a>";
        $html .= "<a href='" . BASE_URL . "$basePath/$prev$queryString'>Prev</a>";
        
        // 渲染页码链接
        $start = max(1, $this->page - 2);
        $end = min($this->page + 2, $this->page_count);
        for ($i = $start; $i <= $end; $i++) {
            $active = $i == $this->page ? "class='active'" : '';
            $html .= "<a href='" . BASE_URL . "$basePath/$i$queryString' $active>$i</a>";
        }
        
        // 渲染"下一页"和"最后一页"链接
        $html .= "<a href='" . BASE_URL . "$basePath/$next$queryString'>Next</a>";
        $html .= "<a href='" . BASE_URL . "$basePath/{$this->page_count}$queryString'>Last</a>";
        
        // 结束HTML并返回
        $html .= "</nav>";
        return $html;
    }
    
    
       
}
