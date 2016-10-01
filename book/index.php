<?php
ini_set('display_errors', '0');


	function convBase($numberInput, $fromBaseInput, $toBaseInput)
	{
	    if ($fromBaseInput==$toBaseInput) return $numberInput;
	    $fromBase = str_split($fromBaseInput,1);
	    $toBase = str_split($toBaseInput,1);
	    $number = str_split($numberInput,1);
	    $fromLen=strlen($fromBaseInput);
	    $toLen=strlen($toBaseInput);
	    $numberLen=strlen($numberInput);
	    $retval='';
	    if ($toBaseInput == '0123456789')
	    {
	        $retval=0;
	        for ($i = 1;$i <= $numberLen; $i++)
	            $retval = bcadd($retval, bcmul(array_search($number[$i-1], $fromBase),bcpow($fromLen,$numberLen-$i)));
	        return $retval;
	    }
	    if ($fromBaseInput != '0123456789')
	        $base10=convBase($numberInput, $fromBaseInput, '0123456789');
	    else
	        $base10 = $numberInput;
	    if ($base10<strlen($toBaseInput))
	        return $toBase[$base10];
	    while($base10 != '0')
	    {
	        $retval = $toBase[bcmod($base10,$toLen)].$retval;
	        $base10 = bcdiv($base10,$toLen,0);
	    }
	    return $retval;
	}


function sanitize_filename($str)
{
	static $tbl = array(
		'<' => '_',
		'>' => '_',
		':' => '_',
		'"' => '_',
		'/' => '_',
		'\\' => '_',
		'|' => '_',
		'?' => '_',
		'*' => '_',
		'#' => '_',
		';' => '_'
	);
	return strtr($str, $tbl);
}

function compose_filename($row)
{   
	$filename = '';
	if (!empty($row['Author']))
		$filename = $row['Author'];
	if (!empty($row['Title']))
		$filename .= '-' . $row['Title'];
	if (!empty($row['Series']))
		$filename = '(' . $row['Series'] . ') ' . $filename;
	if (!empty($row['Periodical']))
		$filename = '(' . $row['Periodical'] . ') ' . $filename;
	if (!empty($row['VolumeInfo']))
		$filename .= '. ' . $row['VolumeInfo'];
	if (!empty($row['Publisher']))
		$filename .= '-' . $row['Publisher'];
	if (!empty($row['Year']))
		$filename .= ' (' . $row['Year'] . ')';
	return (empty($filename) ? strtoupper($row['MD5']) : mb_substr($filename, 0, 200, 'utf-8'));
}

// Установка куки для запоминания выбора языка
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

include_once '../config.php';
include_once '../html.php';
include_once '../lang_' . $lang . '.php';



//соед.  с БД
@$con = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$con)
	die($htmlhead."Could not connect to the database: " . mysql_error().$htmlfoot);
mysql_query("SET session character_set_server = 'UTF8'");
mysql_query("SET session character_set_connection = 'UTF8'");
mysql_query("SET session character_set_client = 'UTF8'");
mysql_query("SET session character_set_results = 'UTF8'");
mysql_select_db($db, $con);


//проверяем получаемые параметры
if(isset($_GET['md5']))
{
	if (!preg_match('|^[A-Fa-f0-9]{32}$|', $_GET['md5']))
	{	
		die($htmlhead."Wrong MD5".$htmlfoot);
	}
	else
	{
		$md5 = $_GET['md5'];
	}		
}
else
{
	die($htmlhead."Missing MD5".$htmlfoot);
}


if(isset($_GET['tlm']))
{
	if (!preg_match('~^20\d{2}-(0|1)\d-(0|1|2|3)\d\ (0|1|2)\d\:\d{2}\:\d{2}$~', $_GET['tlm']))
	{	
		die($htmlhead."Wrong Time Last Modified".$htmlfoot);
	}
	else
	{
		$tlm = $_GET['tlm'];
	}
	
}
if (isset($_GET['open']))
{
	if (preg_match('/^(0|1|2|3|4|5)$/', $_GET['open']))
	{
		$open = $_GET['open'];
	}
	else
	{
		$open = 0;  //0-скачка с ориг назв. и докачкой.
	}
}
else
{
	$open = 0;
}

if($open == 0)
	$openreq = '';
else
	$openreq = '&open='.$open;


