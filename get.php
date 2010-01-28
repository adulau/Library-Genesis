<?php
	include 'conf.php';
	include 'confdb.php';
	include 'connect.php';
	include 'html.php';
	include 'resume.php';

	$sql="SELECT * FROM $dbtable t WHERE MD5='$_GET[md5]' AND Filename!='' AND Generic=''";
	$result = mysql_query($sql,$con);
	if (!$result)
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font>".mysql_error()."<br>Cannot proceed.<p>Please, report on the error from <a href=>the main page</a>.".$htmlfoot);

	$rows = mysql_fetch_assoc($result);
	mysql_free_result($result);
	mysql_close($con);
	list($dir,$file) = split($filesep,$rows['Filename']); //print "$dir $file<br>\n";
	foreach  ($repodirs as $key => $value) {
		list ($start,$end)=split('-',$key);
		if ($dir>=$start and $dir<=$end) {
			$repdir=$value; 
		}
	}
	$filename = $repdir.$filesep.$rows['Filename'];
//	echo "$filename";
	if (!file_exists($filename))
		die($htmlhead."<font color='#A00000'><h1>File not found!</h1></font>Please, report to the administrator.".$htmlfoot);

	new getresumable($filename,$rows['Extension']);
?>
