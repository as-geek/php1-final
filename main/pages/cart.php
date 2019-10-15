<?php
function index() {
    $html = '<h1>Корзина</h1>';
    if (empty($_SESSION[PRODUCTS])) {
        return $html . "<p>Нет товаров</p>";
    }
        $total = 0;
    $html .= '<div class="content">';
    foreach ($_SESSION[PRODUCTS] as $product) {
        $subTotal = $product['price'] * $product['count'];
        $total += $subTotal;
        $html .= <<<php
        <div class="product">
             <h2>{$product['name']}</h2>
             <p>{$product['price']} руб.</p>
             <p>Колличество: {$product['count']}</p>
             <p>Итого: $subTotal руб.</p>
             <h3><a href="?p=cart&f=del&id={$product['id']}">Удалить</a></h3>
         </div>
php;
    }
    $html .= '</div>';
    $html .= "<h3>Общая сумма покупки: $total руб.<br><a href='?p=order'>Оформить?</a></h3>";
    return $html;
}

function add() {
    $id = (int)$_GET['id'];
    if (empty($id)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $sql = "SELECT * FROM products WHERE id = {$id}";
    $res = mysqli_query(connect(), $sql);
    $row = mysqli_fetch_assoc($res);

    if (empty($_SESSION[PRODUCTS][$id])) {
        $_SESSION[PRODUCTS][$id] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'count' => 1,
        ];
    } else {
        $_SESSION[PRODUCTS][$id]['count'] += 1;
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function del() {
    $id = (int)$_GET['id'];

    if ($_SESSION[PRODUCTS][$id]['count'] > 1) {
        $_SESSION[PRODUCTS][$id]['count'] -= 1;
    } else {
        unset($_SESSION[PRODUCTS][$id]);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}