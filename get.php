<?php
	include 'config.php';
	include 'connect.php';
	include 'html.php';
	include 'resume.php';
    include 'util.php';

	$sql="SELECT * FROM $dbtable t WHERE MD5='$_GET[md5]' AND Filename!='' AND Generic=''";
	$result = mysql_query($sql,$con);
	if (!$result)
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font>".mysql_error()."<br>Cannot proceed.<p>Please, report on the error from <a href=>the main page</a>.".$htmlfoot);

	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	mysql_close($con);
    $title = stripslashes($row['Title']);
    $author = stripslashes($row['Author']);
    $vol = stripslashes($row['VolumeInfo']);
    $publisher = stripslashes($row['Publisher']);
    $year = $row['Year'];
    $pages = $row['Pages'];
    $lang = stripslashes($row['Language']);
    $ident = stripslashes($row['Identifier']);
    $edition = stripslashes($row['Edition']);
    $ext = stripslashes($row['Extension']);
    $library = stripslashes($row['Library']);
    $filename = stripslashes($row['Filename']); // e.g. 9000/<md5>
    
    $repdir = getRepDirByFilename($filename); // eg 9000
    
    // the name, under which the user is going to download the book
    $downloadname = '';
    if (!empty($author)) { $downloadname = $author; }
    if (!empty($title)) { $downloadname = $downloadname.'-'.$title; }
    if (!empty($publisher)) { $downloadname = $downloadname.'-'.$publisher; }
    if (!empty($year)) { $downloadname = $downloadname.'('.$year.')'; }

    if (empty($downloadname)) {$downloadname = 'unknown';}
    
	$fullfilename = $repdir.$filesep.$filename; // eg c:/library/9000/<md5>
    
	if (!file_exists($fullfilename))
		die($htmlhead."<font color='#A00000'><h1>File not found!</h1></font>Please, report to the administrator.".$htmlfoot);    
    
    $nametype = $_GET['nametype'];
    if (($nametype == '') || ($nametype == 'md5')) {
        $downloadname = basename($fullfilename);
    } elseif ($nametype == 'orig') {
        // nop 
    } elseif ($nametype == 'translit') {
        // stub
        $downloadname = basename($fullfilename);
    } else {// something is wrong
        die($htmlhead."<font color='#A00000'><h1>Error</h1></font><br>Cannot proceed: incorrect download nametype selected.<p>Please, go back and press a radiobutton.".$htmlfoot);
    }    
    
    // remove illegal chars
    $downloadname = removeIllegal($downloadname);
    
    // not more than 200 characters in the string
    $downloadname = substr($downloadname,0,200); 
    
    //die($htmlhead.'<font color="#A00000"><h1>Download name:</h1></font>"'.basename($downloadname.'.'.$ext).'"'.$htmlfoot);

	new getresumable($fullfilename,$ext,$downloadname);
    
    function removeIllegal($str){
    	static $tbl= array(
		'<' => '_', '>' => '_', ':' => '_', '"' => '_',
        '/' => '_', '\\' => '_', '|' => '_', '?' => '_', 
        '*' => '_', ' ' => '_', ';' => '_' 
	    );
    
        return strtr($str, $tbl);    
    }
?>