<?php

    // Установка куки для запоминания выбора языка
    if(isset($_COOKIE['lang'])) { 
       $lang = $_COOKIE['lang'];
       $lang_file = 'lang_'.$lang.'.php';
       if(!file_exists($lang_file)) { $lang_file = 'lang_en.php'; }
    } else {
         $lang = 'en';
         $lang_file = 'lang_en.php';
       }
     // -- Конец установки куки

	include 'connect.php';
	include 'html.php';
	//include 'strings.php';
	include 'util.php';
        include $lang_file;

	if (sizeof($_GET)) $mainpage = false;
	else $mainpage = true;

	// SQL-requests should encode single-quotes and underscores with Esc-sequences
	if (!$mainpage){

		$req_htm_enc = urlencode($_GET['req']);
        if( isset($_GET['nametype'])) $dlnametype = $_GET['nametype'];
        else $dlnametype = "md5"; // в строке явно НЕ указан тип - скорее всего ожидается md5, в соответствии со старой версией
	} else {
		$req_htm = "";
        $dlnametype = "orig";
	}

	$footer = "</tr></table>\n";


    $dlnametypes = array('orig' => '',
                         'translit' => '',
                         'md5' => ''
    );
    
    foreach( $dlnametypes as $key => $value ) {
        if ( $key == $dlnametype ) {
            $dlnametypes[$key] = 'checked';
        } else {
            $dlnametypes[$key] = '';
        }
    }
    
	$form = "<form name ='myform' action='search'><br>
	<input name=req id='searchform' size=60 maxlength=80 value='$req_htm'><input type=submit value='".$LANG_SEARCH_0."'><br>
    <label><b>".$LANG_MESS_1."</b></label>
    <input type=radio name='nametype' id='orig' value='orig' ".$dlnametypes['orig']." onclick=radioOnClick('orig') />
    <label for='Original'>".$LANG_MESS_2."</label>
    <input type=radio name='nametype' id='translit' value='translit' ".$dlnametypes['translit']." onclick=radioOnClick('translit') />
    <label for='translit'>".$LANG_MESS_3."</label>
    <input type=radio name='nametype' id='md5' value='md5' ".$dlnametypes['md5']." onclick=radioOnClick('md5') />
    <label for='md5'>MD5</label><br>
 <form action method='get'>
<font><b>".$LANG_MESS_4."</b></font><input type='checkbox' name='column[]' value='title' checked=true>".$LANG_MESS_5."<input type='checkbox' name='column[]' value='author' checked=true>".$LANG_MESS_6."<input type='checkbox' name='column[]' value='series' checked=true>".$LANG_MESS_7."<input type='checkbox' name='column[]' value='periodical' checked=true>".$LANG_MESS_8."<input type='checkbox' name='column[]' value='publisher' checked=true>".$LANG_MESS_9."<br><input type='checkbox' name='column[]' value='year' checked=true>".$LANG_MESS_10."
<input type='checkbox' name='column[]' value='Identifier'>ISBN<input type='checkbox' name='column[]' value='language'><a href='' title='Russian, English, German, French, Spanish, ... etc. (ISO 639)'>".$LANG_MESS_11."</a><input type='checkbox' name='column[]' value='md5'>MD5<input type='checkbox' name='column[]' value='extension'>".$LANG_MESS_12."<input type='checkbox' name='column[]' value='topic'>".$LANG_MESS_13."
</form>
    	</form>";



if(isset($_GET['column'])){
  $columns = $_GET['column'];

}


if (@is_array($column)) {
    $fieldslist = implode(', ', $column);
}else{
    $fieldslist = $column;
}

          echo $htmlheadfocus;
          include_once 'menu_'.$lang.'.html';



	// if no arguments passed, give out the main page
