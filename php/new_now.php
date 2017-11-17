<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 8
 * Time: 오후 2:31
 */

$shop_id = $_POST["shop_id"];

$comment = trim($_POST["comment"]);

if (empty($comment)) {
    echo false;
    return;
}

$user_ip = $_SERVER["REMOTE_ADDR"];
$make_date = date("Y-m-d H:i:s");

include('connect_db.php');

try {
$stmt = $db->prepare("INSERT INTO now_comment(shop_id, comment, ip_address, make_date) VALUES(?, ?, ?, ?);");
$stmt->execute(array($shop_id, "$comment", "$user_ip", "$make_date"));
echo true;
} catch (PDOException $ex) {
echo false;
}
?>
