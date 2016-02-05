<?php
	// mysql parms
	$dbhost = 'localhost';
	$db = 'bookwarrior';
	$dbtable = 'updated';
	$dbtable_edited = 'updated_edited';
        $descrtable = 'description';
        $descrtable_edited = 'description_edited';
        $topictable = 'topics';

	$dbuser = '';
	$dbpass = '';

	$dbuser_get = '';
	$dbpass_get = '';


	// problem resolution URL to mention in error messages
	$errurl = '';

	//$repository = 'repository';
	$maxlines = 25;

	//для RSS
	$maxnewslines = 30;
	$pagesperpage = 25;
	$servername = 'libgen.io';
	//$servername = trim(str_replace('http://', '', $_SERVER["HTTP_REFERER"]), '/');
    
        // separator symbol
        $filesep = '/';

//'785000-824000'   => 'K:\\!genesis\\!repository4',
	
        // distributed repository
 	 $repository = array(
		       '0-390000' => 'K:\\!genesis\\!repository1',
		  '391000-698000' => 'K:\\!genesis\\!repository2',
		  '699000-786000' => 'K:\\!genesis\\!repository3',
		  '787000-888000' => 'K:\\!genesis\\!repository5',
		 '889000-1096000' => 'K:\\!genesis\\!repository6',
		'1097000-1387000' => 'K:\\!genesis\\!repository7',
		'1388000-1999000' => 'K:\\!genesis\\!repository8'

);
	$covers_repository = '/covers/';
?>