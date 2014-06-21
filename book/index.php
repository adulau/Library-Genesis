<?php
ini_set('display_errors', '0');

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
$sql = "SELECT u.*, d.`descr`, d.`toc`, t.`topic_descr`, g.`generic_md5`, u_e.`u_tlm`, d_e.`d_tlm` FROM `".$dbtable."` as `u`
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
	$sql = "SELECT u.* FROM `".$dbtable_edited."` as `u` WHERE  `u`.`MD5` = '".$md5."'";
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


include_once '../mirrors.php';



echo str_replace('<title>Library Genesis</title>', $htmltitle, $htmlhead);
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

//выводим ссылки на старые описания
if((!empty($row['u_tlm']) || !empty($row['u_tlm'])) && !isset($tlm))
{

	$timelastmoifiedold = $row['u_tlm'].'|'.$row['d_tlm'];
	$timelastmoifiedold = array_filter(array_unique(explode('|', $timelastmoifiedold)));
	sort($timelastmoifiedold);
	foreach ($timelastmoifiedold as $timelastmoifiedold1)
	{
		$timelastmoifiedold2[] = "<a href='../book/index.php?md5=".$md5."&tlm=".$timelastmoifiedold1."'>".$timelastmoifiedold1."</a>";
	}
	$timelastmoifiedold = join("&nbsp;&nbsp;", $timelastmoifiedold2);
}
else
{
	$timelastmoifiedold = '';
}



//ссылки на худщие версии
if(!empty($row['generic_md5']))
{
$generic = array_filter(explode('|',$row['generic_md5']));
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

                <td><font color='gray'>".$LANG_MESS_5.": </font></td><td colspan=2><b><a href='".$mirror_0_link."'>".htmlspecialchars(trim($row['Title']))."</a></b></td><td><font color='gray'>".$LANG_MESS_42.": </font>".$row['VolumeInfo']."</td></tr>
		<tr valign=top><td><font color='gray'>".$LANG_MESS_6.":</font></td><td colspan=3><b>".$row['Author']."</b></td></tr>
	        <tr valign=top><td><font color='gray'>".$LANG_MESS_7.":</font></td><td>".$row['Series']."</td><td><font color='gray'>".$LANG_MESS_8.":</font></td><td>".$row['Periodical']."</td></tr>
                <tr valign=top><td><font color='gray'>".$LANG_MESS_9.":</font></td><td>".$row['Publisher']."</td><td><font color='gray'>".$LANG_MESS_93.":</font></td><td>".$row['City']."</td></tr>
		<tr valign=top><td><font color='gray'>".$LANG_MESS_10.":</font></td><td>".$row['Year']."</td><td><font color='gray'>".$LANG_MESS_43.":</font></td><td>".$row['Edition']."</td></tr>
		<tr valign=top><td><font color='gray'>".$LANG_MESS_11.":</font></td><td>".$row['Language']."</td><td><font color='gray'>".$LANG_MESS_28.":</font></td><td>".$row['Pages']."</td></tr>
		<tr valign=top><td><font color='gray'>ISBN:</font></td><td>".trim(str_replace(',', ', ', $row['Identifier']), ',. ;')."</td><td><font color='gray'>ID:</font></td><td>".$row['ID']."</td></tr>
		<tr valign=top><td><font color='gray'>".$LANG_MESS_44.":</font></td><td>".$row['TimeAdded']."</td><td><font color='gray'>".$LANG_MESS_45.":</font></td><td>".$row['TimeLastModified']."</td></tr>
		<tr valign=top><td><font color='gray'>".$LANG_MESS_46.":</font></td><td>".$row['Library']."</td><td><font color='gray'>".$LANG_MESS_47.":</font></td><td>".$row['Issue']."</td></tr>
		<tr valign=top><td><font color='gray'>".$LANG_MESS_26.":</font></td><td>".$size." (".$sizebytes." bytes)</td><td><font color='gray'>".$LANG_MESS_12.":</font></td><td>".$row['Extension']."</td></tr>



<tr valign=top>
   <td><font color='gray'>".$LANG_MESS_48.":</font></td><td colspan=1>".$generic."</td>
   <td><font color='gray'>BibTeX</font></td><td>
       <a href='bibtex.php?md5=".$md5."'><b>Link</b></a>
   </td>
</tr>


<tr valign='top'>
<td><font color='gray'>".$LANG_MESS_49.":</font></td><td colspan=1>".$timelastmoifiedold."</td>
<td><font color='gray'>".$LANG_MESS_54.":</font></td><td><b><a href='http://libgen.org/librarian/registration?md5=" . $row['MD5']."'>Librarian libgen.org</a></b></td></tr>

<tr valign='top'><td><font color='gray'>".$LANG_MESS_50.":</font></td><td colspan='3'>".$row['Commentary']."</td></tr>
<tr valign='top'><td><font color='gray'>".$LANG_MESS_13.":</font></td><td colspan='3'>".$row['topic_descr']."</td></tr>

<tr valign='top'><td><font color='gray'>".$LANG_MESS_51.":</font></td>
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


<tr valign='top'><td><font color='gray'>".$LANG_MESS_52.":</font></td>


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
<td align='center' width='11,1%'><a href='".$mirror_5_link."'>".$mirror_5_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_6_link."'>".$mirror_6_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_e2k_link."'>".$mirror_e2k_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_magnet_link."'>".$mirror_magnet_title."</a></td>
<td align='center' width='11,1%'><a href='".$mirror_torrent_link."'>".$mirror_torrent_title."</a></td>

</tr></table></td></tr>
                   <tr valign='top'><td colspan=4 style='padding: 25px'>".$descr."</tr>
                   <tr valign='top'><td colspan=4 style='padding: 25px'>".$toc."</tr>
		<tr height='5' valign='top'><td bgcolor='brown' colspan=4></td></tr><tr><td colspan=4><a href='http://genofond.org/viewtopic.php?t=6423'>Error Report</a></td></tr></table>";


echo $htmlfoot;
mysql_close($con);
?>