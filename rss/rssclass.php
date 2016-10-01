<?php

	include '../config.php';

	@$con = mysql_connect($dbhost,$dbuser,$dbpass);
	if (!$con)
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font>Could not connect to the database: ".mysql_error()."<br>Cannot proceed.<p>Please, report on the error from <a href=>the main page</a>.".$htmlfoot);

	mysql_query("SET session character_set_server = 'UTF8'");
	mysql_query("SET session character_set_connection = 'UTF8'");
	mysql_query("SET session character_set_client = 'UTF8'");
	mysql_query("SET session character_set_results = 'UTF8'");
	mysql_select_db($db,$con);

	DEFINE ('LINK', $con);
	DEFINE ('DB_USER', $dbuser);
	DEFINE ('DB_PASSWORD', $dbpass);
	DEFINE ('DB_HOST', $dbhost);
	DEFINE ('DB_NAME', $db);
	DEFINE ('SERVERNAME', $servername);

class RSS
{
	public function GetFeed()
	{
		include 'strings.php';

		// pagination
		global $dbtable,$maxnewslines,$pagesperpage;
		$where = '';
		/*if(isset($_GET['onlynew']))
		{
			$where = "  ( `commentary` NOT LIKE '%(add ocr)' ) AND ";
		}
		else 
		{
			$where = " 1=1 ";
		}
		*/

		if (isset($_GET['topicid']) && preg_match('|^[0-9]{1,3}$|', $_GET['topicid']))
		{
			$topic = $_GET['topicid'];
			if(in_array ($topic, array('1', '12', '32', '38', '41', '57', '64', '69', '102', '113', '147', '178', '183', '189', '198', '205', '210', '264', '289', '296', '305', '314')) ) 
			{
				$where .= "  ( `topic` = '".$topic."' OR `topic` IN (SELECT `topic_id` FROM `topics` WHERE `topic_id_hl` = '".$topic."' AND `lang` = 'ru') ) AND ";
			} 
			else 
			{
				$where .= "  ( `topic` = '".$topic."' ) AND ";
			}
		}
		else
		{
			$where .= " ";
		}


		if(isset($_GET['language']))
		{
			$where .= " `language` = '".mysql_real_escape_string($_GET['language'])."'  AND  ";
		}


		$sql_cnt = "SELECT COUNT(*) FROM ".$dbtable." WHERE 1=1 AND ".$where." `Visible`='' ";
//echo $sql_cnt;
		$result = mysql_query($sql_cnt,LINK);
		if (!$result) die('');
		$row = mysql_fetch_assoc($result);
		$count = stripslashes($row['COUNT(*)']);


		mysql_free_result($result);

		$pagestotal = ceil($count/$maxnewslines);
		if ($pagestotal <= 1) $pagestotal = 1;

		if (isset($_GET['page'])) $page = $_GET['page'];
		else $page = 1;

		$query = "SELECT * FROM $dbtable WHERE 1=1 AND ".$where." Visible='' ORDER BY `ID` DESC LIMIT ".($page-1)*$maxnewslines.",$maxnewslines;";
		//echo $query;
		$res = mysql_query ($query, LINK);
		$numlines = sizeof($res);

		if (false === strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'google')){
			$svrlnk = 'http://'.SERVERNAME.'/news/index.php?page=1';
		} else {
			$svrlnk = 'http://google.com/';
		}

		// items
		$items = '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

<channel>
	<atom:link href="http://'.SERVERNAME.'/rss/rss.php" rel="alternate" type="application/rss+xml" title="Library Genesis: News" />	
	<title>Library Genesis: News</title>
	<link>'.$svrlnk.'</link>
	<description>Library Genesis</description>

';

