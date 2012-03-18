<?php

	include 'config.php';
	header("Content-Type: text/xml; charset=utf-8");
	$rss = new RSS();
	echo $rss->GetFeed();



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

		mysql_select_db('bookwarrior.updated', $con);
		DEFINE ('LINK', $con);
	}

	private function getItems()
	{
		include 'util.php';
		include 'html.php';

		global $dbtable,$maxlines,$pagesperpage,$descrtable;

		if (strlen($_GET['md5']) != 32)
			die($htmlhead."<font color='#A00000'><h1>Wrong MD5</h1></font>MD5-hashsum must contain 32 symbols.<br/>Check it and <a href='registration.php'>try again</a>.<p/><h2>Thank you!</h2>".$htmlfoot);

		$md5 = $_GET['md5'];

		// now look up in the database
		$sql = "SELECT * FROM $dbtable WHERE MD5='$md5'";
		$result = mysql_query($sql,LINK);
		if (!$result){
			die($htmlhead."<font color='#A00000'><h1>Error</h1></font>".mysql_error()."<br>Cannot proceed.<p>Please, report the error from <a href=>the main page</a>.".$htmlfoot);
		}

		$row = mysql_fetch_assoc($result);

		$sql1 = "SELECT * FROM $descrtable WHERE MD5='$md5'";
		$result1 = mysql_query($sql1,LINK);

		$row1 = mysql_fetch_assoc($result1);


		// items
		$items = '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="rss.xsl"?>

<library>
';
        if ($row['ID'] > 215000){
                $path = "genesis2";
        }else{$path = "genesis1";
          }

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

                        $id1 = trim($row['ID']);
                        if ($id1 >= 100000){
				$id1 = substr($id1, 0, 3);
                        } else
                        if ($id1 >= 10000){
				$id1 = substr($id1, 0, 2);
                        } else
                        if ($id1 >= 1000){
				$id1 = substr($id1, 0, 1);
                        } else
                        if ($id1 < 1000)
				$id1 = 0;
$ident1 = htmlspecialchars(trim($row['Identifier']));
$patterns = "ISBN";
$replacements = " ISBN";

$ident = ereg_replace($patterns, $replacements, $ident1);
                        
			$items .= '	<book>
		<title>'.htmlspecialchars(trim($row['Title'])).'</title>
		<authors>'.htmlspecialchars(trim($row['Author'])).'</authors>
		<volume>'.htmlspecialchars(trim($row['VolumeInfo'])).'</volume>
		<edition>'.htmlspecialchars(trim($row['Edition'])).'</edition>
		<year>'.htmlspecialchars(trim($row['Year'])).'</year>
		<language>'.htmlspecialchars(trim($row['Language'])).'</language>
		<pages>'.htmlspecialchars(trim($row['Pages'])).'</pages>
		<publisher>'.htmlspecialchars(trim($row['Publisher'])).'</publisher>
		<isbn>'.$ident.'</isbn>
                <asin>'.htmlspecialchars(trim($row['ASIN'])).'</asin>
		<size>'.$size.'</size>
		<type>'.htmlspecialchars(trim($row['Extension'])).'</type>
		<topic>'.htmlspecialchars(trim($row['Topic'])).'</topic>
		<periodical>'.htmlspecialchars(trim($row['Periodical'])).'</periodical>
		<series>'.htmlspecialchars(trim($row['Series'])).'</series>
		<id>'.$row['ID'].'</id>
		<edonkey>'.htmlspecialchars(trim('ed2k://|file|'.$row['MD5'].'.'.$row['Extension'].'|'.$row['Filesize'].'|'.$row['eDonkey'].'|/')).'</edonkey>
		<date>'.htmlspecialchars(trim($row['TimeAdded'])).'</date>		
                                     <date2>'.htmlspecialchars(trim($row['TimeLastModified'])).'</date2>
                                      <issue>'.htmlspecialchars(trim($row['Issue'])).'</issue>
                                      <descr>'.htmlspecialchars(strip_tags(trim($row1['descr']))).'</descr>
		<commentary>'.htmlspecialchars(strip_tags(trim($row['Commentary']))).'</commentary>
		<library>'.htmlspecialchars(trim($row['Library'])).'</library>
		<issue>'.htmlspecialchars(trim($row['Issue'])).'</issue>
		<url>'.htmlspecialchars(trim('../get?nametype=orig&md5='.$row['MD5'])).'</url>
		<url1>'.htmlspecialchars(trim('Ed2K')).'</url1>
		<url2>'.htmlspecialchars(trim('http://bookfi.org/md5/'.$row['MD5'])).'</url2>
		<url2-1>'.htmlspecialchars(trim('Bookfi.org')).'</url2-1>
		<url3>'.htmlspecialchars(trim('http://gen.lib.rus.ec/get?nametype=orig&md5='.$row['MD5'])).'</url3>
		<url3-1>'.htmlspecialchars(trim('Gen.lib.rus.ec')).'</url3-1>
		<url4>'.htmlspecialchars(trim('magnet:?xt=urn:tree:tiger:'.$row['TTH'].'&xl='.$row['Filesize'].'&dn='.$row['MD5'].'.'.$row['Extension'])).'</url4>
		<url4-1>'.htmlspecialchars(trim('Magnet')).'</url4-1>
		<torrent>'.htmlspecialchars(trim('http://free-books.us.to/repository_torrent/r_'.$id1.'000.torrent')).'</torrent>
		<torrent1>'.htmlspecialchars(trim('Torrent')).'</torrent1>
		<edit>'.htmlspecialchars(trim('http://free-books.us.to/librarian/registration?md5='.$row['MD5'])).'</edit>
		<edit1>'.htmlspecialchars(trim('Librarian free-books')).'</edit1>
		<coverurl>'.$coverurl.'</coverurl>


	</book>
';
		$items .= '</library>';
		return $items;
	}

}
"<script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18056347-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";

?>
