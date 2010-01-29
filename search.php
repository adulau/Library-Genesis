<?php
	include 'connect.php';
	include 'html.php';
	include 'strings.php';
	include 'util.php';

	if (sizeof($_GET)) $mainpage = false;
	else $mainpage = true;

	// SQL-requests should encode single-quotes and underscores with Esc-sequences
	if (!$mainpage){
		$req = addcslashes(mysql_real_escape_string($_GET['req']),"%_");
		if (strlen($req) < 1) die($htmlhead."<font color='#A00000'><h1>Wrong Request</h1></font>Search string must contain more than one character.<br>Please, type in a longer request and <a href=>try again</a>.".$htmlfoot);

		$req_htm = htmlspecialchars($_GET['req'],ENT_QUOTES);
		$req_htm_enc = urlencode($_GET['req']);
        $dlnametype = $_GET['Radioname'];
	} else {
		$req_htm = "";
        $dlnametype = "orig";
	}

	$textcol1 = 'gray';//'A0A000';
	$textcol2 = '#A00000';//'#E8E880';

	$index1 = "<a href='http://free-books.dontexist.com/content/'>Contents</a>";
	$torrents = "<a href='http://free-books.dontexist.com/repository_torrent/'>Torrents</a>";
	$source = "<a href='http://free-books.dontexist.com/code/'>Code</a>";
	$dbdump = "<a href='http://free-books.dontexist.com/dailyupdated/My Dropbox/Public/'>Dump (Daily)</a>";
	$donate = "";//"<a href='http://lib.rus.ec/donate'>Donate</a>";
        $export = "<a href='http://free-books.dontexist.com/export/'>Import your books to LibGen</a>";
	$forum = "<a href='http://gen.lib.rus.ec/forum/'>Forum</a>";
        $upload = "<a href='http://free-books.dontexist.com/librarian/'>Upload &amp; edit</a>";
	//$master = "bookwarrior";
	$footer = "</tr></table>\n";

	$toolbar = "
