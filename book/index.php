<?php




        include 'config.php';
	header("Content-Type: text/xml; charset=utf-8");
	$rss = new RSS();
	echo $rss->GetItems();





class RSS
{
	public function getItems()
	{

    // Установка куки для запоминания выбора языка
    if(isset($_COOKIE['lang'])) { 
       $lang = $_COOKIE['lang'];
       $lang_file = 'lang_'.$lang.'.php';
       if(!file_exists($lang_file)) { $lang_file = 'lang_en.php'; }
    } else {
         $lang = 'en';
         $lang_file = 'lang_en.php';
       }
     // -- Конец установки куки

		include 'util.php';
		include 'html.php';
                include_once '../lang_'.$lang.'.php';

 		@$con = mysql_connect($dbhost, $dbuser, $dbpass);
		if (!$con) die("Could not connect to the database: ".mysql_error());
		mysql_query("SET session character_set_server = 'UTF8'");
		mysql_query("SET session character_set_connection = 'UTF8'");
		mysql_query("SET session character_set_client = 'UTF8'");
		mysql_query("SET session character_set_results = 'UTF8'");
		mysql_select_db('bookwarrior', $con);
		DEFINE ('LINK', $con);

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


//выводим повторы
$sql2 = "SELECT `MD5` FROM $dbtable WHERE MATCH(`generic`) AGAINST ('$md5' IN BOOLEAN MODE)";
$result2 = mysql_query($sql2,LINK);
if(mysql_num_rows($result2) == 0){$generic = '';
}else{
while ($row2 = mysql_fetch_assoc($result2)){
$generic1[]=$row2['MD5'];
$generic = "<md5>".implode("</md5>\t<md5>", $generic1)."</md5>\n";
}
}




// выводим старые описания
$sql_old_descr = "SELECT  `TimeLastModified` FROM $dbtable_edited WHERE MATCH(`MD5`) AGAINST ('$md5' IN BOOLEAN MODE) order by ID";
//echo $sql_old_descr;
$result_old_descr = mysql_query($sql_old_descr,LINK);

if(mysql_num_rows($result_old_descr) == 0){$md5_old_descr = '';}else{



while ($row_old_descr = mysql_fetch_assoc($result_old_descr)){
$timelastmodold=$row_old_descr['TimeLastModified'];

$md5_tlm[] = "<md5old>".$md5."</md5old><timelastmoifiedold>".$timelastmodold."</timelastmoifiedold>";


}
//print_r($md5_tlm);
$md5_old_descr = "<md5olddescr>".implode("</md5olddescr>\t<md5olddescr>", $md5_tlm)."</md5olddescr>\n";

//echo $md5_old_descr;


}







		// items
		$items = '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="rss.xsl"?><library>';



			$coverurl = stripslashes(trim($row['Coverurl']));

			if ($coverurl == '') $coverurl = 'blank.png';
			elseif (false === strpos($coverurl,'://')){
				$coverurl = str_replace('\\','/',getCoverNameByFilename($coverurl));
			}
			$coverurl = htmlspecialchars(trim($coverurl));
                        $sizebytes = trim($row['Filesize']);
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
$ident = htmlspecialchars(trim($row['Identifier']));
$ident = str_replace(",", ", ", $ident);

$searchable = htmlspecialchars(trim($row['Searchable']));
if ($searchable == '0'){$searchable='no';
} elseif ($searchable == '1'){$searchable='yes';
} else {$searchable=' ';}


$bookmarked = htmlspecialchars(trim($row['Bookmarked']));
if ($bookmarked == '0'){$bookmarked='no';
}elseif ($bookmarked  == '1'){$bookmarked='yes';
}else{$bookmarked=' ';}





$scanned = htmlspecialchars(trim($row['Scanned']));
if ($scanned == '0'){$scanned='no';
}elseif ($scanned == '1'){$scanned='yes';
}else{$scanned=' ';}


$paginated = htmlspecialchars(trim($row['Paginated']));
if ($paginated == '0'){$paginated='no';
}elseif ($paginated == '1'){$paginated='yes';
}else{$paginated=' ';}

                        
$cleaned = htmlspecialchars(trim($row['Cleaned']));
if ($cleaned == '0'){$cleaned='no';
}elseif ($cleaned == '1'){$cleaned='yes';
}else{$cleaned=' ';}			

$color = htmlspecialchars(trim($row['Color']));
if ($color == '0'){$color='no';
}elseif ($color == '1'){$color='yes';
}else{$color=' ';}

$orientation = htmlspecialchars(trim($row['Orientation']));
if ($orientation == '0'){$orientation='portrait';
}elseif ($orientation == '1'){$orientation='landscape';
}else{$orientation=' ';}

$descr = mysql_real_escape_string(htmlspecialchars(strip_tags(trim($row1['descr']))));
$descr = str_replace("\\r\\n", "\\n", $descr);
$descr = str_replace("\\n", "<br />", $descr);



$items .= '	<book>
                <md51>'.htmlspecialchars(trim($row['MD5'])).'</md51>
		<title>'.htmlspecialchars(trim($row['Title'])).'</title>
                <olddescr>'.$md5_old_descr.'</olddescr>
		<generic>'.$generic.'</generic>
		<bibtex>'.htmlspecialchars(trim('../book/bibtex.php?md5='.$row['MD5'])).'</bibtex>
		<link>'.htmlspecialchars(trim('Link')).'</link>
		<authors>'.htmlspecialchars(trim($row['Author'])).'</authors>
		<volume>'.htmlspecialchars(trim($row['VolumeInfo'])).'</volume>
		<edition>'.htmlspecialchars(trim($row['Edition'])).'</edition>
		<year>'.htmlspecialchars(trim($row['Year'])).'</year>
		<language>'.htmlspecialchars(trim($row['Language'])).'</language>
		<pages>'.htmlspecialchars(trim($row['Pages'])).'</pages>
		<publisher>'.htmlspecialchars(trim($row['Publisher'])).'</publisher>
		<isbn>'.$ident.'</isbn>
                <asin>'.htmlspecialchars(trim($row['ASIN'])).'</asin>
                <city>'.htmlspecialchars(trim($row['City'])).'</city>
		<size>'.$size.'</size>
		<type>'.htmlspecialchars(trim($row['Extension'])).'</type>
		<topic>'.htmlspecialchars(trim($row['Topic'])).'</topic>
		<periodical>'.htmlspecialchars(trim($row['Periodical'])).'</periodical>
		<series>'.htmlspecialchars(trim($row['Series'])).'</series>
		<id>'.$row['ID'].'</id>
		<edonkey>'.htmlspecialchars(trim('ed2k://|file|'.$row['MD5'].'.'.$row['Extension'].'|'.$row['Filesize'].'|'.$row['eDonkey'].'|h='.$row['AICH'].'|/')).'</edonkey>
		<date>'.htmlspecialchars(trim($row['TimeAdded'])).'</date>		
                                      <date2>'.htmlspecialchars(trim($row['TimeLastModified'])).'</date2>
                                      <issue>'.htmlspecialchars(trim($row['Issue'])).'</issue>
                                      <descr>'.$descr.'</descr>
                <commentary>'.htmlspecialchars(strip_tags(trim($row['Commentary']))).'</commentary>
		<library>'.htmlspecialchars(trim($row['Library'])).'</library>
		<issue>'.htmlspecialchars(trim($row['Issue'])).'</issue>
		<url>'.htmlspecialchars(trim('/get?nametype=orig&md5='.$row['MD5'])).'</url>
		<url1>'.htmlspecialchars(trim('Ed2K')).'</url1>
		<url2>'.htmlspecialchars(trim('http://bookfi.org/md5/'.$row['MD5'])).'</url2>
		<url2-1>'.htmlspecialchars(trim('Bookfi.org')).'</url2-1>
		<url3>'.htmlspecialchars(trim('http://gen.lib.rus.ec/get?nametype=orig&md5='.$row['MD5'])).'</url3>
		<url3-1>'.htmlspecialchars(trim('Gen.lib.rus.ec')).'</url3-1>
		<url4>'.htmlspecialchars(trim('magnet:?xt=urn:tree:tiger:'.$row['TTH'].'&xl='.$row['Filesize'].'&dn='.$row['MD5'].'.'.$row['Extension'])).'</url4>
		<url4-1>'.htmlspecialchars(trim('Magnet')).'</url4-1>

		<url6>'.htmlspecialchars(trim('http://libgen.info/view.php?id='.$row['ID'])).'</url6>
		<url6-1>'.htmlspecialchars(trim('Libgen.info')).'</url6-1>

		<url7>'.htmlspecialchars(trim('http://www.libgen.info/view.php?id='.$row['ID'])).'</url7>
		<url7-1>'.htmlspecialchars(trim('www.libgen.info')).'</url7-1>

		<url8>'.htmlspecialchars(trim('http://www.libgen.net/view.php?id='.$row['ID'])).'</url8>
		<url8-1>'.htmlspecialchars(trim('www.libgen.net')).'</url8-1>

		<url9>'.htmlspecialchars(trim('http://bookos.org/md5/'.$row['MD5'])).'</url9>
		<url9-1>'.htmlspecialchars(trim('bookos.org')).'</url9-1>


                <sizebytes>'.$sizebytes.'</sizebytes>


		<torrent>'.htmlspecialchars(trim('/repository_torrent/r_'.$id1.'000.torrent')).'</torrent>
		<torrent1>'.htmlspecialchars(trim('Torrent')).'</torrent1>
		<edit>'.htmlspecialchars(trim('/librarian/registration?md5='.$row['MD5'])).'</edit>
		<edit1>'.htmlspecialchars(trim('Librarian libgen.org')).'</edit1>
		<url5-1>'.htmlspecialchars(trim('Link')).'</url5-1>
		<coverurl>'.$coverurl.'</coverurl>

                <issn>'.htmlspecialchars(trim($row['ISSN'])).'</issn>                
                <udc>'.htmlspecialchars(trim($row['UDC'])).'</udc>
                <lbc>'.htmlspecialchars(trim($row['LBC'])).'</lbc>                
                <lcc>'.htmlspecialchars(trim($row['LCC'])).'</lcc>                
                <ddc>'.htmlspecialchars(trim($row['DDC'])).'</ddc>                
                <doi>'.htmlspecialchars(trim($row['Doi'])).'</doi>
                <ol>'.htmlspecialchars(trim($row['OpenLibraryID'])).'</ol>
                <googlebookid>'.htmlspecialchars(trim($row['Googlebookid'])).'</googlebookid>
                <dpi>'.htmlspecialchars(trim($row['DPI'])).'</dpi>
                <searchable>'.$searchable.'</searchable> 
                <bookmarked>'.$bookmarked.'</bookmarked>                               
                <scanned>'.$scanned.'</scanned> 
                <orientation>'.htmlspecialchars(trim($row['Orientation'])).'</orientation>                
                <paginated>'.$paginated.'</paginated>
                <color>'.htmlspecialchars(trim($row['Color'])).'</color>                
                <cleaned>'.$cleaned.'</cleaned>

                <titlelangselect>'.$LANG_MESS_5.'</titlelangselect>
                <authorlangselect>'.$LANG_MESS_6.'</authorlangselect>
                <serieslangselect>'.$LANG_MESS_7.'</serieslangselect>
                <periodicallangselect>'.$LANG_MESS_8.'</periodicallangselect>
                <volumelangselect>'.$LANG_MESS_42.'</volumelangselect>
                <editionlangselect>'.$LANG_MESS_43.'</editionlangselect>
                <yearlangselect>'.$LANG_MESS_10.'</yearlangselect>
                <pageslangselect>'.$LANG_MESS_28.'</pageslangselect>
                <languagelangselect>'.$LANG_MESS_11.'</languagelangselect>
                <publisherlangselect>'.$LANG_MESS_9.'</publisherlangselect>
                <topiclangselect>'.$LANG_MESS_13.'</topiclangselect>
                <timeaddlangselect>'.$LANG_MESS_44.'</timeaddlangselect>
                <timelmlangselect>'.$LANG_MESS_45.'</timelmlangselect>
                <librarylangselect>'.$LANG_MESS_46.'</librarylangselect>
                <libraryisslangselect>'.$LANG_MESS_47.'</libraryisslangselect>
                <sizelangselect>'.$LANG_MESS_26.'</sizelangselect>
                <extlangselect>'.$LANG_MESS_12.'</extlangselect>
                <worseverlangselect>'.$LANG_MESS_48.'</worseverlangselect>
                <descroldlangselect>'.$LANG_MESS_49.'</descroldlangselect>
                <commentlangselect>'.$LANG_MESS_50.'</commentlangselect>
                <identlangselect>'.$LANG_MESS_51.'</identlangselect>
                <bookattrlangselect>'.$LANG_MESS_52.'</bookattrlangselect>
                <mirrorslangselect>'.$LANG_MESS_53.'</mirrorslangselect>
                <editlangselect>'.$LANG_MESS_54.'</editlangselect>
                <citylangselect>'.$LANG_MESS_93.'</citylangselect>



               </book>';


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
