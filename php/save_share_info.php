<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 21
 * Time: 오전 10:47
 */
$shop_id = $_POST["shop_id"];
$no_alone = isset($_POST["no_alone"]) ? TRUE : FALSE;
$no_card = isset($_POST["no_card"]) ? TRUE : FALSE;
$morning = isset($_POST["morning"]) ? TRUE : FALSE;
$lunch = isset($_POST["lunch"]) ? TRUE : FALSE;
$evening = isset($_POST["evening"]) ? TRUE : FALSE;
$shop_name = $_POST["shop_name"];

include('connect_db.php');

try {
    $get_info = $db->query("SELECT * FROM share_info WHERE shop_id = $shop_id;");
    if ($get_info -> rowCount() == 0) {
        $stmt = $db->prepare("INSERT INTO share_info VALUES (?,?,?,?,?,?);");
        $stmt->execute(array($shop_id, $no_alone, $no_card, $morning, $lunch, $evening));
    } else {
        $stmt = $db->prepare("UPDATE share_info SET no_alone = ?, no_card = ?, morning = ?, lunch = ?, evening = ? WHERE shop_id = $shop_id;");
        $stmt->execute(array($no_alone, $no_card, $morning, $lunch, $evening));
    }
} catch (PDOException $ex) {
    echo "실패하였습니다.";
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
    <a id="back_to_list" href="../view.php?shop_id=<?= $shop_id ?>&shop_name=<?= $shop_name ?>">뒤로가기</a>
    <h1>안내</h1>
</div>
<div>
    <p>성공적으로 저장되었습니다.</p>
</div>
</body>
</html>
