<?php
/**
 * Created by IntelliJ IDEA.
 * User: ByeongGil Jung
 * Date: 2017-11-01
 * Time: 오후 4:32
 */

// cURL 사용

class RTR_Parsing_test {

    private $url = 'https://www.google.co.kr/search?';

    private $name; // 가게 이름
    private $menu; // 메뉴
    private $category; // 카테고리
    private $price; // 가격
    private $phone_number; // 전화번호
    private $address; // 주소
    private $homepage; // 홈페이지 주소
    private $business_hour; // 영업시간
    private $introduction; // 소개
    private $order_method; // 주문 방식 (예약, 배달, 포장 등등)
    private $review; // 리뷰


    function __construct($id) {
        $this->html .= $id;
    }


    public function get_html($id) {
        $this->url .= $id;
        echo $this->url;

        // curl init
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $c_info = curl_getinfo($ch);

        // curl close
        curl_close($ch);

        if ($c_info['http_code'] != 200) {
            return "Error";
        }
        return $output;
    }

    public function get_element($html) {
        $source = $this->get_html($html);
        $output = "";
        $names = array();
        $menus = array();

        // name parsing
        $name_regex = '/\<strong\sclass\=\\"name\\"\>([^<>]+)\<\/strong\>/';
        preg_match($name_regex, $source, $names);
        $output .= $names[1];

        // menu parsing
        $menu_regex = '\<span\sclass\=\"name\"\>([^<>]+)\<\/span\>';
        preg_match($menu_regex, $source, $menus);
        $output .= $menus[1];


        return $output;


    }



}

$test = new RTR_Parsing_test();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="EUC-KR">
    <title>test</title>
</head>
<body>
<?=$test->get_html("q=청경채무침&source=lnms&tbm=isch&sa=X");?>
<p>----------------------------------------------------------------</p>
</body>
</html>
