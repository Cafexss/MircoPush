
<?php   
function uni_decode($s) {   
    preg_match_all('/\&\#([0-9]{2,5})\;/', $s, $html_uni);   
    preg_match_all('/[\\\%]u([0-9a-f]{4})/ie', $s, $js_uni);   
    $source = array_merge($html_uni[0], $js_uni[0]);   
    $js = array();   
    for($i=0;$i<count($js_uni[1]);$i++) {   
        $js[] = hexdec($js_uni[1][$i]);   
    }   
    $utf8 = array_merge($html_uni[1], $js);   
    $code = $s;   
    for($j=0;$j<count($utf8);$j++) {   
        $code = str_replace($source[$j], unicode2utf8($utf8[$j]), $code);   
    }   
    return $code;//$s;//preg_replace('/\\\u([0-9a-f]{4})/ie', "chr(hexdec('\\1'))",  $s);   
}   
   
function unicode2utf8($c) {   
    $str="";   
    if ($c < 0x80) {   
         $str.=chr($c);   
    } else if ($c < 0x800) {   
         $str.=chr(0xc0 | $c>>6);   
         $str.=chr(0x80 | $c & 0x3f);   
    } else if ($c < 0x10000) {   
         $str.=chr(0xe0 | $c>>12);   
         $str.=chr(0x80 | $c>>6 & 0x3f);   
         $str.=chr(0x80 | $c & 0x3f);   
    } else if ($c < 0x200000) {   
         $str.=chr(0xf0 | $c>>18);   
         $str.=chr(0x80 | $c>>12 & 0x3f);   
         $str.=chr(0x80 | $c>>6 & 0x3f);   
         $str.=chr(0x80 | $c & 0x3f);   
    }   
    return $str;   
}

?>