//	if ($mainpage) {
//		$searchbody = "<table cellspacing=0 width=100% height=100%>
//		<th colspan=3 height=30 align=left>{$toolbar}</th>
//		<tr><td height=27% width=35% valign=top align=left></td><td></td><td width=35% valign=top align=right></td></tr>
//		<tr height=34%><td></td><td><center><table><tr><caption><font color={$textcol2}><h1>Library Genesis<sup><font size=4>237k</font></sup></h1></font></caption><td nowrap>{$form}</td></tr></table></center></td></tr>
//		<tr><td width=25% valign=bottom align=left></td><td></td><td width=25% valign=bottom align=right></td>";
//
//		//echo $toolbar;
//		echo $searchbody;
//		echo $footer;
//		echo $htmlfoot;
//		die;
//	}

	// now look up in the database
	$dberr = $htmlhead."<font color='#A00000'><h1>Error</h1></font>".mysql_error()."<br>Cannot proceed.<p>Please, <a href='{$errurl}'><u>report</u></a> on this error.".$htmlfoot;

	if (isset($_GET['lines'])) $lines = $_GET['lines'];
	else $lines = $maxlines;

	// reset to deafult $maxlines, if wrong
	if ($lines > $maxlines || $lines <= 0) $lines = $maxlines;

	if (isset($_GET['lines'])) $from = $_GET['from'];
	else $from = 0;

	if ($from < $maxlines - $lines) $from = 0;

	$sql_end = "ORDER BY id desc LIMIT $from, 25";
	$search_words = explode(' ', $req);
	$search_fields = "CONCAT_WS(Author, Title, Series, Publisher, Periodical, Topic) LIKE '%";
        $sql_mid = "FROM $dbtable WHERE (Filename!='' AND Generic='' AND Visible='')";
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

	$args = "last?nametype=$dlnametype&req=$req_htm_enc&lines=$lines";
                            //search?nametype=orig&req=g&lines=100&from=100

	if ($totalrows > $from + $lines){
		$nextpage = $from + $lines;
		$argsnext = $args."&from=".$nextpage;
		$nextlink1 = "<a href='$argsnext' id='nextlink1'>".$str_next."</a>";
		$nextlink2 = "<a href='$argsnext' id='nextlink2'>".$str_next."</a>";
        $linesOnPage = $lines;
	} else {
		$nextpage = 0;
		$nextlink1 = $str_next;
		$nextlink2 = $str_next;
        $linesOnPage = $totalrows-$from;
	}

	if ($from > 0) {
		$prevpage = $from - $lines;
		if ($prevpage < 0) $prevpage = 0;
		$argsprev = $args."&from=".$prevpage;
		$prevlink1 = "<a href='$argsprev' id='prevlink1'>".$str_prev."</a>";
		$prevlink2 = "<a href='$argsprev' id='prevlink2'>".$str_prev."</a>";
	} else {
		$prevlink1 = $str_prev;
		$prevlink2 = $str_prev;
	}
    
    $onClickScript = "<script type='text/javascript'>
    function radioOnClick(txt) 
    {
        for (var i=$from+1;i<$from+$linesOnPage+1;i++) {
            changeQuery(document.getElementById(i),txt);
        }
        
        changeQuery(document.getElementById('prevlink1'),txt);
        changeQuery(document.getElementById('prevlink2'),txt);
        changeQuery(document.getElementById('nextlink1'),txt);
        changeQuery(document.getElementById('nextlink2'),txt);
    }
    
    function changeQuery(obj,txt) {
        if (!obj) return;
        var query = obj.href;
        var vars = query.split('&');
        var pair = vars[0].split('=');
        obj.href = pair[0] + '=' + txt;
        
        for(var i=1;i<vars.length;i++) {
            obj.href = obj.href + '&' + vars[i];
        }
    }
    
    function forceDlNameTypeSwitch() {
        var x=document.myform.nametype;
        if (!x) return;
        for(var i=0;i<x.length;i++) {
            if (x[i].value == '$dlnametype') {
                x[i].checked = 'true';
            } 
        }
    }
    
    // When 'Refresh' is clicked, Firefox refuses to change radiobutton
    // back to the one, which was chosen originally, which leads to
    // broken synchronization between radiobuttons and links on the page,
    // so wee need to force switch radiobuttons to the correct state.
    // Other browsers seem to react nicely to this, too.    
    forceDlNameTypeSwitch();
    </script>";
    
	$reshead = "<table width=100% cellspacing=1 cellpadding=1 rules=rows class=c align=center>";


