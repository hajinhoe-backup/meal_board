<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 13
 * Time: 오후 7:41
 */
$shop_id = $_POST["shop_id"];
$user_name = $_POST["user_name"];
$comment = trim($_POST["comment"]);
$comment = str_replace("\r\n", "<br/>", $comment);
$rating = trim($_POST["rating"]);
if (empty($user_name) or empty($comment) or empty($rating)) {
    echo false;
    return;
}

$user_ip = $_SERVER["REMOTE_ADDR"];
$make_date = date("Y-m-d H:i:s");

include('connect_db.php');

try {
    $stmt = $db->prepare("INSERT INTO estimation VALUES(?, ?, ?, ?, ?, ?);");
    $stmt->execute(array($shop_id, "$user_name", "$comment", $rating, "$user_ip", "$make_date"));
    echo true;
} catch (PDOException $ex) {
    echo false;
}
?>