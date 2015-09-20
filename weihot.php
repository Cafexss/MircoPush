<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include 'setcode.php';
//header("Content-type:text/html;Charset=utf-8");
/*
1.获取网页内容  
2.进行正则匹配输出内容
3.定时十分钟内刷新
3.建立数据库存储
4.email发送
[\"desc\"]\:\"(.+?)\"
"desc":"陈梓童","desc_extr":"3534727","scheme":"http:\/\/m.weibo.cn\/p\/index?containerid=100103type%3D%26q%3D%E9%99%88%E6%A2%93%E7%AB%A5"
*/

#$str="\"desc\":\"陈A童\"\"desc\":\"陈B童\"\"desc\":\"陈C童\"";

$link=mysqli_connect('127.0.0.1','root','123456','Weihot',3306); //
mysqli_set_charset($link,'utf8');

$fh= file_get_contents('http://m.weibo.cn/p/index?containerid=100103type%3D25%26q%3D%E7%BB%BC%E5%90%88%E7%83%AD%E6%90%9C%E6%A6%9C%26cat%3Dall%26t%3D6&title=%E7%BB%BC%E5%90%88%E7%83%AD%E6%90%9C%E6%A6%9C&extparam=100103type%3D25%26cuid%3D%26q%3D%26t%3D%26sid%3Dt_wap%26category%3D10109%26pos%3D0_1%26wm%3D&uid=');

//$hot_preg="\".+?\":\"[^\"]+?\",";  "desc_extr":"3534727","
//获取点击量
preg_match_all("/(?<=\"desc_extr\"\:\")(\d+)\s*(?=\")/",$fh,$out1,PREG_PATTERN_ORDER);
$result_click=@array_unique($out1); //去重复
foreach ($result_click as $val_click) {
	// for($i=0;$i<=49;$i++){
	// 	$hot_click=$val[$i]; //最终获取到这个点击量

	// }

	# code...
}
	//var_dump($hot_cilck);
//获取内容
preg_match_all("/(?<=\"desc\"\:\")(.*?)\s*(?=\")/",$fh,$out2,PREG_PATTERN_ORDER);
$result_content=@array_unique($out2);
foreach ($result_content as $val_content){
	// for($i=0;$i<=49;$i++){
	// 	$hot_content=$val[$i];
	// }

}
//获取url
preg_match_all("/(?<=\"scheme\"\:\")(.*?)\s*(?=\")/",$fh,$out3,PREG_PATTERN_ORDER);
$result_url=@array_unique($out3);
foreach ($result_url as $val_url){
	// for($i=0;$i<=49;$i++){
	// 	$hot_url=$val1[$i];
	// }

}

for($i=0;$i<=49;$i++){
	$hot_content=uni_decode($val_content[$i]);
	$hot_url=$val_url[$i];
	$hot_click=$val_click[$i];
	$query="INSERT INTO Hot_now(Hot_content,Hot_url,Hot_click,Hot_tims) VALUES('{$hot_content}','{$hot_url}','{hot_click}',now())";
    execute($link,$query);

}



?>


