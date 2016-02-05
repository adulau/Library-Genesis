<?php
ini_set('max_execution_time', '36000');

ini_set('display_errors', '0');
include_once 'connect.php';
include_once 'html.php';
echo $htmlhead;

if (isset($_COOKIE['lang']))
{
	$lang      = $_COOKIE['lang'];
	$lang_file = 'lang_' . $lang . '.php';
	if (!file_exists($lang_file))
	{
		$lang_file = 'lang_en.php';
	}
}
else
{
	$lang      = 'en';
	$lang_file = 'lang_en.php';
}

include $lang_file;
include_once 'menu_' . $lang . '.html';

$page = "<table width=1024 border=1 cellspacing=0 cellpadding=0 bordercolor='#A00000' align=center>
<caption><font color='#A00000'><h1><a href='batchsearchindex.php'>$LANG_MESS_136</a> <a href='/'>Library Genesis</a></h1></font><br></caption>
<tr><td><FORM name='filenames' enctype='multipart/form-data' METHOD='POST' ACTION='batchsearchindex.php'>
<table  cellspacing=0 border=0 width=1000 height=100% align=center>
<tr><td><INPUT TYPE='submit' name='submit' value='".$LANG_SEARCH_0."'></td><td>".str_replace('50', 500, $LANG_MESS_120).":</td></tr>
<tr><td><select name='wordminlength' size='1'>
<option value='0'>0</option>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
<option value='6'>6</option>
<option value='7'>7</option>
<option value='8'>8</option>
<option value='9'>9</option>
</select>".$LANG_MESS_129."<hr></td><td rowspan=8><div><textarea id='teTestCode' name='dsk' rows='20' cols='80'></textarea></div></td></tr>
<tr><td><input name='skobki'  VALUE='1' type='checkbox' />".$LANG_MESS_123." ()[]{}<hr></td></tr>
<tr><td><input name='raschirenie'  VALUE='1' type='checkbox' />".$LANG_MESS_122." (.*)<hr></td></tr>
<tr><td><input name='translit'  VALUE='1' type='checkbox' />".$LANG_MESS_121." (LAT-RUS, kolxo3)<hr></td></tr>
<tr><td><input name='stopwords' type='text' size=40 maxlength=100/><br>".$LANG_MESS_124."<hr></td></tr>
<tr><td><input name='isbn'  VALUE='1' type='checkbox' />".$LANG_MESS_131."<hr></td></tr>
<tr><td><input name='md5hash'  VALUE='1' type='checkbox' />".$LANG_MESS_130."<hr></td></tr>
<tr><td><input name='nearyear'  VALUE='1' type='checkbox' />".$LANG_MESS_185."</td></tr>

<tr><td></td><td></td></tr>
</table>
</FORM>
</td></tr>
</table>";

