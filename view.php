<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 2017-11-07
 * Time: 오후 10:31
 */
$shop_name = $_GET["shop_name"];
$shop_id = $_GET["shop_id"];
include('php/connect_db.php');

try {
    $menus = $db->query("select * from menu where shop_id = $shop_id;");
    $estimations = $db->query("select * from estimation where shop_id = $shop_id order by make_date asc;");
    $info_real = $db->query("select * from real_info where shop_id = $shop_id;");
    $info_web = $db->query("select * from web_info where shop_id = $shop_id;");
    $avg_rating = $db->query("select avg(rating) as avg_rating from estimation where shop_id = $shop_id;");
    $now_comment = $db->query("select comment, make_date from now_comment where shop_id = $shop_id order by id desc limit 3");
    $party_list = $db->query("select id, subject, recruit, apply, make_date from meal_party where shop_id = $shop_id order by id desc limit 2");
} catch (PDOException $ex) {
    print "정보를 가져오는 도중에 문제가 발생하였습니다. 관리자에게 연락하십시오.";
}

$info_real = $info_real->fetch();
$info_web = $info_web->fetch();
$avg_rating = $avg_rating->fetch();
$avg_rating = $avg_rating["avg_rating"];
?>

<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title><?= $shop_name ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=0.5">
        <link rel="stylesheet" type="text/css" href="normalize.css">
        <link rel="stylesheet" type="text/css" href="view.css">
    </head>
    <body>
        <!-- 기본적인 정보-->
        <div id = "title">
            <h1><?= $shop_name ?></h1>
            <a id="back_to_list" href="list.php">돌아가기</a>
        </div>
        <div id = "info">
            <p><?= $info_web["introduction"] ?></p>
            <a href="<?= $info_web["homepage"] ?>">HOMEPAGE</a>
            <span><span>PHONE</span><?= $info_real["phone"] ?></span>
            <span><span>OPEN</span><?= $info_real["open_time"] ?></span>
            <span><span>CLOSE</span><?= $info_real["close_time"] ?></span>
            <span id = "category"><?= $info_real["category"] ?></span>
            <span><?= $info_web["etc"] ?></span>
        </div>
        <!-- 유저가 혼밥 거부 등 기록 -->
        <form name="share_info">
            <div id="share_info">
                <input type="checkbox" id="s_i_noa" name="share_info" value="no_alone"/>
                <label for="s_i_noa">노혼밥</label>
                <input type="checkbox" id="s_i_noc" name="share_info" value="no_card"/>
                <label for="s_i_noc">노카드</label>
                <span>
                <span>붐벼요</span>
                <span>
                    <input type="checkbox" id="s_i_mo" name="share_info" value="morning"/>
                    <label for="s_i_mo">아침</label>
                    <input type="checkbox" id="s_i_lu" name="share_info" value="lunch"/>
                    <label for="s_i_lu">저녁</label>
                    <input type="checkbox" id="s_i_ev" name="share_info" value="evening"/>
                    <label for="s_i_ev">저녁</label>
                </span>
                </span>
                <input type="submit" value="저장"/>
            </div>
        </form>
        <!-- 메뉴 기록 -->
        <h2>이곳에는 어떤 음식이 있을까요?</h2>
        <?php if ($menus -> rowCount() == 0) {?>
                <p>기록된 메뉴가 없습니다. 첫 번째 메뉴를 등록해주세요!</p>
        <?php } else {
            foreach ($menus as $row) { ?>
                <div class="menu_line">
                    <span>메뉴명</span> <span class="menu_name"><?= $row["name"] ?></span> <span class="menu_price"><?= $row["price"] ?></span><span>원</span>
                    <span class="menu_option">
                        <span class="preview_menu" onclick="view_img(this, '<?= $row["name"] ?>')">미리보기</span>
                        <span class="edit_menu" onclick="edit_menu(this, <?= $shop_id ?>)">수정하기</span>
                        <span class="remove_menu" onclick="remove_menu(this, <?= $shop_id ?>)">삭제하기</span>
                    </span>
                </div>
            <?php } ?>
        <?php } ?>
        <form name="menu" onsubmit="return submit_menu(this);">
            <div id="menu_area">
                <input type="text" name="menu_name" placeholder="메뉴 이름"/>
                <input type="text" name="menu_price" placeholder="가격" size="6"/>
                <input type="hidden" name="shop_id" value="<?= $shop_id ?>"/>
                <input type="submit" value="올리기"/>
                <p>저장 버튼을 누르시는 것은 우리 사이트의 개인정보 취급에 동의하는 것이며, IP 주소가 저장됩니다. 동의를 하지 않으실 경우에는 저장 버튼을 누르지 마십시오.</p>
                <p>미리 보기 데이터는 실제 식당에서 제공하는 음식과는 관련이 없습니다.</p>
            </div>
        </form>
        <!-- 정보 공유 Now -->
        <h2>이 음식점에서는 무슨 일이 벌어지고 있나요?</h2>
        <form name="now_comment" onsubmit="return submit_now(this);">
            <div>
                <div id="now_comment">
                    <span id="now_label">Now!</span><input type="text" name="comment" placeholder="특종을 알려주세요!"/>
                    <input type="hidden" name="shop_id" value="<?= $shop_id ?>"/>
                </div>
                <input id="submit_now" type="submit" value="Now!">
            </div>
        </form>
        <?php if($now_comment -> rowCount() == 0) {?>
            <p>등록된 코멘트가 없습니다.</p>
        <?php } else {
            foreach ($now_comment as $row) {?>
                <div class="now_comment"><p><?= $row["comment"] ?></p><span><?= $row["make_date"] ?></span></div>
            <?php }
        } ?>
        <!-- 밥 파티 -->
        <h2>같이 밥 먹어요!</h2>
        <a id="new_party" href="new_party_form.php?shop_id=<?= $shop_id ?>&shop_name=<?= $shop_name ?>">새로운 밥 파티 개설</a>
        <p>혼자라서 가기 힘든 식당이 있나요? 새로운 인연을 만들고 싶으신가요?</p>
        <?php if ($party_list -> rowCount() == 0) {?>
            <p>파티가 없습니다. 파티를 생성하세요.</p>
        <?php } else {
            foreach ($party_list as $row) { ?>
                <div class="party_list">
                    <p><a href="party_view.php?id=<?= $row["id"] ?>&shop_id=<?= $shop_id ?>&shop_name=<?= $shop_name ?>"><?= $row["subject"] ?></a></p><span><span>지원자</span><span><?= $row["apply"] ?></span></span><span><span>모집인원</span><span><?= $row["recruit"] ?></span></span><span><?= $row["make_date"] ?></span>
                </div>
            <?php } ?>
        <?php } ?>
        <!-- 의견 기록 -->
        <h2>이곳을 평가해주세요!</h2>
        <p id = "avg_rating_display">평균 평점 <span id="avg_rating"></span><span id="other_review">외부 리뷰 보기</span></p>
        <?php if ($estimations -> rowCount() == 0) {?>
            <p>평가를 한 사람이 없습니다. 첫 번째 평가를 남겨주세요!</p>
        <?php } else {
            foreach ($estimations as $row) { ?>
                <div class="comment_info"><span><span>이름</span><span><?= $row["name"] ?></span></span><span><span>별점</span><span><?= $row["rating"] ?></span></span></div>
                <div class="comment"><?= $row["comment"] ?></div>
            <?php } ?>
        <?php } ?>
        <form name="comment" onsubmit="return submit_estimation(this);">
            <div id="comment_area">
                <input id="name_box" type="text" name="user_name" placeholder="이름" size="6"/>
                <span id="stars">
                    <span id="star1" onclick="star_click(this.id)"><i class="fa fa-star" aria-hidden="true"></i></span>
                    <span id="star2" onclick="star_click(this.id)"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                    <span id="star3" onclick="star_click(this.id)"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                    <span id="star4" onclick="star_click(this.id)"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                    <span id="star5" onclick="star_click(this.id)"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                </span>
                <input type="submit" value="올리기"/>
                <textarea name="comment" placeholder="댓글 내용"></textarea>
                <input id="rating_star" type="hidden" name="rating" value = "1"/>
                <input type="hidden" name="shop_id" value="<?= $shop_id ?>"/>
                <p>저장 버튼을 누르시는 것은 우리 사이트의 개인정보 취급에 동의하는 것이며, IP 주소가 저장됩니다. 동의를 하지 않으실 경우에는 저장 버튼을 누르지 마십시오.</p>
            </div>
        </form>
        <script src="js/view_f.js"></script>
        <script src="https://use.fontawesome.com/869fbb785e.js"></script>
        <script>
            avg_rating(<?= $avg_rating ?>);
        </script>
    </body>
</html>
