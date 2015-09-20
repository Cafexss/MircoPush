<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
//
$query="select (select sleep(3))";
if(execute($link,$query)){
	echo 'this is mysql sleep test.. 3\'s';
}

?>