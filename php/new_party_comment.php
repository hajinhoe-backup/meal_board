<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 14
 * Time: 오전 12:11
 */
$party_id = trim($_POST["party_id"]);
$user_name = $_POST["user_name"];
$comment = trim($_POST["comment"]);

if (empty($comment)) {
    echo false;
    return;
}

$user_ip = $_SERVER["REMOTE_ADDR"];
$make_date = date("Y-m-d H:i:s");

include('connect_db.php');

try {
    $stmt = $db->prepare("INSERT INTO meal_party_comment(party_id, name, comment, ip_address, make_date) VALUES(?, ?, ?, ?, ?);");
    $stmt->execute(array($party_id, "$user_name", "$comment", "$user_ip", "$make_date"));
    $db->exec("UPDATE meal_party SET apply = apply + 1 where id = $party_id");
    echo true;
} catch (PDOException $ex) {
    print $ex->getMessage();
}
?>