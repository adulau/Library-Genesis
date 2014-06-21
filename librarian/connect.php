<?php
	include 'config.php';
	include 'html.php';

	@$con = mysql_connect($dbhost,$dbuser,$dbpass);
	if (!$con)
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font>Could not connect to the database: ".mysql_error()."<br>Cannot proceed.<p>Please, report on the error from <a href=>the main page</a>.".$htmlfoot);

	mysql_query("SET session character_set_server = 'UTF8'");
	mysql_query("SET session character_set_connection = 'UTF8'");
	mysql_query("SET session character_set_client = 'UTF8'");
	mysql_query("SET session character_set_results = 'UTF8'");

	mysql_select_db($db,$con);
?>
