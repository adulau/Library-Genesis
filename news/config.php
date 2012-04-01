<?php
	// mysql params
	$dbhost = 'localhost';
	$db = 'bookwarrior';
	$dbtable = 'updated';
	$dbuser = 'root';
	$dbpass = '';

	$maxlines = 10;
	$pagesperpage = 25;

	//$servername = 'gen.lib.rus.ec';
	$servername = 'free-books.us.to';

	// separator symbol
	$filesep = '/';

	$repository = array(
		'0-5000000' => 'repository' ,
		'' => 'repository');

	$covers = array(
		'0-5000000' => 'http://free-books.us.to/genesis/covers');

	DEFINE ('DB_USER', $dbuser);
	DEFINE ('DB_PASSWORD', $dbpass);
	DEFINE ('DB_HOST', $dbhost);
	DEFINE ('DB_NAME', $db);
	DEFINE ('SERVERNAME', $servername);
?>
