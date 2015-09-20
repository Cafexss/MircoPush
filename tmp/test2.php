<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'setcode.php';
$link=mysqli_connect('127.0.0.1','root','123456','Weihot',3306); //
mysqli_set_charset($link,'utf8');
$query="INSERT INTO Hot_now(Hot_content,Hot_url,Hot_click,Hot_tims) VALUES('ABC','DEF',123,now());";
mysqli_query($link,$query);
?>