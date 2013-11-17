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


    set_time_limit(40); 
   // usleep(200000);

	include 'connect.php';
	include 'html.php';
	//include 'strings.php';
	include 'util.php';
        include $lang_file;

    $footer = "</tr></table>\n";

    $dlnametypes = array('orig' => '',
                         'translit' => '',
                         'md5' => ''
    );
    
    foreach( $dlnametypes as $key => $value ) {
        if ( $key == $dlnametypes ) {
            $dlnametypes[$key] = 'checked';
        } else {
            $dlnametypes[$key] = '';
        }
    }

//запоминаем как установлены галки 

if(isset($_GET['column'])){

   if(in_array('title', $_GET['column'])) {
     $titlecheck = ' checked';} 
   else {$titlecheck = '';}

   if(in_array('author', $_GET['column'])) {
     $authorcheck = ' checked';} 
   else {$authorcheck = '';}

   if(in_array('series', $_GET['column'])) {
     $seriescheck = ' checked';} 
   else {$seriescheck = '';}

   if(in_array('periodical', $_GET['column'])) {
     $periodicalcheck = ' checked';} 
   else {$periodicalcheck = '';}

   if(in_array('publisher', $_GET['column'])) {
     $publishercheck = ' checked';} 
   else {$publishercheck = '';}

   if(in_array('year', $_GET['column'])) {
     $yearcheck = ' checked';} 
   else {$yearcheck = '';}

   if(in_array('identifier', $_GET['column'])) {
     $isbncheck = ' checked';} 
   else {$isbncheck = '';}

   if(in_array('language', $_GET['column'])) {
     $languagecheck = ' checked';} 
   else {$languagecheck = '';}

   if(in_array('md5', $_GET['column'])) {
     $md5check = ' checked';} 
   else {$md5check = '';}

   if(in_array('extension', $_GET['column'])) {
     $extensioncheck = ' checked';} 
   else {$extensioncheck = '';}

   if(in_array('topic', $_GET['column'])) {
     $topiccheck = ' checked';} 
   else {$topiccheck = '';}

} else {
$titlecheck = ' checked';
$authorcheck = ' checked';
$seriescheck = ' checked';
$periodicalcheck = ' checked';
$publishercheck = ' checked';
$yearcheck = ' checked';
$isbncheck = '';
$languagecheck = '';
$md5check = '';
$extensioncheck = '';
$topiccheck = '';
}








	$form = "<form name ='myform' action='search'><br>
	<input name='req' id='searchform' size=60 maxlength=80 value='$_GET[req]'><input type=submit onclick='this.disabled='disabled'; document.forms.item(0).submit();' value='".$LANG_SEARCH_0."'><br>
<font face=Arial color=gray size=1><a href='/batchsearchindex.php'>".$LANG_MESS_0."</a></font><br>

    <label><b>".$LANG_MESS_1."</b></label>
    <input type=radio name='nametype' id='orig' checked value='orig' ".$dlnametypes['orig']." onclick=radioOnClick('orig') />
    <label for='Original'>".$LANG_MESS_2."</label>
    <input type=radio name='nametype' id='translit' value='translit' ".$dlnametypes['translit']." onclick=radioOnClick('translit') />
    <label for='translit'>".$LANG_MESS_3."</label>
    <input type=radio name='nametype' id='md5' value='md5' ".$dlnametypes['md5']." onclick=radioOnClick('md5') />
    <label for='md5'>MD5</label><br>