<table height=100% width=100% cellspacing=0 cellpadding=0>
<tr>
<td align=left><b><font face=Arial size=2 color={$textcol1}>{$index1} // {$torrents} // {$source} // {$dbdump} // {$export} // {$forum} // {$upload}</font></b></td>
<td align=right><b><font face=Arial size=2 color={$textcol1}>{$donate}</font></b></td>
</tr>
</table>";

    $dlnametypes = array('orig' => '',
                         'md5' => '',
                         'translit' => ''
    );
    
    foreach( $dlnametypes as $key => $value ) {
        if ( $key == $dlnametype ) {
            $dlnametypes[$key] = 'checked';
            break;
        }
    }
    
	$form = "<form action='search'>
	<input name=req id=1 size=60 maxlength=254 value='$req_htm'> <input type=submit value='Search!'>
	<br><font face=Arial color={$textcol1} size=1>$searchtip</font>
    <br><label>Download name as: </label>
    <input type=radio name='Radioname' value='orig' ".$dlnametypes['orig']."/>
    <label for='Original'>Original</label>
    <input type=radio name='Radioname' value='md5' ".$dlnametypes['md5']."/>
    <label for='Md5'>Md5</label>
    <input type=radio name='Radioname' value='translit' ".$dlnametypes['translit']."/>
    <label for='Translit'>Translit</label>
	</form>";

	echo $htmlheadfocus;

	// if no arguments passed, give out the main page
	if ($mainpage) {
		$searchbody = "<table cellspacing=0 width=100% height=100%>
		<th colspan=3 height=30 align=left>{$toolbar}</th>
		<tr><td height=27% width=35% valign=top align=left></td><td></td><td width=35% valign=top align=right></td></tr>
		<tr height=34%><td></td><td><center><table><tr><caption><font color={$textcol2}><h1>Library Genesis<sup><font size=4>110k</font></sup></h1></font></caption><td nowrap>{$form}</td></tr></table></center></td></tr>
		<tr><td width=25% valign=bottom align=left></td><td></td><td width=25% valign=bottom align=right></td>";

		//echo $toolbar;
		echo $searchbody;
		echo $footer;
		echo $htmlfoot;
		die;
	}

	// now look up in the database
	$dberr = $htmlhead."<font color='#A00000'><h1>Error</h1></font>".mysql_error()."<br>Cannot proceed.<p>Please, <a href='{$errurl}'><u>report</u></a> on this error.".$htmlfoot;

	if (isset($_GET['lines'])) $lines = $_GET['lines'];
	else $lines = $maxlines;

	// reset to deafult $maxlines, if wrong
	if ($lines > $maxlines || $lines <= 0) $lines = $maxlines;

	if (isset($_GET['lines'])) $from = $_GET['from'];
	else $from = 0;

	if ($from < $maxlines - $lines) $from = 0;

	$sql_end = " ORDER BY Title LIMIT $from, $lines";
	$search_words = explode(' ', $req);
        $search_fields = "CONCAT(Author, Title) LIKE '%"; 
        $search_core = $search_fields.implode("%' AND $search_fields", $search_words)."%'";
        $search_isbn = "Identifier LIKE '%$req%'";
        $sql_mid = "FROM $dbtable WHERE ((($search_core) OR $search_isbn) AND Filename!='' AND Generic='')";
	$sql_req = "SELECT * ".$sql_mid.$sql_end;
	$sql_cnt = "SELECT COUNT(*) ".$sql_mid;

	$result = mysql_query($sql_cnt,$con);
	if (!$result) die($dberr);

	$row = mysql_fetch_assoc($result);
	$totalrows = stripslashes($row['COUNT(*)']);
	mysql_free_result($result);

	$result = mysql_query($sql_req,$con);
	if (!$result) die($dberr);

	///////////////////////////////////////////////////////////////
	// pagination

	$args = "search?req=$req_htm_enc&lines=$lines";

	if ($totalrows > $from + $lines){
		$nextpage = $from + $lines;
		$argsnext = $args."&from=".$nextpage;
		$nextlink = "<a href='$argsnext'>".$str_next."</a>";
	} else {
		$nextpage = 0;
		$nextlink = $str_next;
	}

	if ($from > 0) {
		$prevpage = $from - $lines;
		if ($prevpage < 0) $prevpage = 0;
		$argsprev = $args."&from=".$prevpage;
		$prevlink = "<a href='$argsprev'>".$str_prev."</a>";
	} else {
		$prevlink = $str_prev;
	}

	$reshead = "<table width=100% cellspacing=0 cellpadding=0 border=0 class=c align=center>";

	include 'ads.php';
	echo $form;
	echo $reshead;

	$color1 = '#D0D0D0';
	$color2 = '#F6F6FF';
	$color3 = '#A0E000';

	echo "\n<b>".$totalrows." pieces found for <u>$req_htm</u> </b>\n";
	$navigator = "<tr><th valign=top bgcolor=$color3 colspan=6><font color=$color1><center><b>$prevlink | $nextlink</b></center></font></th></tr>";
	$tabheader = "<tr valign=top bgcolor=$color2><td><b>#</b></td><td></td><td><b>Name</b></td><td><b>Author</b></td><td><b>Size</b></td><td><b>Type</b></td></tr>";
	echo $navigator;
	echo $tabheader;

	//$repository = str_replace('\\','/',realpath($repository));

	$i = 1;
	while ($row = mysql_fetch_assoc($result)){
		$title = stripslashes($row['Title']);
		$author = stripslashes($row['Author']);
		$vol = stripslashes($row['VolumeInfo']);
		$publisher = stripslashes($row['Publisher']);
		$year = $row['Year'];
		$pages = $row['Pages'];
		$lang = stripslashes($row['Language']);
		$ident = stripslashes($row['Identifier']);
		$edition = stripslashes($row['Edition']);
		$ext = stripslashes($row['Extension']);
		$library = stripslashes($row['Library']);
        $filename = stripslashes($row['Filename']);

		$size = $row['Filesize'];
		if ($size >= 1024*1024*1024){
			$size = round($size/1024/1024/1024);
			$size = $size.' GB';
		} else
		if ($size >= 1024*1024){
			$size = round($size/1024/1024);
			$size = $size.' MB';
		} else
		if ($size >= 1024){
			$size = round($size/1024);
			$size = $size.' kB';
		} else
			$size = $size.' B';

		///////////
		// book info section (in parentheses)
		$volinf = $publisher;

		if ($volinf){
			if ($year) $volinf = $volinf.', '.$year;
		} else {
			if ($year) $volinf = $year;
		}

		if ($lang == 'Russian') $pp = ' '.$str_pp_ru;
		else $pp = ' '.$str_pp_en;
		if ($volinf){
			if ($pages) $volinf = $volinf.', '.$pages.$pp;
		} else {
			if ($pages) $volinf = $pages.$pp;
		}

		if ($volinf){
			if ($ident) $volinf = $volinf.', ISBN '.$ident;
		} else {
			if ($ident) $volinf = 'ISBN '.$ident;
		}

		///////////
		// output
		if ($i % 2) $color = ""; // $color1
		else $color = $color2;

		$vol_ed = $vol;
		if ($lang == 'Russian') $ed = ' '.$str_edition_ru;
		else $ed = ' '.$str_edition_en;
		if ($vol_ed){
			if ($edition) $vol_ed = $vol_ed.', '.$edition.$ed;
		} else {
			if ($edition) $vol_ed = $edition.$ed;
		}

		$volume = '';
		if ($vol_ed) $volume = " <font face=Times color=green><i>[$vol_ed]</i></font>";

		$volstamp = '';
		if ($volinf) $volstamp = " <font face=Times color=green><i>($volinf)</i></font>";

		$ires = $from + $i;

		//$tipdir = str_replace($row['MD5'],'',$filename,$count); //echo $count;
        list($tipdir,$file) = split($filesep,$filename);
		if ($library) $tiplib = 'Library: '.$library."\n";
		else $tiplib = '';

        $repdir = str_replace('\\','/',realpath(getRepDirByFilename($filename)));
		$tip = "ID: $row[ID]; $tiplib; Location: $repdir/$tipdir";
		$line = "<tr valign=top bgcolor=$color><td>$ires.</td>
		<td><a href='librarian/registration?md5=$row[MD5]'>[edit]</a></td>
		<td nowrap><a href='get?md5=$row[MD5]' title='$tip'>$title$volume$volstamp</a></td>
		<td nowrap>$author</td>
		<td nowrap>$size</td>
		<td nowrap>$ext</td>
		</tr>\n\n";

		echo $line;
		$i = $i + 1;
	}

	echo $navigator;
	echo $footer;
	echo $htmlfoot;

	mysql_free_result($result);
	mysql_close($con);
?>