if(!isset($tlm))
{

// now look up in the database
$sql = "SELECT u.*, d.`descr`, d.`toc`, t.`topic_descr`, g.`generic_md5`, u_e.`u_tlm`, d_e.`d_tlm` ,  h.`CRC32`, h.`TTH`, h.`SHA1`, h.`eDonkey`, h.`AICH`, h.`torrent`, h.`BTIH` FROM `".$dbtable."` as `u`
LEFT JOIN `hashes`                                                as `h` ON `h`.`MD5`=`u`.`MD5` 
LEFT JOIN `".$descrtable."`                                       as `d` ON d.`MD5`=u.`MD5`
LEFT JOIN `".$topictable."`                                       as `t` ON t.`topic_id`=u.`topic` AND t.`lang` = '".$lang."'
LEFT JOIN (SELECT  GROUP_CONCAT(`md5` separator '|')              as `generic_md5` from `".$dbtable."`        as `g` WHERE `g`.`generic` = '".$md5."' ) as `g`   ON 1=1
LEFT JOIN (SELECT  GROUP_CONCAT(DATE_FORMAT(`timelastmodified`, '%Y-%m-%d %H:%i:%s') separator '|') as `u_tlm` from `".$dbtable_edited."`       as `u_e` WHERE `u_e`.`MD5` = '".$md5."' ) as `u_e` ON 1=1
LEFT JOIN (SELECT  GROUP_CONCAT(DATE_FORMAT(`timelastmodified`, '%Y-%m-%d %H:%i:%s') separator '|') as `d_tlm` from `".$descrtable_edited."`    as `d_e` WHERE `d_e`.`MD5` = '".$md5."' ) as `d_e` ON 1=1
WHERE `u`.`MD5` = '".$md5."'";

}
else
{

//echo 11111;
	//1) когда треб дата есть и в updated_edited и в descr_edited

	$sql = "SELECT u.*, d.`descr`, d.`toc`, t.`topic_descr`, g.`generic_md5` FROM `".$dbtable_edited."` as `u`
	LEFT JOIN `".$descrtable_edited."`                                       as `d` ON d.`MD5`=u.`MD5` 
	LEFT JOIN `".$topictable."`                                       as `t` ON t.`topic_id`=u.`topic` AND t.`lang` = '".$lang."'
	LEFT JOIN (SELECT  GROUP_CONCAT(`md5` separator '|')              as `generic_md5` from `".$dbtable."`        as `g` WHERE `g`.`generic` = '".$md5."' ) as `g`   ON 1=1
	WHERE `u`.`MD5` = '".$md5."' AND u.`TimeLastModified` = '".$tlm."' AND d.`TimeLastModified` = '".$tlm."' LIMIT 1";
	//echo $sql;
	if (mysql_num_rows(mysql_query($sql, $con)) == 0)
	{
//echo 22222;
		//2) когда треб дата есть и в updated_edited может быть или не быть в descr_edited
		$sql = "SELECT u.*, d.`descr`, d.`toc`, t.`topic_descr`, g.`generic_md5` FROM `".$dbtable_edited."` as `u`
		LEFT JOIN `".$descrtable_edited."`                                       as `d` ON d.`MD5`=u.`MD5`
		LEFT JOIN `".$topictable."`                                       as `t` ON t.`topic_id`=u.`topic` AND t.`lang` = '".$lang."'
		LEFT JOIN (SELECT  GROUP_CONCAT(`md5` separator '|')              as `generic_md5` from `".$dbtable."`        as `g` WHERE `g`.`generic` = '".$md5."' ) as `g`   ON 1=1
		WHERE `u`.`MD5` = '".$md5."' AND u.`TimeLastModified` = '".$tlm."' ORDER BY `d`.`descr` DESC LIMIT 1";
		//echo $sql;
		if (mysql_num_rows(mysql_query($sql, $con)) == 0)
		{
//echo 33333;
			//3) когда треб дата есть  в descr_edited, и ее нет в updated_edited, тогда берем из updated_edited первое значение меньше этой даты
			$sql = "SELECT u.*, d.`descr`, d.`toc`, t.`topic_descr`, g.`generic_md5` FROM `".$dbtable_edited."` as `u`
			LEFT JOIN `".$descrtable_edited."`                                       as `d` ON d.`MD5`=u.`MD5` AND d.`TimeLastModified` = '".$tlm."' 
			LEFT JOIN `".$topictable."`                                       as `t` ON t.`topic_id`=u.`topic` AND t.`lang` = '".$lang."'
			LEFT JOIN (SELECT  GROUP_CONCAT(`md5` separator '|')              as `generic_md5` from `".$dbtable."`        as `g` WHERE `g`.`generic` = '".$md5."' ) as `g`   ON 1=1
			WHERE `u`.`MD5` = '".$md5."' AND u.`TimeLastModified` BETWEEN   '".$tlm."' AND '2099-01-01 00:00:00'   ORDER BY u.`TimeLastModified` desc LIMIT 1";
			//echo $sql;
			if (mysql_num_rows(mysql_query($sql, $con)) == 0)
			{
//echo 444444;
				//4) когда треб дата есть  в descr_edited, и ее нет в updated_edited, тогда берем из updated_edited первое значение больше этой даты
				$sql = "SELECT u.*, d.`descr`, d.`toc`, t.`topic_descr`, g.`generic_md5` FROM `".$dbtable_edited."` as `u`
				LEFT JOIN `".$descrtable_edited."`                                       as `d` ON d.`MD5`=u.`MD5` AND d.`TimeLastModified` = '".$tlm."' 
				LEFT JOIN `".$topictable."`                                       as `t` ON t.`topic_id`=u.`topic` AND t.`lang` = '".$lang."'
				LEFT JOIN (SELECT  GROUP_CONCAT(`md5` separator '|')              as `generic_md5` from `".$dbtable."`        as `g` WHERE `g`.`generic` = '".$md5."' ) as `g`   ON 1=1
				WHERE `u`.`MD5` = '".$md5."' AND u.`TimeLastModified` BETWEEN '1999-01-01 00:00:00'  AND '".$tlm."'    ORDER BY u.`TimeLastModified` asc LIMIT 1";
				//echo $sql;
			}
		}
	}
}