<font><b>".$LANG_MESS_4."</b></font><input type='checkbox' name='column[]' value='title'".$titlecheck.">".$LANG_MESS_5."<input type='checkbox' name='column[]' value='author'".$authorcheck.">".$LANG_MESS_6."<input type='checkbox' name='column[]' value='series'".$seriescheck.">".$LANG_MESS_7."<input type='checkbox' name='column[]' value='periodical'".$periodicalcheck.">".$LANG_MESS_8."<input type='checkbox' name='column[]' value='publisher'".$publishercheck.">".$LANG_MESS_9."<br><input type='checkbox' name='column[]' value='year'".$yearcheck.">".$LANG_MESS_10."
<input type='checkbox' name='column[]' value='identifier'".$isbncheck.">ISBN<input type='checkbox' name='column[]' value='language'".$languagecheck."><a href='' title='Russian, English, German, French, Spanish, ... etc. (ISO 639)'>".$LANG_MESS_11."</a><input type='checkbox' name='column[]' value='md5'".$md5check.">MD5<input type='checkbox' name='column[]' value='extension'".$extensioncheck.">".$LANG_MESS_12."<input type='checkbox' name='column[]' value='topic'".$topiccheck.">".$LANG_MESS_13."

    	</form>";





if (sizeof($_GET)) $mainpage = false;
	else $mainpage = true;

	// SQL-requests should encode single-quotes and underscores with Esc-sequences
	if (!$mainpage){


		@$req = addcslashes(mysql_real_escape_string($_GET['req']),"%_");     
@$req = preg_replace('/[[:punct:]]+/u', ' ', $req);                
@$req = preg_replace('/[\s]+/u',' ',$req);
@$req = trim($req);


		if (strlen($req) < 1) die($htmlhead."<font color='#A00000'><h1>".$LANG_MESS_14."</h1></font>".$LANG_MESS_15.".<br>".$LANG_MESS_16."<a href=>".$LANG_MESS_17."</a>.".$htmlfoot);

		@$req_htm = htmlspecialchars($_GET['req'],ENT_QUOTES);
		$req_htm_enc = urlencode($_GET['req']);
        if( isset($_GET['nametype'])) $dlnametype = $_GET['nametype'];
        else $dlnametype = "translit"; //
	} else {
            
        $req  = "";
	$req_htm = "";

        $dlnametype = "orig";
	} 


@$scimag = "<form name ='scimag' action='/scimag/?s=scimag'><br>
	<input name=s id='sciform' size=60 maxlength=80 value='$scimag'><input type=submit  onclick='this.disabled='disabled'; document.forms.item(0).submit();'  value='".$LANG_SEARCH_0."'><br>
<font face=Arial color=gray size=1>".$LANG_MESS_18."<a href='http://sci-hub.org/'>sci-hub.org</a></font></td></tr>
</form>";

@$formcomics = "<form name ='myformcomics' action='/comics/?s=searchcomics'><br>
	<input name=s id='searchform' size=60 maxlength=80 value='$searchcomics'><input type=submit  onclick='this.disabled='disabled'; document.forms.item(0).submit();' value='".$LANG_SEARCH_0."'><br>
</form>";

@$formfiction = "<form name ='s' action='/foreignfiction/'><br>
	<input name=s size=60 maxlength=80 value='$s'><input type=submit  onclick='this.disabled='disabled'; document.forms.item(0).submit();'  value='".$LANG_SEARCH_0."'><br>
<font face=Arial color=gray size=1><a href='/foreignfiction/batchsearchindex.php'>".$LANG_MESS_0."</a></font>
</form>";





if(isset($_GET['column'])){
  $columns = $_GET['column'];

}


$search_words = explode(' ', $req);

