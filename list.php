<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 2017-11-07
 * Time: 오후 10:30
 */

if (!isset($_GET["lists_number"])) {
    $page_number = 0;
} else {
    $page_number = $_GET["lists_number"];
};

$lists_first = $page_number*5;
$lists_last = $page_number*5+5;

include('php/connect_db.php');
try {
    $lists = $db->query("select * from basic_info limit $lists_first, $lists_last;");
} catch (PDOException $ex) {
    print "정보를 가져오는 도중에 문제가 발생하였습니다. 관리자에게 연락하십시오.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>가게 목차 보기</title>
</head>
<body>
<img src="https://search.pstatic.net/common/?src=http%3A%2F%2Fldb.phinf.naver.net%2F20150901_111%2F1441099792359sk3dS_JPEG%2F156270603275242_1.jpeg&amp;type=f420_312&amp;quality=95&amp;autoRotate=true" alt="" width="420" height="312">
<ul>
    <?php
    foreach ($lists as $list) {
    ?>
    <li>
        <a href="view.php?shop_id=<?= $list["id"] ?>&shop_name=<?= $list["name"] ?>">
        <?php
        print ($list["name"]);
        ?>
        </a>
    </li>
    <?php
    }
    ?>
</ul>
<?php
if ($page_number > 0) {
    ?>
    <a href="list.php?lists_number=<?= $page_number-1; ?>">이전으로</a>
<?php
}
?>
<a href="list.php?lists_number=<?= $page_number+1 ?>">다음으로</a>
</ul>
</body>
</html>
