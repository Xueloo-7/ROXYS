<!-- 获取商品地址，直接跳转到对应商品界面 -->
<?php

require_once __DIR__.'/_baseAPI.php';

if(is_post('product_id')){
    header("Location: " .BASE_URL. "product/" . $_POST['product_id']);
    exit;
}

?>