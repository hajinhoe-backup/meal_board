<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 8
 * Time: 오후 2:51
 */

$shop_id = $_POST["shop_id"];

$menu_name = trim($_POST["menu_name"]);
$menu_price = (int)trim($_POST["menu_price"]);
if (empty($menu_name) or empty($menu_price)) {
    echo false;
    return;
}

$user_ip = $_SERVER["REMOTE_ADDR"];

include('connect_db.php');

try {
    $stmt = $db->prepare("INSERT INTO menu VALUES(?, ?, ?, ?);");
    $stmt->execute(array($shop_id, "$menu_name", $menu_price, "$user_ip"));
    echo true;
} catch (PDOException $ex) {
    echo false;
}
?>