if (@is_array($_GET['column'])){ 
$structureParts = array();
foreach($search_words as $search_word)
{
    $matchParts = array();
    foreach($columns as $column)
    {
        $safetyKeyword = mysql_real_escape_string($search_word);
        $matchParts[] = "MATCH(`$column`) AGAINST('$safetyKeyword*' IN BOOLEAN MODE)";
    }
    $matchParts1[] = "MATCH(`title`,`author`,`series`,`publisher`,`year`,`periodical`,`volumeinfo`) AGAINST('$safetyKeyword*' IN BOOLEAN MODE)";
    $structureParts[] = '('.join(' or ', $matchParts).')';
}
if($columns[0] == 'title' and $columns[1] == 'author' and $columns[2] == 'series' and $columns[3] == 'periodical' and $columns[4] == 'publisher' and $columns[5] == 'year' and @$columns[6] == ''){

$sql = join(' and ', $matchParts1);
}
else
{
$sql = join(' and ', $structureParts);
}
}



          echo $htmlheadfocus;
          echo '<table class="lang"><tr><td><a href="setlang.php?lang=ru">[RU]</a></td><td><a href="setlang.php?lang=en">[EN]</a></td></tr></table>';
          include_once 'menu_'.$lang.'.html';
 

	// if no arguments passed, give out the main page
	if ($mainpage) {
		$searchbody = "<table cellspacing=0 border=0 width=100% height=100%>
<col width='35%'>
<col width='65%'>		
<tr><caption><a href='/'><font color=#A00000><h1>Library Genesis<sup><font size=4>800k</font></sup></h1></font></a><br>
<b>".$LANG_MESS_31."</b></caption>

<td></td><td nowrap>{$form}</td></tr>
<tr><td nowrap valign='middle' align='right'><b><a href='/scimag/'>".$LANG_MESS_19."</a></b></td><td nowrap>{$scimag}</td></tr>	
<tr><td nowrap valign='bottom' align='right'><b><a href='/comics'>".$LANG_MESS_20."</a></b></td><td nowrap>{$formcomics}</td></tr>
<tr><td nowrap valign='middle' align='right'><b><a href='/foreignfiction'>".$LANG_MESS_21."</a></b></td><td nowrap valign='top'>{$formfiction}</td></tr>
</table>";




		//echo $toolbar;
		echo $searchbody;
		echo $footer;
		echo $htmlfoot;
		die;
	}

	// now look up in the database
        $errurl = 'http://genofond.org/viewtopic.php?f=3&t=3925';


	$dberr = $htmlhead."<font color='#A00000'><h1>Error</h1></font>".mysql_error()."<br>Cannot proceed.<p>Please, <a href='{$errurl}'><u>report</u></a> on this error.".$htmlfoot;

	if (isset($_GET['lines'])) $lines = $_GET['lines'];
	else $lines = $maxlines;

	// reset to deafult $maxlines, if wrong
	if ($lines > $maxlines || $lines <= 0) $lines = $maxlines;

	if (isset($_GET['lines'])) $from = $_GET['from'];
	else $from = 0;

	if ($from < $maxlines - $lines) $from = 0;



	if (isset($_GET['sort'])){$sort = $_GET['sort'];

	if (isset($_GET['from'])) $from = $_GET['from'];
	else $from = 0;
        }else{$sort = 'title';}



	$sql_end = " ORDER BY ".$sort." LIMIT $from, $lines";
	$sql_mid = "FROM $dbtable WHERE ($sql AND Filename!='' AND Generic='' AND Visible='')";
        $sql_req = "SELECT ID, Title, Author, Edition, Year, VolumeInfo, MD5, Extension, Filesize, Series, Periodical, Identifier, Publisher, Pages, Language ".$sql_mid.$sql_end;

        $sql_cnt = "SELECT SUM(Filesize), COUNT(*) ".$sql_mid;
	$result = mysql_query($sql_cnt,$con);
	if (!$result) die($dberr);
//echo $sql_req;

	$row = mysql_fetch_assoc($result);
	$totalrows = stripslashes($row['COUNT(*)']);
	$totalsize = stripslashes($row['SUM(Filesize)']);
	if ($totalsize >= 1024*1024*1024){
        	$totalsize = round($totalsize/1024/1024/1024);
		$totalsize = $totalsize.' '.$LANG_MESS_GB;
		} else
		if ($totalsize >= 1024*1024){
			$totalsize = round($totalsize/1024/1024);
			$totalsize = $totalsize.' '.$LANG_MESS_MB;
		} else
		if ($totalsize >= 1024){
			$totalsize = round($totalsize/1024);
			$totalsize = $totalsize.' '.$LANG_MESS_KB;
		} else
			$totalsize = $totalsize.' '.$LANG_MESS_B;

	mysql_free_result($result);

	$result = mysql_query($sql_req,$con);
	if (!$result) die($dberr);

