<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 21
 * Time: 오전 8:29
 */

$shop_id = $_GET["shop_id"];
$shop_name = $_GET["shop_name"];
$menu_name = $_GET["menu"];

include('php/connect_db.php');

try {
    $previous = $db->query("SELECT * FROM menu_log WHERE shop_id = $shop_id and name = '$menu_name';");
} catch (PDOException $ex) {
    echo "에러입니다.";
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <link rel="stylesheet" type="text/css" href="normalize.css">
    <style>
        body {
            margin: 15px;
        }
        input {
            border: 0;
            border-bottom: 1px solid black;
        }
        input[type=number] {
            -moz-appearance: textfield;
            height: 32px;
            width: 10%;
        }
        input[type=text] {
            width: 70%;
            height: 32px;
        }
        input[type=submit] {
            color: white;
            background-color: green;
            border-bottom: 3px solid darkgreen;
            font-size: 24px;
            padding: 0 15px 0 15px;
            width: 100px;
            float: right;
        }
        #new_party div span:nth-child(1) {
            float: left;
            width: 80%;
        }
        textarea {
            border: 1px solid black;
            width: 100%;
            height: 400px;
        }
        #new_party div:first-child{
            background-color: darkseagreen;
            padding: 15px 60px 15px 60px;
            overflow: hidden;
        }
        #new_party div:nth-child(2){
            background-color: lightskyblue;
            padding: 15px 60px 15px 60px;
        }
        #back_to_list {
            text-decoration: none;
            color: white;
            background-color: darkgreen;
            float: right;
            margin: 10px;
            padding: 15px;
        }
        #title {
            color: white;
            padding:15px;
            background-color: green;
            margin-bottom:0;
        }
    </style>
    <meta charset="UTF-8">
    <title>새로운 밥 파티 만들기</title>
</head>
<body>
    <div id="title">
        <a id="back_to_list" href="view.php?shop_id=<?= $shop_id ?>&shop_name=<?= $shop_name ?>">뒤로가기</a>
        <h1>변경이력 조회</h1>
        <p><?= $menu_name ?></p>
    </div>
    <div>
        <?php
            if ($previous->rowCount() == 0) {
        print("이력이 없습니다.");
        } else {
        foreach ($previous as $row) { ?>
        <p>가격 : <?= $row["price"] ?>원 날짜 : <?= $row["edit_date"] ?> IP : <?= $row["ip_address"] ?></p>
        <?php
        }
        }
        ?>
    </div>
</body>
</html>