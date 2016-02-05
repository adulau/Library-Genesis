<?php
	include 'config.php';
	include 'html.php';
if(isset($_GET)) {
	@$con = mysql_connect($dbhost,$dbuser,$dbpass);
	if (!$con)
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font>Could not connect to the database: ".mysql_error()."<br>Cannot proceed.<p><a href='http://genofond.org/viewtopic.php?f=3&t=3925'>Please, report on the error</a>.".$htmlfoot);

}
	mysql_query("SET session character_set_server = 'UTF8'");
	mysql_query("SET session character_set_connection = 'UTF8'");
	mysql_query("SET session character_set_client = 'UTF8'");
	mysql_query("SET session character_set_results = 'UTF8'");

	mysql_select_db($db,$con);
?>