///////////////////////////////////////////////////////////////
	// pagination


        $args = "search.php?nametype=$dlnametype&req=$req_htm_enc&lines=$lines";


        
foreach ($columns as $col){
$args .= "&column[]=$col";
} 

	if ($totalrows > $from + $lines){
		$nextpage = $from + $lines;
if(isset($_GET['sort'])){
		$argsnext = $args."&sort=".$sort."&from=".$nextpage;}else{$argsnext = $args."&from=".$nextpage;}
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
		if ($prevpage < 0) {$prevpage = 0;}

if(isset($_GET['sort'])){
		$argsprev = $args."&sort=".$sort."&from=".$prevpage;}else{$argsprev = $args."&from=".$prevpage;}

		//$argsprev = $args."&sort=".$sort."&from=".$prevpage;

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
    
//	$reshead = "<table width=100% cellspacing=0 cellpadding=0 border=1 class=c align=center>";
	$reshead = "<table width=100% cellspacing=1 cellpadding=1 rules=rows class=c align=center>";

	if (!$mainpage){
echo "<table width=100%><tr><td>$form</td><td><a href='/'><font color=#A00000 valign=top align=right><h1>Library Genesis<sup><font size=4>800k</font></a></td></tr></table>";
}
	echo $reshead;
        // echo $googletrans;

	$color1 = '#D0D0D0';
//	$color2 = '#F6F6FF';
	$color2 = '#F0F5FE';
	$color3 = '#000000';

        $req_htmadd = str_replace(' ', '+', $req_htm);

	echo "\n<b>".$totalsize."\t,\t".$totalrows." ".$LANG_MESS_22." \"$req_htm\" ".$LANG_MESS_23." <a href='/scimag/?s=$req_htmadd'>".$LANG_MESS_19."</a>, <a href='/foreignfiction/?s=$req_htm&f_cols=Author:Title:Series&f_lang=0&page=1'>".$LANG_MESS_21."</a>, <a href='/comics/?s=$req_htmadd'>".$LANG_MESS_20."</a></b>\n";
	$navigatortop = "<tr><th valign=top bgcolor=$color1 colspan=17><font color=$color1><center><b>$prevlink1 | $nextlink1</b></center></font></th></tr>";
	$navigatorbottom = "<tr><th valign=top bgcolor=$color1 colspan=17><font color=$color1><center><b>$prevlink2 | $nextlink2</b></center></font></th></tr>";
	$tabheader = "<tr valign=top bgcolor=$color2><td><b>ID</b></td><td><b><a title='".$LANG_MESS_32."' href='".$args."&sort=author'>".$LANG_MESS_6."</a></b></td><td><b><a title='".$LANG_MESS_33."' href='".$args."&sort=title'>".$LANG_MESS_5."</a></b></td><td><b><a title='".$LANG_MESS_34."' href='".$args."&sort=publisher'>".$LANG_MESS_9."</a></b></td><td><b><a title='".$LANG_MESS_35."' href='".$args."&sort=year'>".$LANG_MESS_10."</a></b></td><td><b><a title='".$LANG_MESS_36."' href='".$args."&sort=abs(pages)'>".$LANG_MESS_28."</a></b></td><td><b><a title='".$LANG_MESS_37."' href='".$args."&sort=language'>".$LANG_MESS_11."</a></b></td><td><b><a title='".$LANG_MESS_38."' href='".$args."&sort=filesize'>".$LANG_MESS_26."</a></b></td><td><b><a title='".$LANG_MESS_39."' href='".$args."&sort=extension'>".$LANG_MESS_12."</a></b></td><td colspan=7><b>".$LANG_MESS_29."</b></td><td><b>".$LANG_MESS_30."</b></td></tr>";
	echo $navigatortop;
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
			if ($ident) $volinf = $ident;
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

		$line = "<tr valign=top bgcolor=$color><td>$ires</td>
		<td>$author</td>
		<td width=500><a href='book/index.php?md5=$row[MD5]' title='$tip0' id=$ires>{$bookname}$volume$volstamp</a></td>
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