$result = mysql_query($sql, $con); 
if( mysql_error() !='') //если есть ошибка, ставился неполный дамп без доп. таблиц, то берем только из updated
{ 
	unset($result); 
	$sql = "SELECT u.*, '' as `CRC32`, '' as `TTH`, '' as `SHA1`, '' as `eDonkey`, '' as `AICH` FROM `".$dbtable_edited."` as `u` WHERE `u`.`MD5` = '".$md5."'";

	$result = mysql_query($sql, $con);

}



if (!$result || mysql_num_rows($result) == 0)
{
	die($htmlhead."Error " . mysql_error() . "Cannot proceed or MD5 not found in DB".$htmlfoot);
}


//========================


$row       = mysql_fetch_assoc($result);
function htmlchars($row){$row = htmlspecialchars($row, ENT_QUOTES, 'UTF-8'); return($row);}
array_walk($row, 'htmlchars');
array_walk($row, 'trim');
$row['descr'] = htmlspecialchars_decode($row['descr']);
$row['toc'] = htmlspecialchars_decode($row['toc']);
$htmltitle = '<title>Library Genesis: ' . $row['Author'] . ' - ' . $row['Title'].'</title>';

//$row['torrent'] = convBase(strtoupper($row['SHA1']), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567', '0123456789ABCDEF');

//$row['SHA1'] = convBase(strtoupper('D53D1A331F9F126805C28DAEDE840DF6799A9D5E'), '0123456789ABCDEF', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567');

if($row['Visible'] != 'del')
include_once '../mirrors.php';
//echo $row['torrent'];

