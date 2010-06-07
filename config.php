<?php
	// mysql parms
	$dbhost = 'localhost';
	$db = 'bookwarrior';
	$dbtable = 'updated';
	$dbuser = 'root';
	$dbpass = '';

	// problem resolution URL to mention in error messages
	$errurl = 'http://gen.lib.rus.ec/forum/viewforum.php?f=6';

	//$repository = 'repository';
	$maxlines = 100;

	// separator symbol
	$filesep = '/';

	// distributed repository
	$repository = array(
		'0-110000' => 'repository' ,
		'111000-500000' => 'gen/repository' ,
		'' => 'repository');
?>