		while($row = mysql_fetch_array($res))
		{


			$title = htmlspecialchars(trim($row['Title']), ENT_QUOTES);
			$author = htmlspecialchars(trim($row['Author']), ENT_QUOTES);
			$vol = htmlspecialchars(trim($row['VolumeInfo']), ENT_QUOTES);
			$publisher = htmlspecialchars(trim($row['Publisher']), ENT_QUOTES);
			$year = htmlspecialchars(trim($row['Year']), ENT_QUOTES);
			$pages = htmlspecialchars(trim($row['Pages']), ENT_QUOTES);
			$periodical = htmlspecialchars(trim($row['Periodical']), ENT_QUOTES);
			$series = htmlspecialchars(trim($row['Series']), ENT_QUOTES);
			$lang = htmlspecialchars(trim($row['Language']), ENT_QUOTES);
			$ident = htmlspecialchars(trim($row['Identifier']), ENT_QUOTES);
			$edition = htmlspecialchars(trim($row['Edition']), ENT_QUOTES);
			$ext = htmlspecialchars(trim($row['Extension']), ENT_QUOTES);
			$library = htmlspecialchars(trim($row['Library']), ENT_QUOTES);
			//$filename = htmlspecialchars(trim($row['Filename']), ENT_QUOTES);

			$coverurl = htmlspecialchars(trim($row['Coverurl']), ENT_QUOTES);
			if ($coverurl == '')
			{
				$coverurl = '../img/blank.png';
			}
			elseif (false === strpos($coverurl, '://'))
			{
				$coverurl = '/covers/' . $coverurl;
			}
	

			$timeadded = $row['TimeAdded'];
			$id = $row['ID'];
			$size = $row['Filesize'];

			




			if ($periodical <> '') {
				$booknameperiod1 = '['.$periodical.'] ';
				$booknameperiod2 = '<font color="gray"><i>'.$periodical.'</i></font> ';

			}
			else
			{
				$booknameperiod1 = '';
				$booknameperiod2 = '';
			}


			if ($series != '') {
				$booknameseries1 = '('.$series.') ';
				$booknameseries2 = '<font color="green"><i>('.$series.')</i></font> ';
                        } 
			else
			{
				$booknameseries1 = '';
				$booknameseries2 = '';
			}

                        $bookname1 = $booknameperiod1.$booknameseries1.$title; //для ссылки
                        $bookname2 = $booknameperiod2.$booknameseries2.$title; //для описания
			unset($booknameperiod1); unset($booknameperiod2); unset($booknameseries1); unset($booknameseries2);

			if ($size >= 1024*1024*1024){
				$size = round($size/1024/1024/1024);
				$size = $size.' GB';
			} else
			if ($size >= 1024*1024){
				$size = round($size/1024/1024);
				$size = $size.' MB';
			} else
			if ($size >= 1024){
				$size = round($size/1024);
				$size = $size.' kB';
			} else
				$size = $size.' B';

			///////////
			// book info section (in parentheses)
			$volinf = $publisher;

			if ($volinf){
				if ($year) $volinf = $volinf.', '.$year;
			} else {
				if ($year) $volinf = $year;
			}

			if ($lang == 'Russian') $pp = ' '.$str_pp_ru;
			else $pp = ' '.$str_pp_en;
			if ($volinf){
				if ($pages) $volinf = $volinf.', '.$pages.$pp;
			} else {
				if ($pages) $volinf = $pages.$pp;
			}

			///////////


			$vol_ed = $vol;
			if ($lang == 'Russian') $ed = ' '.$str_edition_ru;
			else $ed = ' '.$str_edition_en;
			if ($vol_ed){
				if ($edition) $vol_ed = $vol_ed.', '.$edition.$ed;
			} else {
				if ($edition) $vol_ed = $edition.$ed;
			}

			$volume = '';
			if ($vol_ed) $volume = ' <font face="Times" color="green"><i>['.$vol_ed.']</i></font>';

			$volstamp = '';
			if ($volinf) $volstamp = ' <font face="Times" color="green"><i>('.$volinf.')</i></font>';

			if (false === strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'google')){
				$link = htmlspecialchars(trim('http://'.SERVERNAME.'/book/index.php?md5='.$row['MD5']));
			} else {
				$link = 'http://google.com/';
			}


			$descr = '<table border="0"><tr>
			<td rowspan=9 width=120><a href="'.$link.'"><img src="'.$coverurl.'" width="120"></a></td>
			<td valign="top" colspan="2">'.$author.'. <b>'.$bookname2.'</b>'.$volume.$volstamp.'</td></tr>
			<tr><td valign="top" width="160"><font color="grey">Author:</font></td><td>'.$author.'</td></tr>
			<tr><td valign="top"><font color="grey">ISBN:</font></td><td>'.$ident.'</td></tr>
			<tr><td valign="top"><font color="grey">Size:</font></td><td>'.$size.' ['.$ext.']</td></tr>
			<tr><td valign="top"><font color="grey">Periodical:</font></td><td>'.$periodical.'</td></tr>
			<tr><td valign="top"><font color="grey">Series:</font></td><td>'.$series.'</td></tr>
			<tr><td valign="top"><font color="grey">Language:</font></td><td>'.$lang.'</td></tr>
			<tr><td valign="top"><font color="grey">ID:</font></td><td>'.$id.'</td></tr>
			<tr><td valign="top"><font color="grey">Date Added:</font></td><td>'.$timeadded.'</td></tr>
			</table>
		';

			$items .= '	<item>
		<guid isPermaLink="false">'.$row['MD5'].'</guid>
		<title>'.$bookname1.'</title>
		<link>'.$link.'</link>
		<description>'.htmlspecialchars($descr).'</description>
	</item>';
unset ($bookname1); unset ($bookname2);
		}
		$items .= '</channel>
</rss>';
		return $items;
	}

}

?>