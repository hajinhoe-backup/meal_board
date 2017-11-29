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

$edit_date = date("Y-m-d H:i:s");

try {
    $previous = $db->query("SELECT * FROM menu WHERE shop_id = $shop_id and name = '$menu_name';");
    $previous = $previous->fetch();
    $stmt = $db->prepare("INSERT INTO menu_log(shop_id, name, price, edit_date, ip_address) VALUES (?,?,?,?,?);");
    $stmt->execute(array($previous["shop_id"], $previous["name"], $previous["price"], "$edit_date", $previous["ip_address"]));
    $stmt = $db->prepare("UPDATE menu SET price = ? WHERE shop_id = $shop_id and name = '$menu_name';");
    $stmt->execute(array($menu_price));

    echo true;
} catch (PDOException $ex) {
    echo false;
}
?>