if(empty($_POST))
{
	echo $page;
}
else
{
	 echo "<table width=1024 cellspacing=1 cellpadding=1 rules=rows align=center>
	<thead><tr>
	<td width=500><b>".$LANG_MESS_186."</b></td>
	<td width=460><b>".$LANG_MESS_187."</b></td>
	<td width=40><b>".$LANG_MESS_188."</b></td>
	</tr></thead>";
	
	
	@$resp = $_POST['dsk'];
	@$wordminlength = $_POST['wordminlength'];
	@$stopwords = $_POST['stopwords'];
	@$translit = $_POST['translit'];
	@$skobki = $_POST['skobki'];
	@$raschirenie = $_POST['raschirenie'];
	@$md5hash = $_POST['md5hash'];
	@$isbn = $_POST['isbn'];
	@$nearyear = $_POST['nearyear']; //ищем год примерно +-1
	
	//echo $stopwords;
	$stopwords = str_replace(' ','',$stopwords);
	$stopwords = mb_strtolower(trim($stopwords), 'UTF8');
	$stopwords = explode(",", $stopwords);
	$a1=explode("\r\n", $resp);
	$a1 = array_slice($a1,0,500);
	
	foreach ($a1 as $a9) 
	{
		if($skobki)
		{
			$a0 = strip_tags(str_replace(array('{','}'), array('<','>'), str_replace(array('(',')'), array('<','>'), str_replace(array('[',']'), array('<','>'), $a9))));
		}else
		{
			$a0 = $a9;
		}

		if($raschirenie)
		{
			$pos = mb_strrpos($a0, ".", 'UTF-8');
			if(!$pos)
			{
				$pos = mb_strlen($a0, 'UTF-8');
			}
			$a0 = mb_substr($a0, 0, $pos, 'UTF-8');
		}

		if($translit)
		{
			$tbl= array(
			'shch' => 'Щ',
			'yo' => 'Ё',
			'zh' => 'Ж',
			'j#' => 'Й',
			'ch' => 'Ч',
			'sh' => 'Ш',
			'e#' => 'Э',
			'ju' => 'Ю',
			'ja' => 'Я',
			'a' => 'А',
			'b' => 'Б',
			'v' => 'В',
			'g' => 'Г',
			'd' => 'Д',
			'e' => 'Е',
			'z' => 'З',
			'i' => 'И',
			'k' => 'К',
			'l' => 'Л',
			'm' => 'М',
			'n' => 'Н',
			'o' => 'О',
			'p' => 'П',
			'r' => 'Р',
			's' => 'С',
			't' => 'Т',
			'u' => 'У',
			'f' => 'Ф',
			'h' => 'Х',
			'c' => 'Ц',
			'~' => 'ъ',
			'`' => 'ь',
			'y' => 'Ы');
			$a0 = mb_strtolower($a0, 'UTF8');
			$a0 = strtr($a0, $tbl);
		}
		
		
		if(!$isbn)
		{
			$a4 = preg_replace('/[[:punct:]]+/u', ' ', $a0);                
			$a5 = preg_replace('/[\s]+/u',' ',$a4);
			$a6 = mb_strtolower(trim($a5), 'UTF8');
			$a2 = explode(" ", $a6);
		}
			else{$a6 = preg_replace('/[[:punct:]]/', '', str_replace('—', '', str_replace('–', '', $a0)));
			$a2 = explode(" ", $a6);
		}
		
		for($i = 0, $c = count($a2); $i < $c; $i++)
		{
		    if(mb_strlen($a2[$i], 'UTF-8') <= $wordminlength)
		        unset($a2[$i]);
		}
		
		//print_r($a2);
		
		
		if($stopwords!='')
		{
			$a2 = array_diff($a2, $stopwords);
			$a2 = implode(' ', $a2);
			$a2 = preg_replace('/[\s]+/u',' ',$a2);
			$a2 = explode(' ', $a2);
		}

		if(!$isbn && !$md5hash)
		{
			foreach ($a2 as $a3)
			{
				if (preg_match('~^[0-9]{1,3}$~', $a3)) //для случая, если ищется номер, который может быть записан с 0 в начале
				{
					//$matchparts[] = "MATCH(`title`,`author`,`series`,`publisher`,`year`,`periodical`,`volumeinfo`) AGAINST('" . ltrim($a3, "0") . " " . $a3 . " 0" . $a3 . " 00" . $a3 . " 000" . $a3 . "'  IN BOOLEAN MODE) ";
					$matchparts[] = "+(" . ltrim($a3, "0") . " 0" . ltrim($a3, "0") . " 00" . $a3 . " 000" . ltrim($a3, "0") . ")";
				}
				else
				{
					if($nearyear == '1' && preg_match('~^(18|19|20)[0-9]{2}$~', $a3))
					{
						$matchparts[] = "+(" . ($a3 - 1) . " " . ($a3 + 1) . " " . $a3 . ")";
					}
					else	
					{
						$matchparts[] = '+'.$a3.'*'; //*
					}
				}
				                                  
			}
			$sql = "SELECT COUNT(*) FROM `updated` WHERE MATCH(`title`,`author`,`series`,`publisher`,`year`,`periodical`,`volumeinfo`) AGAINST ('» ".implode(' ', $matchparts)."»' IN BOOLEAN MODE)  AND `visible` ='' AND `filename` != '' LIMIT 20";
			$result = mysql_query($sql,$con);
			$row = mysql_fetch_assoc($result);
			$totalrows = stripslashes($row['COUNT(*)']);
			unset($matchparts);
			$getparameters = '&column=def'; 
		}
		elseif($isbn && !$md5hash)
		{
			if(preg_match('~^(979-|978-|979|978|)[0-9]{1,5}[-][0-9]{1,7}[-][0-9]{1,6}[-][0-9X]$~', $a2[0]) || preg_match('~^(979|978|)[0-9]{9}[0-9X]{1}$~', $a2[0]))
			{
				$sql = "SELECT COUNT(*) FROM updated WHERE MATCH(`identifier`) AGAINST('*".$a2[0]."*' IN BOOLEAN MODE) ";
				$result = mysql_query($sql,$con);
				$row = mysql_fetch_assoc($result);
				$totalrows = stripslashes($row['COUNT(*)']);
				if ($totalrows == 0)
				{
					$sql = '';//"SELECT COUNT(*) FROM updated WHERE replace(identifier, '-', '') like '%".$a2[0]."%'";
					$result = mysql_query($sql,$con);
					$row = mysql_fetch_assoc($result);
					$totalrows = stripslashes($row['COUNT(*)']);
				}
			}
			$getparameters = '&column[]=identifier';
		}
		elseif(!$isbn && ($md5hash && preg_match('|^[0-9A-Fa-f]{32}$|', $a2[0])))
		{
			$sql = "SELECT COUNT(*) FROM updated WHERE `MD5`='".$a2[0]."' ";
			$result = mysql_query($sql,$con);
			$row = mysql_fetch_assoc($result);
			$totalrows = stripslashes($row['COUNT(*)']);
			$getparameters = '&column[]=md5';
		}
		//echo $sql;
		$a7 = implode(' ', $a2);
		echo "<tr><td width=500>".htmlspecialchars($a9, ENT_QUOTES, 'UTF-8')."</td><td width=460><a href='../search?req=$a7&nametype=orig$getparameters' title='$a7'>$a7</a></td><td width=40>$totalrows</td></tr>";
	}
}
echo $htmlfoot;
mysql_close($con);
?>

