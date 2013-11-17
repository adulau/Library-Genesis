<?php
	include 'config.php';
	include 'connect.php';
	include 'html.php';
	include 'resume.php';

//usleep(500000);
    include 'util.php';

    if (isset($_GET['md5']) ) $nametype = $_GET['md5'];

	$sql="SELECT * FROM $dbtable WHERE MD5='".mysql_real_escape_string($_GET['md5'])."' AND Filename!=''";
	$result = mysql_query($sql,$con);
	if (!$result)
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font>".mysql_error()."<br>Cannot proceed.<p>Please, report on the error from <a href=>the main page</a>.".$htmlfoot);

	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	mysql_close($con);
    $title = stripslashes($row['Title']);
    $author = stripslashes($row['Author']);
    $periodical = stripslashes($row['Periodical']);
    $series = stripslashes($row['Series']);
    $vol = stripslashes($row['VolumeInfo']);
    $publisher = stripslashes($row['Publisher']);
    $year = $row['Year'];
    $pages = $row['Pages'];
    $lang = stripslashes($row['Language']);
    $ident = stripslashes($row['Identifier']);
    $volume = stripslashes($row['VolumeInfo']);
    $edition = stripslashes($row['Edition']);
    $ext = stripslashes($row['Extension']);
    $library = stripslashes($row['Library']);
    $filename = stripslashes($row['Filename']); // e.g. 9000/<md5>
    
    $repdir = getRepDirByFilename($filename); // eg 9000
    
    // the name, under which the user is going to download the book
    $downloadname = '';
    if (!empty($author)) { $downloadname = $author; }
    if (!empty($title)) { $downloadname = $downloadname.'-'.$title; }
    if (!empty($series)) { $downloadname = '('.$series.')'.$downloadname; }
    if (!empty($periodical)) { $downloadname = '('.$periodical.')'.$downloadname; }
    if (!empty($volume)) { $downloadname = $downloadname.'. '.$volume; }
    if (!empty($publisher)) { $downloadname = $downloadname.'-'.$publisher; }
    if (!empty($year)) { $downloadname = $downloadname.'('.$year.')'; }

    if (empty($downloadname)) {$downloadname = 'unknown';}
    
	$fullfilename = $repdir.$filesep.$filename; // eg c:/library/9000/<md5>
    
	if (!file_exists($fullfilename))
		die($htmlhead."<font color='#A00000'><h1>File not found!</h1></font><a href='http://gen.lib.rus.ec/forum/viewtopic.php?f=1&t=6423'>Please, report to the administrator.<a>".$htmlfoot);    
    
    if (isset($_GET['nametype']) ) $nametype = $_GET['nametype'];


    else $nametype = 'md5'; //тип явно не указан, вероятнее всего ожидается md5
    
    if (($nametype == '') || ($nametype == 'md5')) {
        $downloadname = basename($fullfilename);
    } elseif ($nametype == 'orig') {
        // nop 
    } elseif ($nametype == 'translit') {
        // stub
       // $downloadname = basename($fullfilename);
    } else {// something is wrong
        die($htmlhead."<font color='#A00000'><h1>Error</h1></font><br>Cannot proceed: incorrect download nametype selected.<p>Please, go back and press a radiobutton.".$htmlfoot);
    }    
    
    // remove illegal chars

if ($nametype == 'orig'){
    $downloadname = removeIllegal($downloadname);
    } else {
    $downloadname = removeIllegal1($downloadname);
}

    // not more than 200 characters in the string

     // $downloadname = substr($downloadname,0,200);
      $downloadname = mb_substr($downloadname, 0, 200, 'utf-8');

 
    
    //die($htmlhead.'<font color="#A00000"><h1>Download name:</h1></font>"'.basename($downloadname.'.'.$ext).'"'.$htmlfoot);
echo $fullfilename;
	new getresumable($fullfilename,$ext,$downloadname);
    


function removeIllegal($str){
     static $tbl= array(
'<' => '_', 
'>' => '_', 
':' => '_', 
'"' => '_', 
'/' => '_', 
'\\' => '_', 
'|' => '_', 
'?' => '_', 
'*' => '_', 
' ' => '_', 
';' => '_');
        return strtr($str, $tbl);    
}


function removeIllegal1($str){
     static $tbl= array(
'<' => '_', 
'>' => '_', 
':' => '_', 
'"' => '_', 
'/' => '_', 
'\\' => '_', 
'|' => '_', 
'?' => '_', 
'*' => '_', 
'Щ' => 'SHCH', 
'щ' => 'shch', 
'Ё' => 'YO', 
'ё' => 'yo', 
'Ж' => 'ZH', 
'ж' => 'zh', 
'Й' => 'J#', 
'й' => 'j#', 
'Ч' => 'CH', 
'ч' => 'ch', 
'Ш' => 'SH', 
'ш' => 'sh', 
'Э' => 'E#', 
'э' => 'e#', 
'Ю' => 'JU', 
'ю' => 'ju', 
'Я' => 'JA', 
'я' => 'ja', 
'А' => 'A', 
'Б' => 'B', 
'В' => 'V', 
'Г' => 'G', 
'Д' => 'D', 
'Е' => 'E', 
'З' => 'Z', 
'И' => 'I', 
'К' => 'K', 
'Л' => 'L', 
'М' => 'M', 
'Н' => 'N', 
'О' => 'O', 
'П' => 'P', 
'Р' => 'R', 
'С' => 'S', 
'Т' => 'T', 
'У' => 'U', 
'Ф' => 'F', 
'Х' => 'H', 
'Ц' => 'C', 
'У' => 'Y', 
'а' => 'a', 
'б' => 'b', 
'в' => 'v', 
'г' => 'g', 
'д' => 'd', 
'е' => 'e', 
'з' => 'z', 
'и' => 'i', 
'к' => 'k', 
'л' => 'l', 
'м' => 'm', 
'н' => 'n', 
'о' => 'o', 
'п' => 'p', 
'р' => 'r', 
'с' => 's', 
'т' => 't', 
'у' => 'u', 
'ф' => 'f', 
'х' => 'h', 
'ц' => 'c', 
'ъ' => '~', 
'ь' => '`', 
'Ъ' => '~', 
'Ы' => 'Y', 
'ы' => 'y', 
'Ь' => '#');
        return strtr($str, $tbl);    
}



?>