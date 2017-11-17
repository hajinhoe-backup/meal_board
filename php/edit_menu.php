<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 2017-11-07
 * Time: 오후 10:32
 */

$shop_id = $_POST["shop_id"];
$menu_name = trim($_POST["menu_name"]);
$menu_price = (int)trim($_POST["menu_price"]);
if (empty($menu_name) or empty($menu_price)) {
    echo false;
    return;
}

include('connect_db.php');

try {
    $stmt = $db->prepare("UPDATE shop_menu SET price = ? WHERE shop_id = $shop_id and name = '$menu_name';");
    $stmt->execute(array($menu_price));
    echo true;
} catch (PDOException $ex) {
    echo false;
}
?>