<?php
function getOrder() {
    $sql = "SELECT * FROM orders";
    $res = mysqli_query(connect(), $sql);

    $html = '<h1>Заказы</h1>';
    $html .= '<div class="content">';
    while ($row = mysqli_fetch_assoc($res)) {
        $html .= <<<php
            <div>
                <p>{$row['order_id']}</p>
                <p>{$row['name']}</p>
                <p>{$row['phone']}</p>
                <p>{$row['address']}</p>
            </div>
            <br>
php;
    }
    $html .= '</div>';
    return $html;
}