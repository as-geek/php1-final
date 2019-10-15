<?php
function index() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userId = $_SESSION[USER_ID]['id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $sql = "INSERT INTO orders (user_id, name, phone, address)
                VALUES ({$userId}, '{$name}', '{$phone}', '{$address}')";

        mysqli_query(connect(), $sql);
        $msg = 'Error';
        if (mysqli_insert_id(connect())) {
            $orderId = mysqli_insert_id(connect());
            foreach ($_SESSION[PRODUCTS] as $product) {
                $productId = $product['id'];
                $count = $product['count'];
                $sql = "INSERT INTO order_products (order_id, user_id, product_id, count)
                        VALUES ($orderId, $userId, $productId, $count)";
                mysqli_query(connect(), $sql);
                if (!mysqli_insert_id(connect())) {
                    $msg = 'Error';
                    header('Location: /?p=auth&msg='. $msg);
                    exit;
                }
            }
            $msg = 'Заказ номер ' . $orderId . ' принят';
            $_SESSION[PRODUCTS] = [];
        }
        header('Location: /?p=auth&msg='. $msg);
        exit;
    }

    if (empty($_SESSION[ORDER])) {
        $html = <<<php
    <form method="post">
        <p>Имя: </p><input type="text" name="name" placeholder="Имя" required>
        <p>Телефон: </p><input type="text" name="phone" placeholder="Телефон" required>
        <p>Адрес: </p><textarea name="address" cols="30" rows="10" required></textarea>
        <input type="submit" value="Купить!">
    </form>
php;
    }
    return $html;
}