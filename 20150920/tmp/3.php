
<?php 
$str ="\"desc\":\"陈梓童\"\"desc\":\"abc\"\"desc\":\"eee\"\"de313sc\":\"999\"\"desc\":\"asdsa\"";
preg_match_all("/",$str,$out,PREG_PATTERN_ORDER); 
foreach($out as $val){
	if(is_array($val)){
		foreach($val as $values){
			echo $values;
		}
	}
}
?>