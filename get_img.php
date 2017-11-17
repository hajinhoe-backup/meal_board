<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 14
 * Time: 오후 12:31
 */
$menu_name = $_GET["menu_name"];

$ch = curl_init();

$menu_name = curl_escape($ch, $menu_name);

$url = "https://www.google.co.kr/search?q=$menu_name&tbm=isch";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ch);
$start = strpos($html, "<div id=\"search\">");
$html = substr($html, $start);
$start = strpos($html, '<img');
$html = substr($html, $start);
$start = strpos($html, 'src="');
$html = substr($html, $start+5);
$end = strpos($html, "\"");
$html = substr($html, 0,$end);
echo $html;
curl_close($ch);

?>