if(isset($_GET['oftorrent']) && $row['torrent'] !='')
{	//ob_start();
	header("HTTP/1.0 200 OK");
	//header("X-Accel-Redirect: ".$torrent_folder."/".$row['Filename'].".torrent");	
	header('Content-type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$row['MD5'].'.torrent"');
	echo  preg_replace('|e$|','e5:nodesll21:router.bittorrent.comi6881eel20:router.lanspirit.neti53eeee',  preg_replace('|^d4:infod6|', 'd8:announce29:http://lgtracker.org/announce13:creation datei1462923669e8:encoding5:UTF-84:infod6', base64_decode($row['torrent']))); //открыть в браузере
	die();
}

//https://cdn.rawgit.com/zenorocha/clipboard.js/master/dist/


echo str_replace('<title>Library Genesis</title>', $htmltitle, str_replace('</head>', '<script src="/clipboard.min.js"></script></head>', $htmlhead));
include_once '../menu_' . $lang . '.html';



$coverurl = $row['Coverurl'];
if ($coverurl == '')
{
	$coverurl = '../img/blank.png';
}
elseif (false === strpos($coverurl, '://'))
{
	$coverurl = $covers_repository . $coverurl;
}





if(!file_exists('../repository_torrent/r_' . substr($row['ID'], 0, -3) . '000.torrent'))
{
	$mirror_torrent_link = '#';
	$mirror_torrent_title = '<font color="grey">'.$LANG_MESS_419.'</font>';
	$mirror_torrent_tooltip = $LANG_MESS_419;
}
else
{
	$mirror_torrent_link = '/repository_torrent/r_' . substr($row['ID'], 0, -3) . '000.torrent';
	$mirror_torrent_title = $LANG_MESS_419;
	$mirror_torrent_tooltip = $LANG_MESS_419;
}




$sizebytes = $row['Filesize'];
$size      = $row['Filesize'];
if ($size >= 1024 * 1024 * 1024)
{
	$size = round($size / 1024 / 1024 / 1024);
	$size = $size . ' GB';
}
else if ($size >= 1024 * 1024)
{
	$size = round($size / 1024 / 1024);
	$size = $size . ' MB';
}
else if ($size >= 1024)
{
	$size = round($size / 1024);
	$size = $size . ' kB';
}
else
	$size = $size . ' B';

$id1 = substr($row['ID'], 0, -3);
if ($row['ID'] < 1000)
	$id1 = 0;

//$ident      = str_replace(",", ", ", $row['Identifier']);

$searchable = $row['Searchable'];
if ($searchable == '0')
{
	$searchable = 'no';
}
elseif ($searchable == '1')
{
	$searchable = 'yes';
}
else
{
	$searchable = ' ';
}
$bookmarked = $row['Bookmarked'];
if ($bookmarked == '0')
{
	$bookmarked = 'no';
}
elseif ($bookmarked == '1')
{
	$bookmarked = 'yes';
}
else
{
	$bookmarked = ' ';
}
$scanned = $row['Scanned'];
if ($scanned == '0')
{
	$scanned = 'no';
}
elseif ($scanned == '1')
{
	$scanned = 'yes';
}
else
{
	$scanned = ' ';
}
$paginated = $row['Paginated'];
if ($paginated == '0')
{
	$paginated = 'no';
}
elseif ($paginated == '1')
{
	$paginated = 'yes';
}
else
{
	$paginated = ' ';
}
$cleaned = $row['Cleaned'];
if ($cleaned == '0')
{
	$cleaned = 'no';
}
elseif ($cleaned == '1')
{
	$cleaned = 'yes';
}
else
{
	$cleaned = ' ';
}
$color = $row['Color'];
if ($color == '0')
{
	$color = 'no';
}
elseif ($color == '1')
{
	$color = 'yes';
}
else
{
	$color = ' ';
}
$orientation = $row['Orientation'];
if ($orientation == '0')
{
	$orientation = 'portrait';
}
elseif ($orientation == '1')
{
	$orientation = 'landscape';
}
else
{
	$orientation = ' ';
}
$descr = strtr($row['descr'], array(
	"<br>" => "<br/>",
	"<BR>" => "<br/>",
	"<br />" => "<br/>",
	"<BR />" => "<br/>",
	"</br>" => "<br/>",
	"</BR>" => "<br/>",
	"<p>" => "<br/>",
	"<P>" => "<br/>",
	"</p>" => "<br/>",
	"</P>" => "<br/>",
	"\r\n" => "<br/>",
	"\n" => "<br/>"
));
$descr = str_replace("&amp;lt;br/&amp;gt;", "<br/>", htmlspecialchars(strip_tags(str_replace("<br/>", "&lt;br/&gt;", html_entity_decode($descr, ENT_QUOTES, 'UTF-8'))), ENT_QUOTES));
$toc   = strtr($row['toc'], array(
	"<br>" => "<br/>",
	"<BR>" => "<br/>",
	"<br />" => "<br/>",
	"<BR />" => "<br/>",
	"</br>" => "<br/>",
	"</BR>" => "<br/>",
	"<p>" => "<br/>",
	"<P>" => "<br/>",
	"</p>" => "<br/>",
	"</P>" => "<br/>",
	"\r\n" => "<br/>",
	"\n" => "<br/>"
));

//echo $descr;

$toc   = str_replace("&amp;lt;br/&amp;gt;", "<br/>", htmlspecialchars(strip_tags(str_replace("<br/>", "&lt;br/&gt;", html_entity_decode($toc, ENT_QUOTES, 'UTF-8'))), ENT_QUOTES));
if (!empty($toc))
{
	$toc = '<HR /><font color="gray">' . $LANG_MESS_182 . ': <br/></font>' . $toc;
}


//ссылки на худщие версии
if(!empty($row['generic_md5']))
{
	$generic = array_filter(explode('|', strtoupper($row['generic_md5'])));
	foreach ($generic as $generic1)
	{
	  $generic2[] = "<a href='../book/index.php?md5=".$generic1."&open=".$open."'>".$generic1."</a>";
	}
	$generic = join("<br>", $generic2);
}
else
{
	$generic = '';
}


if(isset($tlm))
{
	$row['ID'] = '';
	$row['TimeAdded'] = $row['TimeLastModified'];
}

$filename = sanitize_filename(compose_filename($row)).'.'.$row['Extension'];

$tagnum = 0;
foreach(explode(';', trim($row['Tags'], ' ;')) as $taglink)
{
	if($tagnum==2) //показываем первые  3 тега, остальное скрываем css
	$taglinks[] = '<input type="checkbox" id="hd-1" class="taghide"/><label for="hd-1">&gt;&gt;</label><div><a href="/search.php?req='.rawurlencode($taglink).'&column=tags">'.$taglink.'</a>';
	else
	$taglinks[] = '<a href="/search.php?req='.rawurlencode($taglink).'&column=tags">'.$taglink.'</a>';

	$tagnum  = $tagnum + 1;
} 
if($tagnum > 2)
$taglinks = implode(';', $taglinks).'</div>';
else
$taglinks = implode(';', $taglinks);




//выводим ссылки на старые описания
if((!empty($row['u_tlm']) || !empty($row['u_tlm'])) && !isset($tlm))
{

	$timelastmoifiedold = $row['u_tlm'].'|'.$row['d_tlm'];
	$timelastmoifiedold = array_filter(array_unique(explode('|', $timelastmoifiedold)));
	sort($timelastmoifiedold);
	$editnum = 0;
	foreach ($timelastmoifiedold as $timelastmoifiedold1)
	{
		//$timelastmoifiedold2[] = "<a href='../book/index.php?md5=".$md5."&tlm=".$timelastmoifiedold1."'>".$timelastmoifiedold1."</a>";
		if($editnum==3) //показываем первые  3 тега, остальное скрываем css
		$timelastmoifiedold2[] = '<input type="checkbox" id="hd-2" class="taghide"/><label for="hd-2">&gt;&gt;</label><div><a href="../book/index.php?md5='.$md5.'&tlm='.$timelastmoifiedold1.'"><nobr>'.$timelastmoifiedold1.'</nobr></a>';
		else
		$timelastmoifiedold2[] = '<a href="../book/index.php?md5='.$md5.'&tlm='.$timelastmoifiedold1.'"><nobr>'.$timelastmoifiedold1.'</nobr></a>';
		$editnum  = $editnum + 1;
	}
	if($editnum > 3)
	$timelastmoifiedold = implode("; ", $timelastmoifiedold2).'</div>';
	else
	$timelastmoifiedold = implode("; ", $timelastmoifiedold2);
}
else
{
	$timelastmoifiedold = '';
}

if($row['torrent'] == '')
{
	$copy_filename = '';
}
else
{
	$copy_filename = '<br><input id="textarea-example" value="'.$filename.'" type="text" size="9"><button class="btn-clipboard" data-clipboard-target="#textarea-example">'.$LANG_MESS_417.'</button><script>new Clipboard(".btn-clipboard");</script>';
}	

echo "
<body>
<table border=0 rules=cols width=100%>
	<tr height=2 valign=top><td bgcolor='brown' colspan=5></td></tr>
		<tr valign=top><td rowspan=22 width=240>
			<a href='".$mirror_0_link."'><img src='".$coverurl."' border=0 width=240 style='padding: 5px'></a>
				<font color='gray' size=1><br/><br/><b>Hashes:</b><br/>
				AICH:".strtoupper($row['AICH'])."<br/>
				CRC32:".strtoupper($row['CRC32'])."<br/>
				eDonkey:".strtoupper($row['eDonkey'])."<br/>
				MD5:".strtoupper($row['MD5'])."<br/>
				SHA1:".strtoupper($row['SHA1'])."<br/>
				TTH:".strtoupper($row['TTH'])."
				</font>
				</td>

                <td><nobr><font color='gray'>".$LANG_MESS_5.": </font></nobr></td><td colspan=2><b><a href='".$mirror_0_link."'>".htmlspecialchars(trim($row['Title']))."</a></b></td><td><nobr><font color='gray'>".$LANG_MESS_42.": </font></nobr>".$row['VolumeInfo']."</td></tr>
		<tr valign=top><td><nobr><font color='gray'>".$LANG_MESS_6.":</font></nobr></td><td colspan=3><b>".$row['Author']."</b></td></tr>
	        <tr valign=top><td><nobr><font color='gray'>".$LANG_MESS_7.":</font></nobr></td><td>".$row['Series']."</td>                 <td><nobr><font color='gray'>".$LANG_MESS_8.":</font></nobr></td><td>".$row['Periodical']."</td></tr>
                <tr valign=top><td><nobr><font color='gray'>".$LANG_MESS_9.":</font></nobr></td><td>".$row['Publisher']."</td>              <td><nobr><font color='gray'>".$LANG_MESS_93.":</font></nobr></td><td>".$row['City']."</td></tr>
		<tr valign=top><td><nobr><font color='gray'>".$LANG_MESS_10.":</font></nobr></td><td>".$row['Year']."</td>                  <td><nobr><font color='gray'>".$LANG_MESS_43.":</font></nobr></td><td>".$row['Edition']."</td></tr>
		<tr valign=top><td><nobr><font color='gray'>".$LANG_MESS_11.":</font></nobr></td><td>".$row['Language']."</td>              <td><nobr><font color='gray'>".$LANG_MESS_28." (biblio\\tech):</font></nobr></td><td>".$row['Pages']."\\".$row['PagesInFile']."</td></tr>
		<tr valign=top><td><font color='gray'>ISBN:</font></td><td>".trim(str_replace(',', ', ', $row['Identifier']), ',. ;')."</td><td><nobr><font color='gray'>ID:</font></nobr></td><td>".$row['ID']."</td></tr>
		<tr valign=top><td><nobr><font color='gray'>".$LANG_MESS_44.":</font></nobr></td><td>".$row['TimeAdded']."</td>             <td><nobr><font color='gray'>".$LANG_MESS_45.":</font></nobr></td><td>".$row['TimeLastModified']."</td></tr>
		<tr valign=top><td><nobr><font color='gray'>".$LANG_MESS_46.":</font></nobr></td><td>".$row['Library']."</td>               <td><nobr><font color='gray'>".$LANG_MESS_47.":</font></nobr></td><td>".$row['Issue']."</td></tr>
		<tr valign=top><td><nobr><font color='gray'>".$LANG_MESS_26.":</font></nobr></td><td>".$size." (".$sizebytes." bytes)</td>  <td><nobr><font color='gray'>".$LANG_MESS_12.":</font></nobr></td><td>".$row['Extension']."</td></tr>



<tr valign=top>
   <td><font color='gray'>".$LANG_MESS_48.":</font></td><td colspan=1>".$generic."</td>
   <td><font color='gray'>BibTeX</font></td><td>
       <a href='bibtex.php?md5=".$md5."'><b>Link</b></a>
   </td>
</tr>


<tr valign='top'>
<td><nobr><font color='gray'>".$LANG_MESS_49.":</font></nobr></td><td colspan=1>".$timelastmoifiedold."</td>
<td><nobr><font color='gray'>".$LANG_MESS_54.":</font></nobr></td><td><b><a href='".$mirror_edit_link."'>".$mirror_edit_title."</a></b></td></tr>

<tr valign='top'><td><nobr><font color='gray'>".$LANG_MESS_50.":</font></nobr></td><td colspan='3'>".$row['Commentary']."</td></tr>
<tr valign='top'><td><nobr><font color='gray'>".$LANG_MESS_13.":</font></nobr></td><td>".$row['topic_descr']."</td><td><font color='gray'>".$LANG_MESS_322.":</font></td><td width=300>".$taglinks."</td>
</tr>

<tr valign='top'><td><nobr><font color='gray'>".$LANG_MESS_51.":</font></nobr></td>
<td colspan='3'><table border='0'  rules='cols'  width='100%'><tr>
<td align='center' width='11,1%'><font color='gray'>ISSN: </font></td>
<td align='center' width='11,1%'><font color='gray'>UDC: </font></td>
<td align='center' width='11,1%'><font color='gray'>LBC: </font></td>
<td align='center' width='11,1%'><font color='gray'>LCC: </font></td>
<td align='center' width='11,1%'><font color='gray'>DDC: </font></td>
<td align='center' width='11,1%'><font color='gray'>DOI: </font></td>
<td align='center' width='11,1%'><font color='gray'>OpenLibraryID: </font></td>
<td align='center' width='11,1%'><font color='gray'>GoogleID: </font></td>
<td align='center' width='11,1%'><font color='gray'>ASIN:</font></td>
</tr>
<tr>
<td align='center' width='11,1%'>".$row['ISSN']."</td>
<td align='center' width='11,1%'>".$row['UDC']."</td>
<td align='center' width='11,1%'>".$row['LBC']."</td>
<td align='center' width='11,1%'>".$row['LCC']."</td>
<td align='center' width='11,1%'>".$row['DDC']."</td>
<td align='center' width='11,1%'>".$row['Doi']."</td>
<td align='center' width='11,1%'>".$row['OpenLibraryID']."</td>
<td align='center' width='11,1%'>".$row['Googlebookid']."</td>
<td align='center' width='11,1%'>".$row['ASIN']."</td>
</tr></table></td></tr>


<tr valign='top'><td><nobr><font color='gray'>".$LANG_MESS_52.":</font></nobr></td>


<td colspan=3><table border=0  rules='cols' width='100%'><tr>
<td align='center' width='11,1%'><font color='gray'>DPI: </font></td>
<td align='center' width='11,1%'><font color='gray'>OCR:</font></td>
<td align='center' width='11,1%'><font color='gray'>Bookmarked: </font></td>
<td align='center' width='11,1%'><font color='gray'>Scanned: </font></td>
<td align='center' width='11,1%'><font color='gray'>Orientation: </font></td>
<td align='center' width='11,1%'><font color='gray'>Paginated: </font></td>
<td align='center' width='11,1%'><font color='gray'>Color: </font></td>
<td align='center' width='11,1%'><font color='gray'>Clean: </font></td>
<td align='center' width='11,1%'></td>
</tr>
<tr>
<td align='center' width='11,1%'>".$row['DPI']."</td>
<td align='center' width='11,1%'>".$searchable."</td>
<td align='center' width='11,1%'>".$bookmarked."</td>
<td align='center' width='11,1%'>".$scanned."</td>
<td align='center' width='11,1%'>".$orientation."</td>
<td align='center' width='11,1%'>".$paginated."</td>
<td align='center' width='11,1%'>".$color."</td>
<td align='center' width='11,1%'>".$cleaned."</td>
<td align='center' width='11,1%'></td>
</tr></table></td></tr>


<tr valign='top'><td><font color='gray'>".$LANG_MESS_53.":</font></td>

<td colspan='3'><table border='0'  rules='cols' width='100%'>
<tr>
<td align='center' width='11,1%'><a href='".$mirror_1_link."'>".$mirror_1_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_2_link."'>".$mirror_2_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_3_link."'>".$mirror_3_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_4_link."'>".$mirror_4_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_oftorrent_link."'>".$mirror_oftorrent_title."</a>".$copy_filename."</td>
<td align='center' width='11,1%'><a href='".$mirror_gnu_link."'>".$mirror_gnu_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_e2k_link."'>".$mirror_e2k_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_dc_link."'>".$mirror_dc_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_torrent_link."'>".$mirror_torrent_title."</a></td>

</tr></table></td></tr>
                   <tr valign='top'><td colspan=4 style='padding: 25px'>".$descr."</tr>
                   <tr valign='top'><td colspan=4 style='padding: 25px'>".$toc."</tr>
		<tr height='5' valign='top'><td bgcolor='brown' colspan=4></td></tr><tr><td colspan=4><a href='http://genofond.org/viewtopic.php?t=6423'>Error Report</a></td></tr></table>";

//echo '<br>'.$ads2;
echo $htmlfoot;
mysql_close($con);
?>