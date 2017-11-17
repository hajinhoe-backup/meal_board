<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 13
 * Time: 오후 8:43
 */
$shop_name = $_GET["shop_name"];
$shop_id = $_GET["shop_id"];
?>
<!DOCTYPE html>
<html lang="en">
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
    <h1>새 파티 만들기</h1>
<p>새로운 밥 파티를 만드는 것은 어렵지 않습니다. 단순히 아래의 기입 양식을 채운 후에 저장하세요!</p>
</div>
<form name="new_party" onsubmit="return submit_party(this, '<?= $shop_id ?>', '<?= $shop_name ?>');">
    <div id="new_party">
        <div>
            <span>
                <input type="text" name="party_name" placeholder="파티 이름"/>
                <input type="number" name="party_recruit" placeholder="모집 인원"/>
            </span>
            <input type="submit" value="올리기"/>
        </div>
        <div>
        <textarea name="comment" placeholder="글 내용"></textarea>
        <input type="hidden" name="shop_id" value="<?= $shop_id ?>"/>
        </div>
    </div>
</form>
<script>
    function submit_party(form_element, shop_id, shop_name) {
        if(form_element.comment.value == "" || form_element.party_name.value == "" || form_element.party_recruit.value == 0) {
            alert("올바른 입력이 아닙니다.");
            return false;
        }
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == true) {
                    location.href="view.php?shop_id="+shop_id+"&shop_name="+shop_name;
                } else {
                    alert("평가를 이미 등록하셨거나, 다른 문제가 있는 것 같습니다.")
                }
            }
        }
        xhttp.open("POST", "php/new_party.php", true);
        xhttp.send(new FormData(form_element));
        return false;
    }
</script>
</body>
</html>
