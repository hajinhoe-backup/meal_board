<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 8
 * Time: 오후 2:31
 */

$shop_id = $_POST["shop_id"];
$party_name = trim($_POST["party_name"]);
$party_recruit = $_POST["party_recruit"];
$comment = trim($_POST["comment"]);

if (empty($comment) or empty($party_name)) {
    echo false;
    return;
}

$user_ip = $_SERVER["REMOTE_ADDR"];
$make_date = date("Y-m-d H:i:s");

include('connect_db.php');

try {
    $stmt = $db->prepare("INSERT INTO meal_party(shop_id, subject, content, recruit, ip_address, make_date) VALUES(?, ?, ?, ?, ?, ?);");
    $stmt->execute(array($shop_id, "$party_name", "$comment", $party_recruit, "$user_ip", "$make_date"));
    echo true;
} catch (PDOException $ex) {
    echo false;
}
?>