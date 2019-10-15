<?php
function index() {
    $sql = "SELECT * FROM products";
    $res = mysqli_query(connect(), $sql);

    $html = '<h1>Все товары</h1>';
    $html .= '<div class="content">';
    while ($row = mysqli_fetch_assoc($res)) {
        $html .= <<<php
        
            <div class="catalogItem">
                <a href="?p=catalog&f=getOne&id={$row['id']}">
                    <img src="img/{$row['link']}" alt="{$row['name']}" class='foto'>
                </a>
                <h3><a href="?p=catalog&f=getOne&id={$row['id']}">{$row['name']}</a></h3>
            </div>
        
php;
    }
    $html .= '</div>';
    return $html;
}
function getOne() {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM products WHERE id = {$id}";
    $res = mysqli_query(connect(), $sql);
    $row = mysqli_fetch_assoc($res);

    $html = '';
    $html .= <<<php
    <div class="content">
        <div class="product">
            <h2>{$row['name']}</h2>
            <a href="img/{$row['link']}" target="_blank">
                <img src="img/{$row['link']}" alt="{$row['name']}">
            </a>
            <h2>Название: {$row['name']}</h2>
            <h3>Цена: {$row['price']} руб.</h3>
            <h3><a href="?p=cart&f=add&id={$row['id']}">В корзину</a></h3>
            <a href="{$_SERVER['HTTP_REFERER']}">Назад</a>
        </div>
    </div>
php;
    return $html;
}