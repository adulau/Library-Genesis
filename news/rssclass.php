<?php

	include 'config.php';


class RSS
{
	public function RSS()
	{
		require_once ('mysql_connect.php');
	}

	public function GetFeed()
	{
		$this->dbConnect();
		return $this->getItems();
	}

	private function dbConnect()
	{
		@$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if (!$con) die("Could not connect to the database: ".mysql_error());

		mysql_query("SET session character_set_server = 'UTF8'");
		mysql_query("SET session character_set_connection = 'UTF8'");
		mysql_query("SET session character_set_client = 'UTF8'");
		mysql_query("SET session character_set_results = 'UTF8'");

		mysql_select_db($db,$con);
		DEFINE ('LINK', $con);
	}

	private function getItems()
	{
		include 'util.php';

		// pagination
		global $dbtable,$maxlines,$pagesperpage;

		$sql_cnt = "SELECT COUNT(*) FROM $dbtable WHERE Filename!='' AND Generic='' AND Visible='';";
		$result = mysql_db_query(DB_NAME,$sql_cnt,LINK);
		if (!$result) die($dberr);
		$row = mysql_fetch_assoc($result);
		$count = stripslashes($row['COUNT(*)']);
		mysql_free_result($result);

		$pagestotal = ceil($count/$maxlines);
		if ($pagestotal <= 1) $pagestotal = 1;

		$page = $_GET['page'];

		$query = "SELECT * FROM $dbtable WHERE Filename!='' AND Generic='' AND Visible='' ORDER BY ID DESC LIMIT ".($page-1)*$maxlines.",$maxlines;";
		$res = mysql_db_query (DB_NAME, $query, LINK);
		$numlines = sizeof($res);

		// items
		$items = '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="rss.xsl"?>

<library>
	<paginator>
		<pagestotal>'.$pagestotal.'</pagestotal>
		<pagesperpage>'.$pagesperpage.'</pagesperpage>
		<pagenumber>'.$page.'</pagenumber>
	</paginator>
';

		while($row = mysql_fetch_array($res))
		{       $freebooksip = str_replace("\r\n", "", str_replace(' ', '', file_get_contents('../scimag/ip')));
			$coverurl = stripslashes(trim($row['Coverurl']));

			if ($coverurl == '') $coverurl = 'blank.png';
			elseif (false === strpos($coverurl,'://')){
				$coverurl = str_replace('\\','/',getCoverNameByFilename($coverurl));
			}
			$coverurl = htmlspecialchars(trim($coverurl));

			$size = trim($row['Filesize']);
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

			$items .= '	<book>
		<title>'.htmlspecialchars(trim($row['Title'])).'</title>
		<authors>'.htmlspecialchars(trim($row['Author'])).'</authors>
		<volume>'.htmlspecialchars(trim($row['VolumeInfo'])).'</volume>
		<edition>'.htmlspecialchars(trim($row['Edition'])).'</edition>
		<year>'.htmlspecialchars(trim($row['Year'])).'</year>
		<language>'.htmlspecialchars(trim($row['Language'])).'</language>
		<pages>'.htmlspecialchars(trim($row['Pages'])).'</pages>
		<publisher>'.htmlspecialchars(trim($row['Publisher'])).'</publisher>
		<isbn>'.htmlspecialchars(trim($row['Identifier'])).'</isbn>
		<asin>'.htmlspecialchars(trim($row['ASIN'])).'</asin>
		<size>'.$size.'</size>
		<type>'.htmlspecialchars(trim($row['Extension'])).'</type>
		<topic>'.htmlspecialchars(trim($row['Topic'])).'</topic>
		<periodical>'.htmlspecialchars(trim($row['Periodical'])).'</periodical>
		<series>'.htmlspecialchars(trim($row['Series'])).'</series>
		<id>'.$row['ID'].'</id>
		<date>'.htmlspecialchars(trim($row['TimeAdded'])).'</date>
		<commentary>'.htmlspecialchars(strip_tags(trim($row['Commentary']))).'</commentary>
		<library>'.htmlspecialchars(trim($row['Library'])).'</library>
		<issue>'.htmlspecialchars(trim($row['Issue'])).'</issue>
		<url>'.htmlspecialchars(trim('http://'.$freebooksip.'/get?nametype=orig&md5='.$row['MD5'])).'</url>
		<coverurl>'.$coverurl.'</coverurl>
	</book>
';
		}
		$items .= '</library>';
		return $items;
	}

}

?>
