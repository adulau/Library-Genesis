<?php

         $freebooksip = str_replace("\r\n", "", str_replace(' ', '', file_get_contents('../scimag/ip')));
	// mysql params
	$dbhost = 'localhost';
	$db = 'bookwarrior';
	$dbtable = 'updated';
	$dbuser = 'root';
	$dbpass = '';

	$maxlines = 10;
	$pagesperpage = 25;

	//$servername = 'gen.lib.rus.ec';
	$servername = libgen.org;

	// separator symbol
	$filesep = '/';

	$repository = array(
		'0-5000000' => 'repository' ,
		'' => 'repository');

	$covers = array(
		'0-5000000' => 'ftp://'.$freebooksip.'/covers');

	DEFINE ('DB_USER', $dbuser);
	DEFINE ('DB_PASSWORD', $dbpass);
	DEFINE ('DB_HOST', $dbhost);
	DEFINE ('DB_NAME', $db);
	DEFINE ('SERVERNAME', $servername);
?>
