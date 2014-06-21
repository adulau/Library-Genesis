<?php
	// mysql parms
	$dbhost = 'localhost';
	$db = 'bookwarrior';
	$dbtable = 'updated';
	$dbtable_edited = 'updated_edited';
        $descrtable = 'description';
        $descrtable_edited = 'description_edited';
        $topictable = 'topics';

	$dbuser = 'libgen_read';
	$dbpass = '';

	$dbuser_get = 'libgen_get';
	$dbpass_get = '';


	// problem resolution URL to mention in error messages
	$errurl = '';

	//$repository = 'repository';
	$maxlines = 25;

	//для RSS
	$maxnewslines = 30;
	$pagesperpage = 25;
	$servername = 'libgen.org';
    
        // separator symbol
        $filesep = '/';
	
        // distributed repository
 	 $repository = array(
		'0-390000'        => 'G:\genesis1\repository1',
		'391000-555000'   => 'G:\genesis2\repository2',
		'556000-698000'   => 'G:\genesis3\repository3',
		'699000-824000'   => 'G:\genesis4\repository4',
		'825000-921000'   => 'G:\genesis5\repository5',
		'922000-1134000'  => 'G:\genesis6\repository6',
		'1135000-1999000' => 'G:\!genesis\!repository7');
	$covers_repository = 'http://libgen.org/covers/';
?>