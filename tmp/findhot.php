<?php 
/*
这里我是用来放函数的，主要功能是提取字符串
*/

function Hot_content($wei_url){
	preg_match_all("/(?<=\"desc\"\:\")(.*?)\s*(?=\")/",$wei_url,$out,PREG_PATTERN_ORDER);
}

?>