echo "<table width=100%><tr><td>$form</td><td><a href='/'><font color=#A00000 valign=top align=right><h1>Library Genesis<sup><font size=4>800k</font></a></td></tr></table>";


	echo $reshead;


	$color1 = '#D0D0D0';
	$color2 = '#F6F6FF';
	$color3 = '#000000';

	echo "\n<b>".$totalrows." books in library<u>$req_htm</u> </b>\n";
	$navigatortop = "<tr><th valign=top bgcolor=$color1 colspan=17><font color=$color1><center><b>$prevlink1 | $nextlink1</b></center></font></th></tr>";
	$navigatorbottom = "<tr><th valign=top bgcolor=$color1 colspan=17><font color=$color1><center><b>$prevlink2 | $nextlink2</b></center></font></th></tr>";
	$tabheader = "<tr valign=top bgcolor=$color2><td><b>ID</b></td><td><b>".$LANG_MESS_6."</b></td><td><b>".$LANG_MESS_5."</b></td><td><b>".$LANG_MESS_9."</b></td><td><b>".$LANG_MESS_10."</b></td><td><b>".$LANG_MESS_28."</b></td><td><b>".$LANG_MESS_11."</b></td><td><b>".$LANG_MESS_26."</b></td><td><b>".$LANG_MESS_12."</b></td><td colspan=7><b>".$LANG_MESS_29."</b></td><td><b>".$LANG_MESS_30."</b></td></tr>";
	echo $navigatortop;
	echo $tabheader;

	//$repository = str_replace('\\','/',realpath($repository));

	$i = 1;
	while ($row = mysql_fetch_assoc($result)){
		$id = stripslashes($row['ID']);
		$title = stripslashes($row['Title']);
		$author = stripslashes($row['Author']);
		$vol = stripslashes($row['VolumeInfo']);
		$publisher = stripslashes($row['Publisher']);
		$year = $row['Year'];
		$pages = $row['Pages'];
                $periodical = stripslashes($row['Periodical']);
                $series = stripslashes($row['Series']);
		$lang = stripslashes($row['Language']);
		$ident1 = stripslashes($row['Identifier']);
		$edition = stripslashes($row['Edition']);
		$ext = stripslashes($row['Extension']);
                $ident = ereg_replace(",", ", ", $ident1);
        
        $bookname = '';
        if ($series <> '') {
            $bookname = "<font face=Times color=green><i>($series) </i></font>";
        }
        
        $bookname1 = '';
        if ($periodical <> '') {
            $bookname1 = "<font face=Times color=grey><i>$periodical </i></font>";
        }

        $bookname = $bookname1.$bookname.$title;


		$size = $row['Filesize'];
		if ($size >= 1024*1024*1024){
			$size = round($size/1024/1024/1024);
			$size = $size.' '.$LANG_MESS_GB;
		} else
		if ($size >= 1024*1024){
			$size = round($size/1024/1024);
			$size = $size.' '.$LANG_MESS_MB;
		} else
		if ($size >= 1024){
			$size = round($size/1024);
			$size = $size.' '.$LANG_MESS_KB;
		} else
			$size = $size.' '.$LANG_MESS_B;

		///////////
		// book info section (in parentheses)
		$volinf = $ident;

		if ($volinf){
			if ($ident) $volinf = ''.$ident;
		} else {
			if ($ident) $volinf = ''.$ident;
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



		$tip0 = "";
		$tip1 = $LANG_MESS_40;
		$tip3 = $LANG_MESS_41."libgen.org";
		$tip4 = $LANG_MESS_41."bookfi.org";
		$tip5 = $LANG_MESS_41."gen.lib.rus.ec";
		$tip6 = $LANG_MESS_41."libgen.info";
		$tip7 = $LANG_MESS_41."www.libgen.info";
		$tip8 = $LANG_MESS_41."libgen.net";
		$tip9 = $LANG_MESS_41."bookos.org";

		$line = "<tr valign=top bgcolor=$color><td>$row[ID]</td>
		<td>$author</td>
		<td width=500><a href='book/index.php?md5=$row[MD5]'title='' id=$ires>{$bookname}$volume$volstamp</a></td>
		<td>$publisher</td>
		<td nowrap>$year</td>
		<td nowrap>$pages</td>
		<td nowrap>$lang</td>
		<td nowrap>$size</td>
		<td nowrap>$ext</td>

		<td><a href='/get?nametype=$dlnametype&md5=$row[MD5]'title='$tip3'>[1]</a></td>
		<td><a href='http://gen.lib.rus.ec/get?nametype=$dlnametype&md5=$row[MD5]'title='$tip5'><b>[2]</b></a></td>
		<td><a href='http://bookfi.org/md5/$row[MD5]' title='$tip4'>[3]</a></td>
		<td><a href='http://libgen.info/view.php?id=$row[ID]' title='$tip6'>[4]</a></td>
		<td><a href='http://www.libgen.info/view.php?id=$row[ID]' title='$tip7'>[5]</a></td>
		<td><a href='http://libgen.net/view.php?id=$row[ID]' title='$tip8'>[6]</a></td>
		<td><a href='http://bookos.org/md5/$row[MD5]' title='$tip9'>[7]</a></td>
		<td><a href='/librarian/registration?md5=$row[MD5]'title='$tip1'>[edit]</a></td>
		</tr>\n\n";

		echo $line;
		$i = $i + 1;
	}

    echo $onClickScript;
    
	echo $navigatorbottom;
	echo $footer;
	echo $htmlfoot;

	mysql_free_result($result);
	mysql_close($con);
?>