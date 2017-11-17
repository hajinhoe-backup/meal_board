<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 13
 * Time: 오후 11:47
 */

$shop_name = $_GET["shop_name"];
$shop_id = $_GET["shop_id"];
$party_id = $_GET["id"];

include('php/connect_db.php');

try {
    $article_data = $db->query("select * from meal_party where id=$party_id");
    $comment_data = $db->query("select name, comment, make_date from meal_party_comment where party_id=$party_id");
} catch (PDOException $ex) {
    print "정보를 가져오는 도중에 문제가 발생하였습니다. 관리자에게 연락하십시오.";
}
$article_data = $article_data -> fetch();
?>

<!DOCTYPE html>
<html lang="ko">
<meta name="viewport" content="width=device-width, initial-scale=0.5">
<head>
    <meta charset="UTF-8">
    <title><?= $article_data["subject"] ?></title>
    <link rel="stylesheet" type="text/css" href="normalize.css">
    <style>
        body {
            margin: 15px;
        }
        input {
            border: 0;
            border-bottom: 1px solid black;
        }
        input[type=text] {
            height: 32px;
        }
        input[type=submit] {
            color: white;
            background-color: green;
            border-bottom: 3px solid darkgreen;
            font-size: 24px;
            padding: 0 15px 0 15px;
            width: 100px;
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
        #apply {
            display: inline-block;
        }
        #apply span span:nth-child(2n - 1) {
            background-color: black;
            color: white;
            padding: 5px;
        }

        #apply span span:nth-child(2n) {
            background-color: skyblue;
            color: black;
            padding: 5px;

        }
        #comment_box span{
            width: 80%;
            float: left;
        }
        #comment_box span input[type=text]:nth-child(1) {
            width: 150px;
        }
        #comment_box span input[type=text]:nth-child(2) {
            width: 60%;
        }
        #comment_box input[type=submit] {
            float: right;
        }
        .comment_info {
            background-color: skyblue;
            padding: 15px;
            overflow: hidden;
            margin-top: 15px;
        }

        .comment_info span:nth-child(1) {
            float: left;
        }
        .comment_info span span:nth-child(1) {
            color : white;
            background-color: black;
            padding: 5px;
            margin-right: 5px;
        }
        .comment_info span:nth-child(2) {
            float: right;
        }
        .comment {
            background-color: lightblue;
            margin-bottom: 15px;
            padding: 15px;
        }
        #content {
            background-color: lightblue;
            margin : 0;
            padding : 15px;

        }
    </style>
</head>
<body>
<div>
<div id="title">
    <a id="back_to_list" href="view.php?shop_id=<?= $shop_id ?>&shop_name=<?= $shop_name ?>">뒤로가기</a>
    <h1><?= $article_data["subject"] ?></h1>
    <div id="apply"><span><span>지원인원</span><span><?= $article_data["apply"] ?></span></span><span><span>모집인원</span><span><?= $article_data["recruit"] ?></span></span></div>
    <span><?= $article_data["make_date"] ?></span>
</div>

<p id="content"><?= $article_data["content"] ?></p>

<?php
if ($comment_data -> rowCount() == 0) { ?>
<p>댓글이 없습니다.</p>
<?php
} else {
    foreach ($comment_data as $row) { ?>
        <div class="comment_info"><span><span>이름</span><span><?= $row["name"] ?></span></span><span><?= $row["make_date"] ?></span></div>
        <div class="comment"><p><?= $row["comment"] ?></p></div><?php
    }
}
?>

<form name="comment" onsubmit="return submit_party_comment(this);">
    <div id="comment_box">
        <span>
            <input type="text" name="user_name" placeholder="이름"/>
            <input type="text" name="comment" placeholder="내용을 입력하세요."/>
        </span>
        <input type="hidden" name="party_id" value="<?= $party_id ?>"/>
        <input type="submit" value="올리기"/>
    </div>
</form>
</div>
    <script>
        function submit_party_comment(form_element) {
            if(form_element.comment.value == "" || form_element.user_name.value == "") {
                alert("올바른 입력이 아닙니다.");
                return false;
            }
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == true) {
                        window.location.reload();
                    } else {
                        alert("평가를 이미 등록하셨거나, 다른 문제가 있는 것 같습니다.")
                    }
                }
            }
            xhttp.open("POST", "php/new_party_comment.php", true);
            xhttp.send(new FormData(form_element));
            return false;
        }
    </script>
</body>
</html>