<?php
//数据库链接

function connect($host=DB_HOST,$user=DB_USER,$password=DB_PASSWORD,$database=DB_DATABASE,$port=DB_PORT){ //创建一个connect 连接数据库的函数，会和index.php
	$link = @mysqli_connect($host,$user,$password,$database,$port); // link变量是链接数据库的
	if(mysqli_connect_error()){
		exit(mysqli_connect_error());  //错误退出
		}
	mysqli_set_charset($link,'utf8');; // 设置编码格式 
	return $link;

}


//执行一条sql语句，返回结果集对象或者返回布尔值


function execute($link,$query){ //create function  // 这个函数的功能是返回一个结果集
	$result = mysqli_query($link,$query); //query mysql  执行数据库语句
	if(mysqli_errno($link)){ //if $link error 错误
		exit(mysqli_error($link)); //exit return error
	}
	return $result; // return  返回一个语句

}
//执行sql语句，只会返回布尔值

function execute_bool($link,$query){ // 此自定义函数的功能是返回一个布尔值的结果

	$bool = mysqli_real_query($link,$query); //使用自带的Mysqli函数
	if (mysqli_errno($link)){
		exit(mysqli_error($link));
	}
	return $bool;
}

function execute_multi($link,$arr_sqls,&$error){
	$sqls=implode(';',$arr_sqls).';';
	if(mysqli_multi_query($link,$sqls)){
		$data=array();
		$i=0;//计数
		do {
			if($result=mysqli_store_result($link)){
				$data[$i]=mysqli_fetch_all($result);
				mysqli_free_result($result);
			}else{
				$data[$i]=null;
			}
			$i++;
			if(!mysqli_more_results($link)) break;
		}while (mysqli_next_result($link));
		if($i==count($arr_sqls)){
			return $data;
		}else{
			$error="sql语句执行失败：<br />&nbsp;数组下标为{$i}的语句:{$arr_sqls[$i]}执行错误<br />&nbsp;错误原因：".mysqli_error($link);
			return false;
		}
	}else{
		$error='执行失败！请检查首条语句是否正确！<br />可能的错误原因：'.mysqli_error($link);
		return false;
	}
}


function num($link,$sql_count){  //此自定义函数是技术功能
	$result = execute($link,$sql_count); // 调用了上一个函数execute，执行数据库语句
	$count = mysqli_fetch_row($result); /// 然后把结果放在 row这个函数里开始计数
	return $count[0]; //返回第0个结果
}

//mysql存入数据库进行转义；
function escape($link,$data){ // 创建一个自定义的函数escape
	if(is_string($data)){ //如果是一个字符串
		return mysqli_real_escape_string($link,$data);  //把data指尖通过escape进行转义
	}
	if(is_array($data)){  //如果是一个数组
		foreach($data as $key=>$val){  //通过foreach循环
			$data[$key] = escape($link,$val);  //Key等于键名
			                              

		}

	}
	return $data; // 然后在返回一个$data
}









//close mysql connect
function close($link){
	mysqli_close($link);
}
function killxss($val){
	 // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed  
   // this prevents some character re-spacing such as <java\0script>  
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs  
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);  
     
   // straight replacements, the user should never need these since they're normal characters  
   // this prevents like <IMG SRC=@avascript:alert('XSS')>  
   $search = 'abcdefghijklmnopqrstuvwxyz'; 
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
   $search .= '1234567890!@#$%^&*()'; 
   $search .= '~`";:?+/={}[]-_|\'\\'; 
   for ($i = 0; $i < strlen($search); $i++) { 
      // ;? matches the ;, which is optional 
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars 
    
      // @ @ search for the hex values 
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ; 
      // @ @ 0{0,7} matches '0' zero to seven times  
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ; 
   } 
    
   // now the only remaining whitespace attacks are \t, \n, and \r 
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base'); 
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 
   $ra = array_merge($ra1, $ra2); 
    
   $found = true; // keep replacing as long as the previous round replaced something 
   while ($found == true) { 
      $val_before = $val; 
      for ($i = 0; $i < sizeof($ra); $i++) { 
         $pattern = '/'; 
         for ($j = 0; $j < strlen($ra[$i]); $j++) { 
            if ($j > 0) { 
               $pattern .= '(';  
               $pattern .= '(&#[xX]0{0,8}([9ab]);)'; 
               $pattern .= '|';  
               $pattern .= '|(&#0{0,8}([9|10|13]);)'; 
               $pattern .= ')*'; 
            } 
            $pattern .= $ra[$i][$j]; 
         } 
         $pattern .= '/i';  
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag  
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags  
         if ($val_before == $val) {  
            // no replacements were made, so exit the loop  
            $found = false;  
         }  
      }  
   }  
   return $val;  
}   


?>