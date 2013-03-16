<?php
$tlang = "vietnamese";

function lfile2array($f) {
	$o = file($f);
	foreach($o as &$r) {
		$r = trim($r);
		if (strpos($r, '$_[')===0) $r=trim(substr($r, 0, strpos($r, "=")));
		else $r="";
	}
	foreach ($o as $k=>$v) {
		if ($v=="") unset ($o[$k]);
	}
	return $o;
}

function checkdir($dir) {
	global $tlang;
	$d = dir($dir);
	while (false !== ($file = $d->read())) {
		  if (is_dir($dir.$file)&&$file!=".."&&$file!=".") checkdir($dir.$file."/");
		  else if(is_file($dir.$file)) {
		  	if (is_file(str_replace("english", $tlang, $dir.$file))) {
			  $o=lfile2array($dir.$file);
			  $t=lfile2array(str_replace("english", $tlang, $dir.$file));
			  echo str_replace("english", "X", $dir.$file)." ".count($o)." ".count($t)."\n";
			  foreach (array_diff($o, $t) as $m) {
			  	echo "\t+ ".$m."\n";
			  }
			  foreach (array_diff($t, $o) as $m) {
			  	echo "\t- ".$m."\n";
			  }
			} else "Puuttuu ".str_replace("english", $tlang, $dir.$file);
		  }
	}
}

checkdir("catalog/language/english/");
checkdir("admin/language/english/");
?>
