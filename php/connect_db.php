<?php
/**
 * Created by PhpStorm.
 * User: jinho
 * Date: 17. 11. 10
 * Time: 오전 9:40
 * this program connect database, will implemented each php program
 */
try {
    $db = new PDO("mysql:dbname=shops;host=localhost", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    print("현재 서버에 접속할 수 없는 상태입니다.");
}
?>