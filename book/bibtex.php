<?php
include 'config.php';
include 'html.php';
echo $htmlheadbegin;

$md5 = $_GET['md5'];
$con = mysql_connect($dbhost, $dbuser, $dbpass);
		mysql_query("SET session character_set_server = 'UTF8'");
		mysql_query("SET session character_set_connection = 'UTF8'");
		mysql_query("SET session character_set_client = 'UTF8'");
		mysql_query("SET session character_set_results = 'UTF8'");

//$md5  = '8b6071fec36f937aa2d042072f0500b4';


$sqlbibtex = "SELECT * FROM bookwarrior.updated WHERE MD5='$md5'";
$resultbibtex = mysql_query($sqlbibtex,$con);
$rowbibtex = mysql_fetch_assoc($resultbibtex);


$title = $rowbibtex['Title'];
$author = $rowbibtex['Author'];
$publisher = $rowbibtex['Publisher'];
$identifier = $rowbibtex['Identifier'];
$year = $rowbibtex['Year'];
$pages = $rowbibtex['Pages'];
$series = $rowbibtex['Series'];
$volume = $rowbibtex['VolumeInfo'];
$id = $rowbibtex['ID'];
$md5 = $rowbibtex['MD5'];
$edition = $rowbibtex['Edition'];

$data = "<textarea rows='11' name='bibtext' id='bibtext' readonly cols='150'>
@book{book:{$id},
   title =     { $title},
   author =    { $author},
   publisher = { $publisher},
   isbn =      { $identifier},
   year =      { $year},
   series =    { $series},
   edition =   { $edition},
   volume =    { $volume},
   url =       {http://gen.lib.rus.ec/book/index.php?md5=$md5}
}</textarea>";

$data = str_replace('{ ', '{', $data);
echo $data;

echo $htmlfoot
?>