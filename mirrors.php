<?php

	//mirrors
	$mirror_0_link = '/get.php?md5='.strtoupper($row['MD5']) . $openreq;
	$mirror_0_title = 'local';
	$mirror_0_tooltip = 'local';

	$mirror_1_link = '/get.php?md5='.strtoupper($row['MD5']) . $openreq;
	$mirror_1_title = 'Libgen';
	$mirror_1_tooltip = 'Libgen';

	$mirror_2_link = 'http://golibgen.io/view.php?id=' . $row['ID'];
	$mirror_2_title = 'Libgen.net';
	$mirror_2_tooltip = 'Libgen.net';


	$mirror_3_link = 'http://bookfi.net/md5/' . strtoupper($row['MD5']);
	$mirror_3_title = 'Bookfi.org';
	$mirror_3_tooltip = 'Bookfi.org';


	$mirror_4_link = 'http://bookzz.org/md5/' . strtoupper($row['MD5']);
	$mirror_4_title = 'Bookzz.org (Bookos.org, bookza.org)';
	$mirror_4_tooltip = 'Bookzz.org (Bookos.org, bookza.org)';

	$mirror_5_link = '';
	$mirror_5_title = '';
	$mirror_5_tooltip = '';


	$mirror_6_link = '';
	$mirror_6_title = '';
	$mirror_6_tooltip = '';


	$mirror_7_link = 'http://gen.lib.rus.ec/get?md5='.strtoupper($row['MD5']);
	$mirror_7_title = 'Gen.lib.rus.ec';
	$mirror_7_tooltip = 'Gen.lib.rus.ec';


	$mirror_8_link = '';
	$mirror_8_title = '';
	$mirror_8_tooltip = '';


	$mirror_9_link = '';
	$mirror_9_title = '';
	$mirror_9_tooltip = '';

	$mirror_edit_link = '/librarian/registration.php?md5='.strtoupper($row['MD5']);
	$mirror_edit_title = 'Libgen Librarian';
	$mirror_edit_tooltip = 'Libgen Librarian';

	if($row['eDonkey'] == '')
	{
		$mirror_e2k_link = '#';
		$mirror_e2k_title = '<font color="grey">Ed2k</font>';
		$mirror_e2k_tooltip = 'Ed2k';
	}
	else
	{
		$mirror_e2k_link = 'ed2k://|file|' . strtoupper($row['MD5']) . '.' . $row['Extension'] . '|' . $row['Filesize'] . '|' . $row['eDonkey'] . '|h=' . $row['AICH'] . '|/';
		$mirror_e2k_title = 'Ed2k';
		$mirror_e2k_tooltip = 'Ed2k';
	}

	if($row['TTH'] == '')
	{
		$mirror_dc_link = '#';
		$mirror_dc_title = '<font color="grey">DC++</font>';
		$mirror_dc_tooltip = 'DC++';
	}
	else
	{
		$mirror_dc_link = 'magnet:?xt=urn:tree:tiger:' . $row['TTH'] . '&xl=' . $row['Filesize'] . '&dn=' . $row['MD5'] . '.' . $row['Extension'];
		$mirror_dc_title = 'DC++';
		$mirror_dc_tooltip = 'DC++';
	}

	if($row['torrent'] == '')
	{
		$mirror_oftorrent_link = '#';
		$mirror_oftorrent_title = '<font color="grey">'.$LANG_MESS_416.'</font>';
		$mirror_oftorrent_tooltip = str_replace('<br>', '', $LANG_MESS_416);
	}
	else
	{
		$mirror_oftorrent_link = '/book/index.php?md5='.$row['MD5'].'&oftorrent=';
		$mirror_oftorrent_title = $LANG_MESS_416;
		$mirror_oftorrent_tooltip = str_replace('<br>', '', $LANG_MESS_416);
	}
	

	if($row['SHA1'] == '')
	{
		$mirror_gnu_link = '#';
		$mirror_gnu_title = '<font color="grey">Gnutella</font>';
		$mirror_gnu_tooltip = 'Magnet';
	}
	else
	{
		$mirror_gnu_link = 'magnet:?xt=urn:sha1:' .  $row['SHA1'] . '&xl=' . $row['Filesize'] . '&dn=' . $row['MD5'] . '.' . $row['Extension'];
		$mirror_gnu_title = 'Gnutella';
		$mirror_gnu_tooltip = 'Gnutella';
	}
?>