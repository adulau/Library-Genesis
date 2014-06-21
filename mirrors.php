<?php
	//mirrors
	$mirror_0_link = '../get?md5='.$row['MD5'] . $openreq;
	$mirror_0_title = 'local';
	$mirror_0_tooltip = 'local';

	$mirror_1_link = 'http://libgen.org/get?md5='.$row['MD5'] . $openreq;
	$mirror_1_title = 'Libgen.org';
	$mirror_1_tooltip = 'Libgen.org';


	$mirror_2_link = 'http://bookzz.org/md5/' . $row['MD5'];
	$mirror_2_title = 'Bookzz.org (Bookos.org, bookza.org)';
	$mirror_2_tooltip = 'Bookzz.org (Bookos.org, bookza.org)';


	$mirror_3_link = 'http://bookfi.org/md5/' . $row['MD5'];
	$mirror_3_title = 'Bookfi.org';
	$mirror_3_tooltip = 'Bookfi.org';


	$mirror_4_link = 'http://libgen.net/view.php?id=' . $row['ID'];
	$mirror_4_title = 'Libgen.net';
	$mirror_4_tooltip = 'Libgen.net';


	$mirror_5_link = '';
	$mirror_5_title = '';
	$mirror_5_tooltip = '';


	$mirror_6_link = '';
	$mirror_6_title = '';
	$mirror_6_tooltip = '';


	$mirror_7_link = 'http://gen.lib.rus.ec/get?md5='.$row['MD5'];
	$mirror_7_title = 'Gen.lib.rus.ec';
	$mirror_7_tooltip = 'Gen.lib.rus.ec';


	$mirror_8_link = '';
	$mirror_8_title = '';
	$mirror_8_tooltip = '';


	$mirror_9_link = '';
	$mirror_9_title = '';
	$mirror_9_tooltip = '';

	$mirror_edit_link = 'http://libgen.org/librarian/registration?md5='.$row['MD5'];
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
		$mirror_e2k_link = 'ed2k://|file|' . $row['MD5'] . '.' . $row['Extension'] . '|' . $row['Filesize'] . '|' . $row['eDonkey'] . '|h=' . $row['AICH'] . '|/';
		$mirror_e2k_title = 'Ed2k';
		$mirror_e2k_tooltip = 'Ed2k';
	}

	if($row['TTH'] == '')
	{
		$mirror_magnet_link = '#';
		$mirror_magnet_title = '<font color="grey">Magnet</font>';
		$mirror_magnet_tooltip = 'Magnet';
	}
	else
	{
		$mirror_magnet_link = 'magnet:?xt=urn:tree:tiger:' . $row['TTH'] . '&xl=' . $row['Filesize'] . '&dn=' . $row['MD5'] . '.' . $row['Extension'];
		$mirror_magnet_title = 'Magnet';
		$mirror_magnet_tooltip = 'Magnet';
	}


if(!file_exists('../repository_torrent/r_' . substr($row['ID'], 0, -3) . '000.torrent'))
{
	$mirror_torrent_link = '#';
	$mirror_torrent_title = '<font color="grey">Torrent</font>';
	$mirror_torrent_tooltip = '';
}
else
{
	$mirror_torrent_link = 'http://libgen.org/repository_torrent/r_' . substr($row['ID'], 0, -3) . '000.torrent';
	$mirror_torrent_title = 'Torrent';
	$mirror_torrent_tooltip = 'torrent per 1000 books ';
}
?>