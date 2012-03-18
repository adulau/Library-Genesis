<?php
	include 'connect.php';

class RSS
{
	public function GetFeed()
	{
		include 'strings.php';

		// pagination
		global $dbtable,$maxnewslines,$pagesperpage;

		$sql_cnt = "SELECT COUNT(*) FROM $dbtable WHERE Filename!='' AND Generic='' AND Visible='';";
		$result = mysql_db_query(DB_NAME,$sql_cnt,LINK);
		if (!$result) die($dberr);
		$row = mysql_fetch_assoc($result);
		$count = stripslashes($row['COUNT(*)']);
		mysql_free_result($result);

		$pagestotal = ceil($count/$maxnewslines);
		if ($pagestotal <= 1) $pagestotal = 1;

		if (sizeof($_GET)) $page = $_GET['page'];
		else $page = 1;

		$query = "SELECT * FROM $dbtable WHERE Filename!='' AND Generic='' AND Visible='' ORDER BY ID DESC LIMIT ".($page-1)*$maxnewslines.",$maxnewslines;";
		$res = mysql_db_query (DB_NAME, $query, LINK);
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
	<atom:link href="http://'.SERVERNAME.'/rss/rss.php" rel="self" type="application/rss+xml"/>
	<title>Library Genesis: News</title>
	<link>'.$svrlnk.'</link>
	<description>Library Genesis</description>

';

		while($row = mysql_fetch_array($res))
		{
			$coverurl = htmlspecialchars(trim($row['Coverurl']));
			if ($coverurl == '') $coverurl = 'blank.png';

			$title = stripslashes($row['Title']);
			$author = stripslashes($row['Author']);
			$vol = stripslashes($row['VolumeInfo']);
			$publisher = stripslashes($row['Publisher']);
			$year = $row['Year'];
			$pages = $row['Pages'];
			$periodical = stripslashes($row['Periodical']);
			$series = stripslashes($row['Series']);
			$lang = stripslashes($row['Language']);
			$ident = stripslashes($row['Identifier']);
			$edition = stripslashes($row['Edition']);
			$ext = stripslashes($row['Extension']);
			$library = stripslashes($row['Library']);
			$filename = stripslashes($row['Filename']);

			$bookname = '';
			if ($series <> '') {
				$bookname = '<font face="Times" color="green"><i>('.$series.') </i></font>';
			}

			$bookname1 = '';
			if ($periodical <> '') {
				$bookname1 = '<font face="Times" color="Red"><i>'.$periodical.' </i></font>';
			}

			$bookname = $bookname1.$bookname.$title;

			$size = $row['Filesize'];
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

			$descr = '<table><tr><td valign="top" colspan="2">'.htmlspecialchars($author).'. <b>'.$bookname.'</b>'.$volume.$volstamp.'</td></tr>
			<tr><td valign="top" width="160"><font color="grey">Author:</font></td><td>'.$author.'</td></tr>
			<tr><td valign="top"><font color="grey">ISBN:</font></td><td>'.$ident.'</td></tr>
			<tr><td valign="top"><font color="grey">Size:</font></td><td>'.$size.' ['.htmlspecialchars($ext).']</td></tr>
			<tr><td valign="top"><font color="grey">Topic:</font></td><td>'.htmlspecialchars(trim($row['Topic'])).'</td></tr>
			<tr><td valign="top"><font color="grey">Periodical:</font></td><td>'.htmlspecialchars(trim($row['Periodical'])).'</td></tr>
			<tr><td valign="top"><font color="grey">Series:</font></td><td>'.htmlspecialchars(trim($row['Series'])).'</td></tr>
			<tr><td valign="top"><font color="grey">Language:</font></td><td>'.$lang.'</td></tr>
			<tr><td valign="top"><font color="grey">ID:</font></td><td>'.$row['ID'].'</td></tr>
			<tr><td valign="top"><font color="grey">Date Added:</font></td><td>'.htmlspecialchars(trim($row['TimeAdded'])).'</td></tr>
			<tr><td valign="top"><font color="grey">Commentary:</font></td><td>'.htmlspecialchars(strip_tags(trim($row['Commentary']))).'</td></tr>
			</table>
		';

			if (false === strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'google')){
				$link = htmlspecialchars(trim('http://'.SERVERNAME.'/get?nametype=orig&md5='.$row['MD5']));
			} else {
				$link = 'http://google.com/';
			}

			$items .= '	<item>
		<guid isPermaLink="false">'.$row['MD5'].'</guid>
		<title>'.htmlspecialchars($bookname).'</title>
		<link>'.$link.'</link>
		<description>'.htmlspecialchars($descr).'</description>
	</item>
';
		}
		$items .= '</channel>
</rss>';
		return $items;
	}

}

?>
