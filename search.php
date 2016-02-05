<?php

ini_set('max_execution_time','60');
ini_set('memory_limit','10M');
ini_set('max_input_time','60');
ini_set('display_errors','0');


//print_r($_SERVER);

ini_set('display_errors', '0');
if (isset($_COOKIE['lang']))
{
	$lang      = $_COOKIE['lang'];
	$lang_file = 'lang_' . $lang . '.php';
	if (!file_exists($lang_file))
	{
		$lang_file = 'lang_en.php';
	}
}
else
{
	$lang      = 'en';
	$lang_file = 'lang_en.php';
}






if(isset($_GET['lg_topic'])) 
{


	if(in_array($_GET['lg_topic'], array('libgen', 'comics', 'scimag', 'standarts', 'fiction', 'magzdb')))
	{

		$lg_topic = $_GET["lg_topic"];
		SetCookie('lg_topic', $lg_topic, time()+360000);
	} 
	else
	{
		$lg_topic = 'libgen';
		SetCookie('lg_topic', 'libgen', time()+360000);
	}
}
else
{
	$lg_topic = 'libgen';
	SetCookie('lg_topic', 'libgen', time()+360000); 
}

//echo $lg_topic;

$libgenchecked = '';
$comicschecked = '';
$scimagchecked = '';
$standartschecked = '';
$fictionchecked = '';
$magzdbchecked = '';


if($_COOKIE['lg_topic'] == 'libgen')
{
	$libgenchecked = ' checked';
}
elseif($_COOKIE['lg_topic'] == 'comics')
{
	$comicschecked = ' checked';
}
elseif($_COOKIE['lg_topic'] == 'scimag')
{
	$scimagchecked = ' checked';
}
elseif($_COOKIE['lg_topic'] == 'fiction')
{
	$fictionchecked = ' checked';
}
elseif($_COOKIE['lg_topic'] == 'standarts')
{
	$standartschecked = ' checked';
}
elseif($_COOKIE['lg_topic'] == 'magzdb')
{
	$magzdbchecked = ' checked';
}
else
{
	$libgenchecked = ' checked';
}


if(!empty($_GET))
{
	include 'connect.php'; //коннектимся к базе только если переданы какие-то параметры поиска 
}
include 'html.php';

include $lang_file;
$footer = "</tr></table>\n";


function checkData($mydate) {
	@list($yyyy,$mm,$dd)=@explode("-",$mydate);
	if (is_numeric($yyyy) && is_numeric($mm) && is_numeric($dd))
	{
		return checkdate($mm,$dd,$yyyy);
	}
	return false;           
} 



if (isset($_GET['res']))
{
	if (in_array($_GET['res'], array(25,50,100)))
	{
		$res_on_page = $_GET['res'];
	}
	else
	{
		$res_on_page = 25;
	}
}
else
{
	$res_on_page = 25;
}


//echo $res_on_page;

if (isset($_GET['open']))
{
	if (preg_match('~^(0|1|2|3){1}$~', $_GET['open']))
	{
		$open = $_GET['open'];
	}
	else
	{
		$open = 0;
	}
}
elseif (isset($_GET['nametype']) && $_GET['nametype'] == 'orig')
{
	$open = 0;
}
elseif (isset($_GET['nametype']) && $_GET['nametype'] == 'translit')
{
	$open = 1;
}
elseif (isset($_GET['nametype']) && $_GET['nametype'] == 'md5')
{
	$open = 2;
}
else
{
	$open = 0;
}

if(isset($_GET['phrase']))
{
	if (preg_match('~^(0|1){1}$~', $_GET['phrase']))
	{
		$full_phrase = $_GET['phrase'];
	}
	else
	{
		$full_phrase = 1;	
	}
}
else
{
	$full_phrase = 1;	
}



if($full_phrase == 1) 
{
	$full_phrase_checked1 = 'checked'; 
	$full_phrase_checked0 = '';
}
else 
{	
	$full_phrase_checked0 = 'checked'; 
	$full_phrase_checked1 = '';
}



if (isset($res_on_page))
{
	$res_on_page25 = '';
	$res_on_page50 = '';
	$res_on_page100 = '';


	if ($res_on_page == 25)
		$res_on_page25 = " selected='selected'";
	elseif ($res_on_page == 50)
		$res_on_page50 = " selected='selected'";
	elseif ($res_on_page == 100)
		$res_on_page100 = " selected='selected'";

}



if (isset($open))
{
	$opencheck0 = '';
	$opencheck1 = '';
	$opencheck2 = '';
	$opencheck3 = '';

	if ($open == 0)
		$opencheck0 = " selected='selected'";
	elseif ($open == 1)
		$opencheck1 = " selected='selected'";
	elseif ($open == 2)
		$opencheck2 = " selected='selected'";
	elseif ($open == 3)
		$opencheck3 = " selected='selected'";
}

if($open == 0)
	$openreq = '';
else
	$openreq = '&open='.$open;


if($res_on_page == 25)
	$resreq = '';
else
	$resreq = '&res='.$res_on_page;


if (isset($_GET['timefirst']))
{
	if(checkData($_GET['timefirst'], 'Y-m-d')==true)
	{
		$timefirst = $_GET['timefirst'];
	}
	else	
	{
		$timefirst = '';	
	}
}
else
{
	$timefirst = '';

}

if (isset($_GET['timelast']))
{
	if(checkData($_GET['timelast'], 'Y-m-d')==true)
	{
		$timelast = $_GET['timelast'];
	}
	else	
	{
		$timelast = '';
	}
}
else
{
	$timelast = '';
}

if ($timefirst != '' && $timelast == '')
{
		$timelast = date("Y-m-d");
}

if (isset($_GET['req']))
{
	$req = $_GET['req'];
}
else
{
	$req = '';
}
if (isset($_GET['view']))
{
	$view = $_GET['view'];
}
else
{
	$view = 'simple';
}
if ($view == 'simple')
{
	$detailedchecked = '';
	$simplechecked   = 'checked';
}
else
{
	$detailedchecked = 'checked';
	$simplechecked   = '';
}
if (isset($_GET['mode']) && in_array($_GET['mode'], array(
	'last',
	'modified',
	'search'
)))
{
	$mode = $_GET['mode'];
}
else
{
	$mode = 'search';
}
if (isset($_GET['page']))
{
	$page = trim($_GET['page']);
}
else
{
	$page = 1;
}
if (isset($_GET['column']))
{
	$defcheck        = '';
	$titlecheck      = '';
	$authorcheck     = '';
	$seriescheck     = '';
	$periodicalcheck = '';
	$publishercheck  = '';
	$yearcheck       = '';
	$isbncheck       = '';
	$languagecheck   = '';
	$md5check        = '';
	$extensioncheck  = '';
	$topiccheck      = '';


	if    ($_GET['column'] == 'def')
	{
		$defcheck = ' checked';
	}
	elseif($_GET['column'] == 'title')
	{
		$titlecheck = ' checked';
	}
	elseif ($_GET['column'] == 'author')
	{
		$authorcheck = ' checked';
	}
	elseif ($_GET['column'] == 'series')
	{
		$seriescheck = ' checked';
	}
	elseif ($_GET['column'] == 'periodical')
	{
		$periodicalcheck = ' checked';
	}
	elseif ($_GET['column'] == 'publisher')
	{
		$publishercheck = ' checked';
	}
	elseif ($_GET['column'] == 'year')
	{
		$yearcheck = ' checked';
	}
	elseif ($_GET['column'] == 'identifier')
	{
		$isbncheck = ' checked';
	}
	elseif ($_GET['column'] == 'language')
	{
		$languagecheck = ' checked';
	}
	elseif ($_GET['column'] == 'md5')
	{
		$md5check = ' checked';
	}
	elseif ($_GET['column'] == 'extension')
	{
		$extensioncheck = ' checked';
	}
	elseif ($_GET['column'] =='topic')
	{
		$topiccheck = ' checked';
	}
	else
	{
		$defcheck        = ' checked ';
	}
}
else
{
	$defcheck        = ' checked ';
	$titlecheck      = '';
	$authorcheck     = '';
	$seriescheck     = '';
	$periodicalcheck = '';
	$publishercheck  = '';
	$yearcheck       = '';
	$isbncheck       = '';
	$languagecheck   = '';
	$md5check        = '';
	$extensioncheck  = '';
	$topiccheck      = '';
}

//	"language",
if (isset($_GET['column']) && !is_array($_GET['column']) && in_array($_GET['column'], array(
	"title",
	"author",
	"series",
	"periodical",
	"publisher",
	"year",
	"identifier",

	"md5",
	"extension",
	"topic")))
{
	$columns = $_GET['column'];
}
else
{
	$columns = 'def';
}

if($lg_topic == 'comics')
{
	header( 'Location: /comics/index.php?s='.$req, true, 301 );
}
elseif($lg_topic == 'scimag')
{
	header( 'Location: /scimag/index.php?s='.$req, true, 301 );
}
elseif($lg_topic == 'fiction')
{
	header( 'Location: /foreignfiction/index.php?s='.$req.'&f_lang=0&f_columns=0&f_ext=0&f_group=1', true, 301 );
}
elseif($lg_topic == 'standarts')
{
	header( 'Location: /standarts/index.php?s='.$req, true, 301 );
}
elseif($lg_topic == 'magzdb')
{
	header( 'Location: http://magzdb.org/makelist?t='.$req, true, 301 );
}


if (sizeof($_GET))
	$mainpage = false; //определяем выводится гл. стр или поиск по ЛГ
else
	$mainpage = true;


if($mainpage)
{
	if($lang!='en')
	{
		$smradio_button = "<td><input type='radio' name='lg_topic' value='scimag' " . $scimagchecked . "><a href='/scimag/index.php'>$LANG_MESS_19</a></td>";
	}	
	else
	{
		$smradio_button = '<td></td>';
	}

	$form = "<form name ='libgen' action='search.php'>
	<input autofocus='autofocus' name='req' id='searchform' size=60 maxlength=200 value='" . htmlspecialchars($req, ENT_QUOTES) . "'>
<input type=submit onclick='this.disabled='disabled'; document.forms.item(0).submit();' value='" . $LANG_SEARCH_0 . "'><br>

<b>".$LANG_MESS_228."</b> :<br>
<table border=0>
<tr>
<td><input type='radio' name='lg_topic' value='libgen' " . $libgenchecked . "><a href='/'>LibGen (Sci-Tech)</a></td>
<td><input type='radio' name='lg_topic' value='standarts' " . $standartschecked . "><a href='/standarts/index.php'>$LANG_MESS_226</a></td>
<td><input type='radio' name='lg_topic' value='fiction' " . $fictionchecked . "><a href='/foreignfiction/index.php'>$LANG_MESS_21</a></td>
</tr>
<tr>
<td><input type='radio' name='lg_topic' value='comics' " . $comicschecked . "><a href='/comics/index.php'>$LANG_MESS_20</a></td>
".$smradio_button."
<td><input type='radio' name='lg_topic' value='magzdb' " . $magzdbchecked . "><a href='http://magzdb.org'>$LANG_MESS_180</a></td>
</tr></table>
<br><font color=grey>LibGen ".$LANG_MESS_227.":</font>
<br>
	<label><b>" . $LANG_MESS_1 . "</b></label>
<select name='open' size='1'>
<option value='0'$opencheck0>$LANG_MESS_173</option>
<option value='1'$opencheck1>$LANG_MESS_174</option>
<option value='2'$opencheck2>$LANG_MESS_175</option>
<option value='3'$opencheck3>$LANG_MESS_176</option>
</select><br>
	<b>" . $LANG_MESS_167 . ":</b>
	<input type=radio name='view' " . $simplechecked . " value='simple'>
	<label for='simple'>" . $LANG_MESS_168 . "</label>
	<input type=radio name='view'  " . $detailedchecked . "  value='detailed'>
	<label for='detailed'>" . $LANG_MESS_169 . "</label>
		<br>

	<label><b>" . $LANG_MESS_280 . "</b></label>
<select name='res' size='1'>
<option value='25'$res_on_page25>25</option>
<option value='50'$res_on_page50>50</option>
<option value='100'$res_on_page100>100</option>

</select>



	<br>
	<b>   " . $LANG_MESS_208 . ":</b>
	<input type=radio name='phrase'  " . $full_phrase_checked1 . "  value='1'>
	<label for='detailed'>" . $LANG_MESS_209 . "</label>
	<input type=radio name='phrase' " . $full_phrase_checked0 . " value='0'>
	<label for='simple'>" . $LANG_MESS_210 . "</label>
	<br>
<font><b>" . $LANG_MESS_4 . "</b></font>
<input type='radio' name='column' value='def'" . $defcheck . "><a href='#' title='".$LANG_MESS_198."'>" . $LANG_MESS_197 . "</a>
<input type='radio' name='column' value='title'" . $titlecheck . ">" . $LANG_MESS_5 . "
<input type='radio' name='column' value='author'" . $authorcheck . ">" . $LANG_MESS_6 . "
<input type='radio' name='column' value='series'" . $seriescheck . ">" . $LANG_MESS_7 . "<br>
<input type='radio' name='column' value='periodical'" . $periodicalcheck . ">" . $LANG_MESS_8 . "
<input type='radio' name='column' value='publisher'" . $publishercheck . ">" . $LANG_MESS_9 . "
<input type='radio' name='column' value='year'" . $yearcheck . ">" . $LANG_MESS_10 . "
<input type='radio' name='column' value='identifier'" . $isbncheck . ">ISBN
<input type='radio' name='column' value='language'" . $languagecheck . "><a href='' title='Russian, English, German, French, Spanish, ... etc. (ISO 639)'>" . $LANG_MESS_11 . "</a>
<input type='radio' name='column' value='md5'" . $md5check . ">MD5
<input type='radio' name='column' value='extension'" . $extensioncheck . ">" . $LANG_MESS_12 . "
</form>";
}
else
{
$form = "<form name ='libgen' action='search.php'><br>
	<input autofocus='autofocus' name='req' id='searchform' size=60 maxlength=80 value='" . htmlspecialchars($req, ENT_QUOTES) . "'>
<input type=submit onclick='this.disabled='disabled'; document.forms.item(0).submit();' value='" . $LANG_SEARCH_0 . "'><br>
<font face=Arial color=gray size=1><a href='../batchsearchindex.php'>" . $LANG_MESS_0 . "</a></font><br>
	<label><b>" . $LANG_MESS_1 . "</b></label>
<select name='open' size='1'>
<option value='0'$opencheck0>$LANG_MESS_173</option>
<option value='1'$opencheck1>$LANG_MESS_174</option>
<option value='2'$opencheck2>$LANG_MESS_175</option>
<option value='3'$opencheck3>$LANG_MESS_176</option>
</select>
<label><b>" . $LANG_MESS_280 . "</b></label>
<select name='res' size='1'>
<option value='25'$res_on_page25>25</option>
<option value='50'$res_on_page50>50</option>
<option value='100'$res_on_page100>100</option>
</select>
<br>
	<b>" . $LANG_MESS_167 . ":</b>
	<input type=radio name='view' " . $simplechecked . " value='simple'>
	<label for='simple'>" . $LANG_MESS_168 . "</label>
	<input type=radio name='view'  " . $detailedchecked . "  value='detailed'>
	<label for='detailed'>" . $LANG_MESS_169 . "</label>
	<b>   " . $LANG_MESS_208 . ":</b>
	<input type=radio name='phrase'  " . $full_phrase_checked1 . "  value='1'>
	<label for='detailed'>" . $LANG_MESS_209 . "</label>
	<input type=radio name='phrase' " . $full_phrase_checked0 . " value='0'>
	<label for='simple'>" . $LANG_MESS_210 . "</label>
	<br>
<font><b>" . $LANG_MESS_4 . "</b></font>
<input type='radio' name='column' value='def'" . $defcheck . "><a href='#' title='".$LANG_MESS_198."'>" . $LANG_MESS_197 . "</a>
<input type='radio' name='column' value='title'" . $titlecheck . ">" . $LANG_MESS_5 . "
<input type='radio' name='column' value='author'" . $authorcheck . ">" . $LANG_MESS_6 . "
<input type='radio' name='column' value='series'" . $seriescheck . ">" . $LANG_MESS_7 . "<br>
<input type='radio' name='column' value='periodical'" . $periodicalcheck . ">" . $LANG_MESS_8 . "
<input type='radio' name='column' value='publisher'" . $publishercheck . ">" . $LANG_MESS_9 . "
<input type='radio' name='column' value='year'" . $yearcheck . ">" . $LANG_MESS_10 . "
<input type='radio' name='column' value='identifier'" . $isbncheck . ">ISBN
<input type='radio' name='column' value='language'" . $languagecheck . "><a href='' title='Russian, English, German, French, Spanish, ... etc. (ISO 639)'>" . $LANG_MESS_11 . "</a>
<input type='radio' name='column' value='md5'" . $md5check . ">MD5
<input type='radio' name='column' value='extension'" . $extensioncheck . ">" . $LANG_MESS_12 . "
</form>";

}
//<tr><td nowrap valign='middle' align='right'><b><a href='/scimag/index.php'>" . $LANG_MESS_19 . "</a></b></td><td nowrap>{$lg_topic_form}</td></tr>	
//<tr><td nowrap valign='middle' align='right'><b><a href='/comics/index.php'>" . $LANG_MESS_20 . "</a></b></td><td nowrap>{$formcomics}</td></tr>
//<tr><td nowrap valign='middle' align='right'><b><a href='/foreignfiction/index.php'>" . $LANG_MESS_21 . "</a></b></td><td nowrap valign='top'>{$formfiction}</td></tr>
//<tr><td nowrap valign='bottom' align='right'><b><a href='http://magzdb.org/'>" . $LANG_MESS_180 . "</a></b></td><td nowrap valign='top'>{$formmagzdb}</td></tr>



/*
<input type='checkbox' name='column[]' value='title'" . $titlecheck . ">" . $LANG_MESS_5 . "
<input type='checkbox' name='column[]' value='author'" . $authorcheck . ">" . $LANG_MESS_6 . "
<input type='checkbox' name='column[]' value='series'" . $seriescheck . ">" . $LANG_MESS_7 . "
<input type='checkbox' name='column[]' value='periodical'" . $periodicalcheck . ">" . $LANG_MESS_8 . "
<input type='checkbox' name='column[]' value='publisher'" . $publishercheck . ">" . $LANG_MESS_9 . "<br>
<input type='checkbox' name='column[]' value='year'" . $yearcheck . ">" . $LANG_MESS_10 . "
<input type='checkbox' name='column[]' value='identifier'" . $isbncheck . ">ISBN
<input type='checkbox' name='column[]' value='language'" . $languagecheck . "><a href='' title='Russian, English, German, French, Spanish, ... etc. (ISO 639)'>" . $LANG_MESS_11 . "</a>
<input type='checkbox' name='column[]' value='md5'" . $md5check . ">MD5
<input type='checkbox' name='column[]' value='extension'" . $extensioncheck . ">" . $LANG_MESS_12 . "
</form>";
*/



if (!$mainpage && $mode == 'search')
{
	if (strlen($req) < 4)
		die($htmlhead . "<font color='#A00000'><h1>" . $LANG_MESS_14 . "</h1></font>" . $LANG_MESS_15 . ".<br>" . $LANG_MESS_16 . "<a href=>" . $LANG_MESS_17 . "</a>." . $htmlfoot);
	$req_htm     = htmlspecialchars($_GET['req'], ENT_QUOTES); //для вывода на веб-страницу
	$req_htm_enc = urlencode($_GET['req']); //для вывода в адресную строку
	//$req         = preg_replace('/[[:punct:]]+/u', ' ', trim($req)); //для подстановки в sql запрос
	//$req         = preg_replace('/[\s]+/u', ' ', trim($req));
}
else
{
	$req     = "";
	$req_htm = "";
	$open    = "0";
	//$res_on_page = "25";
}

//@$lg_topic_form = "<form name ='search' action='/search.php?lg_topic=$lg_topic&s=$search'><br>
//	<input name=s  size=60 maxlength=80 value='$search'>

//<input type=submit   value='" . $LANG_SEARCH_0 . "' onclick='this.disabled='disabled'; document.forms.item(0).submit();'><br>
//<font face=Arial color=gray size=1>" . $LANG_MESS_18 . " <a href='http://sci-hub.org/'>sci-hub.org</a></font><br>
//<input type='radio' name='lg_topic' value='scimag'" . $scimagcheck . ">Scimag
//<input type='radio' name='lg_topic' value='comics'" . $comicscheck . ">Comics

//</td></tr>

//</form>";


//@$formcomics = "<form name ='comics' action='/comics/index.php?s=searchcomics'><br>
//	<input name=s  size=60 maxlength=80 value='$searchcomics' ><input type=submit  value='" . $LANG_SEARCH_0 . "' onclick='this.disabled='disabled'; document.forms.item(0).submit();'><br>
//<font face=Arial color=gray size=1><a href='http://libgen.org/comics/batchsearchindex.php'>" . $LANG_MESS_183 . "</a></font>
//</form>";
//@$formfiction = "<form name ='ffiction' action='/foreignfiction/'><br>
//	<input name=s size=60 maxlength=80 value='$s'><input type=submit   value='" . $LANG_SEARCH_0 . "' onclick='this.disabled='disabled'; document.forms.item(0).submit();'><br>
//<font face=Arial color=gray size=1><a href='/foreignfiction/batchsearchindex.php'>" . $LANG_MESS_0 . "</a></font>
//</form>";
//@$formmagzdb = "<form name ='magzdb' action='http://magzdb.org/makelist'><br>
//	<input name=t size=60 maxlength=80 value='$t'><input type=submit   value='" . $LANG_SEARCH_0 . "' onclick='this.disabled='disabled'; document.forms.item(0).submit();'></form>";



function fulltext_search($req, $columns, $full_phrase)
{
	$req = strtr($req, array(
		'—' => '-',
		'–' => ''
	));
	//предварительно заменить длинное тире и пр. на дефисы
	preg_match_all('~(97[89][-]){0,1}[0-9]{1,5}[- ][0-9]{1,7}[- ][0-9]{1,6}[- ][0-9X]~', $req, $isbnfindname, PREG_PATTERN_ORDER);


	if (count($isbnfindname[0]) < 1) //если в имени файла не найден ISBN с дефисами, то ищем без дефисов
	{
		preg_match_all('~(978|)[0-9]{9}[0-9X]{1}~', str_replace('-', '', $req), $isbnfindname, PREG_PATTERN_ORDER);
		if (count($isbnfindname[0]) > 0)
		{
			$isbnfindname1 = array_fill_keys($isbnfindname[0], '');
			$req           = strtr($req, $isbnfindname1);
		}
	}
	else
	{
		$isbnfindname1 = array_fill_keys($isbnfindname[0], '');
		$req           = strtr($req, $isbnfindname1);
	}

print_r($isbnfindname1);


	//if (!empty($isbnfindname[0]))
	//{
	//	$columns = array_diff(array_map('strtolower', $columns), array('identifier'));

	//} //если ISBN найден в поисковой строке, то колонку Identifier из дальнейшего поиска исключаем, тк ISBN ищутся позже отдельно
	//echo $req;
	//print_r($isbnfindname[0]);
	preg_match_all('|topicid[0-9]+|', $req, $topicfindname, PREG_PATTERN_ORDER);
	if (count($topicfindname[0]) > 0) //если в имени файла не найден ISBN с дефисами, то ищем без дефисов
	{
		$topicfindname1 = array_fill_keys($topicfindname[0], '');
		$req            = strtr($req, $topicfindname1);
	}
	//echo $req;
	//print_r($topicfindname[0]);
	if (!empty($topicfindname[0]))
	{
		$columns = array_diff(array_map('strtolower', $columns), array(
			'topic'
		));
	} //если ISBN найден в поисковой строке, то колонку Identifier из дальнейшего поиска исключаем, тк ISBN ищутся позже отдельно
	if (preg_match('|[A-Za-zА-Яа-я0-9]|', $req) && !empty($columns))
	{
		$req             = preg_replace('/[[:punct:]]+/u', ' ', $req); //для подстановки в sql запрос
		$req             = preg_replace('/[\s]+/u', ' ', trim($req));

				

		/*$default_columns = array(
			'title',
			'author',
			'series',
			'periodical',
			'publisher',
			'year'
		);
		*/
		$search_words    = explode(' ', $req);
		if ($columns == 'def')
		{
			$def_columns = 'title`,`author`,`series`,`publisher`,`year`,`periodical`,`volumeinfo';
		}
		else
		{
			$def_columns = $columns;
		}

		foreach ($search_words as $search_word)
		{
			if (preg_match('~^[0-9]{1,3}$~', $search_word) && empty($isbnfindname1)) //для случая, если ищется номер, который может быть записан с 0 в начале
			{
				$sql_word[] = "+(" . ltrim($search_word, "0") . " 0" . ltrim($search_word, "0") . " 00" . ltrim($search_word, "0") . " 000" . ltrim($search_word, "0") . ")";
			}
			elseif(mb_strlen($search_word)>1) //07052015 убираем слова короче 1 буквы
			{
				$sql_word[] = '+' . $search_word . '*';
			}
		}


		if($full_phrase == '0')
		$sql = " MATCH(`".$def_columns."`) AGAINST(' " . join(' ', $sql_word) . "' IN BOOLEAN MODE)";
		else 	
		$sql = " MATCH(`".$def_columns."`) AGAINST('» " . join(' ', $sql_word) . "»' IN BOOLEAN MODE)";

		if($columns == 'language')
		{
			//$sql = " `Language`= '".$req."'";
			$sql = " MATCH(`Language`) AGAINST('" . $req . "' IN BOOLEAN MODE)";
			
		}


		if($columns == 'md5')
		{
			if(preg_match('|^[0-9A-Fa-f]{32}$|', $req))
			{
				$sql = " `MD5`= '".$req."'";


			}
			else
			{

die($htmlhead . "<font color='#A00000'><h1>Wrong MD5</h1></font>" . $htmlfoot);

			}
		
		}
		



		//}
		/*else //для случая если не стандартный набор колонок по умолчанию, по которому нет индекса
		{
			foreach ($search_words as $search_word)
			{
				if (preg_match('~^[0-9]{1,3}$~', $search_word)) //для случая, если ищется номер, который может быть записан с 0 в начале
				{
					foreach ($columns as $column)
					{
						$sql_cols[] = " MATCH(`$column`) AGAINST('" . ltrim($search_word, "0") . " " . $search_word . " 0" . $search_word . " 00" . $search_word . " 000" . $search_word . "' IN BOOLEAN MODE) ";
					}
				}
				else
				{
					foreach ($columns as $column)
					{
						$sql_cols[] = " MATCH(`$column`) AGAINST('$search_word*' IN BOOLEAN MODE) ";
					}
				}
				$sql_word[] = '(' . join(' or ', $sql_cols) . ')';
				unset($sql_cols);
			}
			$sql = join(' AND ', $sql_word);
		}
		*/
		if (!empty($isbnfindname[0])) // дописываем условие поиска по ISBN, не зависимо от того задана ли такая колонка
		{
			foreach ($isbnfindname[0] as $isbnfindname1)
			{
				//$sqlisbn[] = " REPLACE(`Identifier`, '-', '') like '%" . str_replace('-', '', $isbnfindname1) . "%'";
				if(preg_match('|\-|',$isbnfindname1))
				{
					if(mysql_num_rows(mysql_query("select id from `".$dbtable."` where MATCH(`Identifier`) AGAINST ('» +".str_replace('-', ' +', $isbnfindname1)."»' IN BOOLEAN MODE)", con))>0)
					{
						$sqlisbn[] = " MATCH(`Identifier`) AGAINST ('» +".str_replace('-', ' +', $isbnfindname1)."»' IN BOOLEAN MODE) ";
					}
					else
					{
						$sqlisbn[] = " MATCH(`Identifier`) AGAINST ('".str_replace('-', '', $isbnfindname1)."' IN BOOLEAN MODE) ";
					}
				}
				else
				{
					$sqlisbn[] = " MATCH(`Identifier`) AGAINST ('". $isbnfindname1."' IN BOOLEAN MODE) ";
				}				

			}
			$sqlisbn = join(' OR ', $sqlisbn);
			$sql .= " AND (" . $sqlisbn . ")";
		}
		if (!empty($topicfindname[0])) 
		{
			foreach ($topicfindname[0] as $topicfindname1)
			{
				/*if (in_array($topicfindname1, array(
					'topicid1',
					'topicid12',
					'topicid32',
					'topicid38',
					'topicid41',
					'topicid57',
					'topicid64',
					'topicid69',
					'topicid102',
					'topicid113',
					'topicid147',
					'topicid178',
					'topicid183',
					'topicid189',
					'topicid198',
					'topicid205',
					'topicid210',
					'topicid264',
					'topicid289',
					'topicid296',
					'topicid305',
					'topicid314'
				)))
				{
					$sqltopic[] = "(`topic` = '" . str_replace('topicid', '', $topicfindname1) . "' OR `topic` IN (SELECT `topic_id` FROM `topics` WHERE `topic_id_hl` = '" . str_replace('topicid', '', $topicfindname1) . "' AND `lang` = 'ru'))";
				}
				else
				{*/
					$sqltopic[] = " (`Topic` = '" . str_replace('topicid', '', $topicfindname1) . "' )";
				//}
			}
			$sqltopic = join(' OR ', $sqltopic);
			$sql .= " AND (" . $sqltopic . ")";
		}
	}
	else
	{
		if (!empty($isbnfindname[0])) // дописываем условие поиска по ISBN, не зависимо от того задана ли такая колонка
		{
			foreach ($isbnfindname[0] as $isbnfindname1)
			{
				//$sqlisbn[] = " REPLACE(`Identifier`, '-', '') like '%" . str_replace('-', '', $isbnfindname1) . "%'";
				if(preg_match('|\-|',$isbnfindname1))
				{
					if(mysql_num_rows(mysql_query("select id from `".$dbtable."` where MATCH(`Identifier`) AGAINST ('» +".str_replace('-', ' +', $isbnfindname1)."»' IN BOOLEAN MODE)", con))>0)
					{
						$sqlisbn[] = " MATCH(`Identifier`) AGAINST ('» +".str_replace('-', ' +', $isbnfindname1)."»' IN BOOLEAN MODE) ";
					}
					else
					{
						$sqlisbn[] = " MATCH(`Identifier`) AGAINST ('".str_replace('-', '', $isbnfindname1)."' IN BOOLEAN MODE) ";
					}
				}
				else
				{
					$sqlisbn[] = " MATCH(`Identifier`) AGAINST ('".$isbnfindname1."' IN BOOLEAN MODE) ";
				}
			}
			$sqlisbn = join(' OR ', $sqlisbn);
			$sql     = " (" . $sqlisbn . ")";
		}
		if (!empty($topicfindname[0])) // дописываем условие поиска по ISBN, не зависимо от того задана ли такая колонка
		{
			foreach ($topicfindname[0] as $topicfindname1)
			{
				/*if (in_array($topicfindname1, array(
					'topicid1',
					'topicid12',
					'topicid32',
					'topicid38',
					'topicid41',
					'topicid57',
					'topicid64',
					'topicid69',
					'topicid102',
					'topicid113',
					'topicid147',
					'topicid178',
					'topicid183',
					'topicid189',
					'topicid198',
					'topicid205',
					'topicid210',
					'topicid264',
					'topicid289',
					'topicid296',
					'topicid305',
					'topicid314'
				)))
				{
					$sqltopic[] = "(`topic` = '" . str_replace('topicid', '', $topicfindname1) . "' OR `topic` IN (SELECT `topic_id` FROM `topics` WHERE `topic_id_hl` = '" . str_replace('topicid', '', $topicfindname1) . "' AND `lang` = 'ru'))";
				}
				else
				{*/
					$sqltopic[] = " (`Topic` = '" . str_replace('topicid', '', $topicfindname1) . "' )";
				//}
			}
			$sqltopic = join(' OR ', $sqltopic);
			$sql      = " (" . $sqltopic . ")";
		}
	}
	return ($sql);
}
//echo $req;
//print_r($columns);
//if($mode =='search')
//{
//	$sql = fulltext_search($req, $columns);
//}
echo $htmlhead;
//echo '<table class="lang"><tr><td><a href="setlang.php?lang=ru">[RU]</a></td><td><a href="setlang.php?lang=en">[EN]</a></td></tr></table>';
include_once 'menu_' . $lang . '.html';
if ($mainpage)
{
	$searchbody = "<table cellspacing=0 border=0 width=100% height=100%>
<col width='33%'>
<col width='70%'>		
<tr><caption><a href='/'><font color=#A00000><h1>Library Genesis<sup><font size=4>1M</font></sup></h1></font></a><br>$libgennews
<b>" . $LANG_MESS_31 . "</b></caption>

<td></td><td nowrap>{$form}</td></tr>
</table>";

//<tr><td nowrap valign='middle' align='right'><b><a href='/scimag/index.php'>" . $LANG_MESS_19 . "</a></b></td><td nowrap>{$lg_topic_form}</td></tr>	
//<tr><td nowrap valign='middle' align='right'><b><a href='/comics/index.php'>" . $LANG_MESS_20 . "</a></b></td><td nowrap>{$formcomics}</td></tr>
//<tr><td nowrap valign='middle' align='right'><b><a href='/foreignfiction/index.php'>" . $LANG_MESS_21 . "</a></b></td><td nowrap valign='top'>{$formfiction}</td></tr>
//<tr><td nowrap valign='bottom' align='right'><b><a href='http://magzdb.org/'>" . $LANG_MESS_180 . "</a></b></td><td nowrap valign='top'>{$formmagzdb}</td></tr>



	echo $searchbody;
	echo $footer;
//echo '<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?account=41001819963532&quickpay=small&yamoney-payment-type=on&button-text=04&button-size=m&button-color=orange&targets=Libgen+Donations&default-sum=400&successURL=41001819963532" width="229" height="42"></iframe><br>';
//echo '<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?account=41001819963532&quickpay=small&any-card-payment-type=on&button-text=04&button-size=m&button-color=orange&targets=Libgen+Donations&default-sum=400&successURL=41001819963532" width="229" height="42"></iframe>';
	echo $htmlfoot;
	die;
}
$errurl = 'https://genofond.org/viewtopic.php?f=17&t=6423';
if(isset($_GET)) {$dberr  = $htmlhead . "<font color='#A00000'><h1>Error</h1></font>" . mysql_error() . "<br>Cannot proceed.<p>Please, <a href='{$errurl}'><u>report</u></a> on this error." . $htmlfoot;}

if (isset($_GET['sort']) && in_array($_GET['sort'], array(
	"title",
	"author",
	"publisher",
	"pages",
	"year",
	"filesize",
	"extension",
	"language",
	"id",
	"timelastmodified",
	"timeadded"
)))
{
	$sort = $_GET['sort'];
	if ($sort == 'filesize' || $sort == 'pages')
	{
		//$sort = ' CAST(`'.$sort.'`,UNSIGNED)';
		$sort = $sort.'+0';
	}
}
else
{
	$sort = 'def'; //	
	//$sort = 'id';
}
if (isset($_GET['sortmode']) && in_array($_GET['sortmode'], array(
	"ASC",
	"DESC"
)))
{
	$sortmode1 = $_GET['sortmode'];
	if ($sortmode1 == 'ASC')
		$sortmode2 = 'DESC';
	elseif ($sortmode1 == 'DESC')
		$sortmode2 = 'ASC';
}
else
{
	$sortmode1 = 'ASC';
	$sortmode2 = 'DESC';
}
if ($mode == 'search')
{
	if($sort == 'def')
	{
		//$sort1 = ' `periodical`, `series`, `title`, `year` ';
		//$sort1 = ' `id` ';
		$sort1 = '`title`';	
		$sql_end = "  ORDER BY " . $sort1 . " $sortmode1  LIMIT " . (($page - 1) * $res_on_page) . ", " . $res_on_page; //06052015 убираем сортировку по умолчанию, тк тормозит create sort index
	}
	else
	{
		$sort1 = $sort;	
		$sql_end = " ORDER BY " . $sort1 . " $sortmode1 LIMIT " . (($page - 1) * $res_on_page) . ", " . $res_on_page;
	}

	$sql = fulltext_search($req, $columns,$full_phrase);

	//$sql_end = "  LIMIT " . (($page - 1) * $maxlines) . ", " . $maxlines;
	//$sql_mid = " FROM `".$dbtable."` WHERE ( `Visible`='' AND `Generic` = '' AND ( $sql )) ";
$sql_mid = " FROM `".$dbtable."` WHERE ( `Visible`='' AND ( $sql )) ";
	if ( $timefirst !='')
	{
		$sql_mid .= " AND (`TimeAdded` BETWEEN STR_TO_DATE('" . $timefirst . " 00:00:00','%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('" . $timelast . " 23:59:59','%Y-%m-%d %H:%i:%s') ) ";
	}
	$sql_req = "SELECT SQL_CALC_FOUND_ROWS * " . $sql_mid . $sql_end;

}
elseif ($mode == 'last')
{
	//$where = " ( `Visible`='' AND `Generic` = '' )";
$where = " ( `Visible`='' )";

	if ($timefirst !='')
	{
		$where .= " AND (`TimeAdded` BETWEEN STR_TO_DATE('" . $timefirst . " 00:00:00','%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('" . $timelast . " 23:59:59','%Y-%m-%d %H:%i:%s') ) ";
		if((($page - 1) * $res_on_page) < 50000)
		{
			$sql_req = "SELECT SQL_CALC_FOUND_ROWS * FROM `".$dbtable."` WHERE " . $where . " ORDER BY `ID` DESC LIMIT " . (($page - 1) * $res_on_page) . ", " . $res_on_page;
		}
	}
	else
	{
		$rescount = mysql_query("SHOW TABLE STATUS WHERE `name`='" . $dbtable . "'", $con);
		$rowcount = mysql_fetch_assoc($rescount);
		$where .= " AND `ID` BETWEEN ". ($rowcount['Rows'] - ($page - 1) * $res_on_page - $res_on_page ). " AND " .($rowcount['Rows'] - ($page - 1) * $res_on_page );
		$sql_req = "SELECT * FROM `".$dbtable."` WHERE " . $where . " ORDER BY `ID` DESC";
	}

	

}
elseif ($mode == 'modified')
{
	$where = "(MD5!='') AND (`TimeLastModified`!=`TimeAdded`)";

	if ($timefirst !='')
	{
		$where .= " AND (`TimeLastModified` BETWEEN STR_TO_DATE('" . $timefirst . " 00:00:00','%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('" . $timelast . " 23:59:59','%Y-%m-%d %H:%i:%s') ) ";
	}
	else
	{
		$rescount = mysql_query("SHOW TABLE STATUS WHERE `name`='" . $dbtable . "'", $con);
		$rowcount = mysql_fetch_assoc($rescount);
	}

	if((($page - 1) * $res_on_page) < 50000)
	{
		$sql_req = "SELECT SQL_CALC_FOUND_ROWS * FROM `".$dbtable."` WHERE " . $where . " ORDER BY `TimeLastModified` DESC, ID DESC LIMIT " . (($page - 1) * $res_on_page) . ", " . $res_on_page;

	}
}

//echo $sql_req."<br><br>";
$result = mysql_query($sql_req, $con);
if (!$result)
	die($dberr);

if($mode =='search')
{
	$rescount = mysql_query("SELECT FOUND_ROWS()", $con);
	$cn       = mysql_result($rescount, 0);
}
elseif($mode == 'last')
{
	
	if($timefirst =='')
	{
		$cn = $rowcount['Rows'];
	}
	else
	{
		$rescount = mysql_query("SELECT FOUND_ROWS()", $con);
		$cn       = mysql_result($rescount, 0);	
		if($cn > 50000) 
		{
			$rowcount['Rows'] = $cn;
			$cn = 50000;
		}
	}	
}
elseif($mode == 'modified')
{
		$rescount = mysql_query("SELECT FOUND_ROWS()", $con);
		$cn       = mysql_result($rescount, 0);	
		if($cn > 50000) 
		{
			$rowcount['Rows'] = $cn;
			$cn = 50000;
		}	
}


if ($mode == 'search')
{

	$args = "search.php?$resreq$openreq&req=$req_htm_enc&phrase=$full_phrase&view=$view";
	//foreach ($columns as $col)
	//{
		$args .= "&column=$columns";
	//}
}
else
{
	$args = "search.php?mode=$mode&view=$view&phrase=$full_phrase$resreq&timefirst=$timefirst&timelast=$timelast";
}
$pages = ceil($cn / $res_on_page);

$start = ($page - 1) * $res_on_page;
$end   = $start + $res_on_page;
$i     = 0;
$links = "";
if (!$mainpage)
{
//	echo "<table width=100% border=0><tr><td>$form</td><td><a href='/'><font color=#A00000 valign=top align=right><h1>Library Genesis<sup><font size=4>1M</font></a></td></tr></table>";

	echo "<table width=100% border=0><tr><td>$form</td><td><h1 style=\"color:#A00000\"><a href=\"/\">Library Genesis<sup style=\"font-size:65%\">1M</sup></h1></a><br/></td></tr></table>";

}
$arrowleft  = '<font size="3" color="gray"><a href="' . $args . '&sort=' . $sort . '&sortmode=' . $sortmode1 . '&page=' . ($page - 1) . '">&#9668;&nbsp;&nbsp;</a></font>';
$arrowright = '<font size="3" color="gray"><a href="' . $args . '&sort=' . $sort . '&sortmode=' . $sortmode1 . '&page=' . ($page + 1) . '">&nbsp;&nbsp;&#9658;</a></font>';
if ($pages > 1)
{
	echo '<div style="text-align: center; float: left;" class="paginator" id="paginator_example_top"></div>
<script type="text/javascript">
    paginator_example_top = new Paginator(
        "paginator_example_top", // id контейнера, куда ляжет пагинатор
        ' . $pages . ', // общее число страниц
        ' . $maxlines . ', // число страниц, видимых одновременно
        ' . $page . ', // номер текущей страницы
        "' . $args . '&sort=' . $sort . '&sortmode=' . $sortmode1 . '&page=" // url страниц
    );
</script>
';
}
$color1     = '#C0C0C0';
$color2     = '#C6DEFF';
$color3     = '#000000';
$req_htmadd = str_replace(' ', '+', $req_htm);
$reshead    = "<table width=100% cellspacing=1 cellpadding=1 rules=rows class=c align=center>";
if ($mode == 'search')
{
	echo "<table width=100%><tr><td align='left' width=45%><font size=2>" . $cn . " " . $LANG_MESS_22 . " </font></td><td align=center width=10%>";
	if ($page > 1 && $pages > 1)
	{
		echo $arrowleft;
	}
	if ($page < $pages && $pages > 1)
	{
		echo $arrowright;
	}
	
	if($lang!='en')
	{
		$smsearch = "<a href='/scimag/index.php?s=$req_htmadd'>" . $LANG_MESS_19 . "</a>, ";
	}
	else
	{
		$smsearch = '';
	}

	echo "</td><td align='right' width=45%><font size=2>" . $LANG_MESS_22_5 . "\"$req_htm\" " . $LANG_MESS_23 . " ".$smsearch." <a href='/foreignfiction/index.php?s=$req_htm&f_cols=Author:Title:Series&f_lang=0&page=1'>" . $LANG_MESS_21 . "</a>, <a href='/comics/index.php?s=$req_htmadd'>" . $LANG_MESS_20 . "</a></font></td></tr></table>";
	if ($view !== 'detailed')
	{
		$tabheader = "<tr valign=top bgcolor=$color1>
<td><b><a title='" . $LANG_MESS_32_5 . "' href='" . $args . "&sort=id&sortmode=" . $sortmode2 . "'>ID</a></b></td>
<td><b><a title='" . $LANG_MESS_32 . "' href='" . $args . "&sort=author&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_6 . "</a></b></td>
<td><b><a title='" . $LANG_MESS_33 . "' href='" . $args . "&sort=title&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_5 . "</a></b></td>
<td><b><a title='" . $LANG_MESS_34 . "' href='" . $args . "&sort=publisher&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_9 . "</a></b></td>
<td><b><a title='" . $LANG_MESS_35 . "' href='" . $args . "&sort=year&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_10 . "</a></b></td>
<td><b><a title='" . $LANG_MESS_36 . "' href='" . $args . "&sort=pages&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_28 . "</a></b></td>
<td><b><a title='" . $LANG_MESS_37 . "' href='" . $args . "&sort=language&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_11 . "</a></b></td>
<td><b><a title='" . $LANG_MESS_38 . "' href='" . $args . "&sort=filesize&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_26 . "</a></b></td>
<td><b><a title='" . $LANG_MESS_39 . "' href='" . $args . "&sort=extension&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_12 . "</a></b></td>
<td colspan=4><b>" . $LANG_MESS_29 . "</b></td>
<td><b>" . $LANG_MESS_30 . "</b></td></tr>";
	}
	else
	{
		$tabheader = "<font size=2> ".$LANG_MESS_329.": 
<a title='" . $LANG_MESS_32_5 . "' href='" . $args . "&sort=id&sortmode=" . $sortmode2 . "'>ID</a>, 
<a title='" . $LANG_MESS_33 . "' href='" . $args . "&sort=title&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_5 . "</a>, 
<a title='" . $LANG_MESS_34 . "' href='" . $args . "&sort=publisher&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_9 . "</a>,
<a title='" . $LANG_MESS_35 . "' href='" . $args . "&sort=year&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_10 . "</a>,
<a title='" . $LANG_MESS_36 . "' href='" . $args . "&sort=pages&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_28 . "</a>,
<a title='" . $LANG_MESS_37 . "' href='" . $args . "&sort=language&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_11 . "</a>,
<a title='" . $LANG_MESS_38 . "' href='" . $args . "&sort=filesize&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_26 . "</a>,
<a title='" . $LANG_MESS_39 . "' href='" . $args . "&sort=extension&sortmode=" . $sortmode2 . "'>" . $LANG_MESS_12 . "</a>
";
	}
}
elseif($mode == 'last' || $mode == 'modified')
{
	echo "<table width=100%><tr>";


	if($mode == 'last')
	{
		
		if($timefirst =='')
		{
			echo "<td align='left' width=45%><font size=2>" . $cn . " " . $LANG_MESS_22 . "</td><td align='left' width=10%>";
		}
		else
		{	
			if($cn == 50000) 
			{
				echo "<td align='left' width=45%><font size=2>" . $rowcount['Rows'] . " " . $LANG_MESS_22 . ", ".$LANG_MESS_199."50000</td><td align='left' width=10%>";
			}
			else
			{
				echo "<td align='left' width=45%><font size=2>" . $cn . " " . $LANG_MESS_22 . "</td><td align='left' width=10%>";				
			}
		}	
	}
	elseif($mode == 'modified')
	{
		if($cn == 50000) 
		{
			echo "<td align='left' width=45%><font size=2>" . $rowcount['Rows'] . " " . $LANG_MESS_22 . ", ".$LANG_MESS_199."50000</td><td align='left' width=10%>";
		}
		else
		{
			echo "<td align='left' width=45%><font size=2>" . $cn . " " . $LANG_MESS_22 . "</td><td align='left' width=10%>";				
		}
	}


	if ($page > 1 && $pages > 1)
	{
		echo $arrowleft;
	}
	if ($page < $pages && $pages > 1)
	{
		echo $arrowright;
	}
	echo "</td><td width=45%></td></tr></table>";
	$tabheader = "<tr valign=top bgcolor=$color1><td><b>ID</b></td><td><b>" . $LANG_MESS_6 . "</b></td><td><b>" . $LANG_MESS_5 . "</b></td><td><b>" . $LANG_MESS_9 . "</b></td><td><b>" . $LANG_MESS_10 . "</b></td><td><b>" . $LANG_MESS_28 . "</b></td><td><b>" . $LANG_MESS_11 . "</b></td><td><b>" . $LANG_MESS_26 . "</b></td><td><b>" . $LANG_MESS_12 . "</b></td><td colspan=4><b>" . $LANG_MESS_29 . "</b></td><td><b>" . $LANG_MESS_30 . "</b></td></tr>";
}
echo $reshead;
echo $tabheader;
while ($row = mysql_fetch_assoc($result))
{
	include 'mirrors.php';
	//if ($i >= (($page - 1) * $maxlines) and ($i < $page * $maxlines))
	if ($i >= 0 and $i < $res_on_page)
	{

		$title    = htmlspecialchars($row['Title']);
		$author   = htmlspecialchars($row['Author']);
		//авторы ссылки
		if (preg_match('| and |iU', $author))
		{
			$delemiter = ' and ';
		}
		elseif (preg_match('| и |', $author))
		{
			$delemiter = ';';
		}
		elseif (preg_match('|;|', $author))
		{
			$delemiter = ';';
		}
		elseif (preg_match('|&|', $author))
		{
			$delemiter = '&';
		}
		elseif (preg_match('|,|', $author))
		{
			$delemiter = ',';
		}
		if (isset($delemiter))
		{
			$autharray = explode($delemiter, $author);
			foreach ($autharray as $autharrayvalue)
			{
				if (in_array(trim($autharrayvalue), array(
					'и др',
					'и др.',
					'et al',
					'et al.'
				)))
				{
					$authresult[] = $autharrayvalue;
				}
				else
				{
					$authresult[] = "<a href='search.php?req=" . strtr($autharrayvalue, array(
						' авт.',
						'(авт)',
						'(авт.)',
						' ред.',
						'(ред)',
						' сост.',
						' и др.',
						' и др',
						' et al.',
						' et al',
						'(ред.)',
						' ed.',
						'(eds)',
						' eds.',
						'(eds.)'
					)) . "&column=author'>" . $autharrayvalue . "</a>";
				}
			}
			$author = implode($delemiter, $authresult);
			unset($authresult);
		}
		else
		{
			$author = "<a href='search.php?req=" . $author . "&column[]=author'>" . $author . "</a>";
		}
		$vol        = htmlspecialchars($row['VolumeInfo']);
		$publisher  = htmlspecialchars($row['Publisher']);
		$year       = htmlspecialchars($row['Year']);
		$pagesbook  = htmlspecialchars($row['Pages']);
		$periodical = htmlspecialchars($row['Periodical']);
		$series     = htmlspecialchars($row['Series']);
		$lang       = htmlspecialchars($row['Language']);
		$ident1     = trim(htmlspecialchars($row['Identifier']), ',- ');
		$edition    = htmlspecialchars($row['Edition']);
		$ext        = htmlspecialchars($row['Extension']);
		$timeadd    = htmlspecialchars($row['TimeAdded']);
		$timelm     = htmlspecialchars($row['TimeLastModified']);
		$city       = htmlspecialchars($row['City']);
		$ident      = str_replace(",", ", ", $ident1);
		$coverurl   = htmlspecialchars($row['Coverurl']);
		if ($coverurl == '')
			$coverurl = 'blank.png';
		$size = $row['Filesize'];
		if ($size >= 1024 * 1024 * 1024)
		{
			$size = round($size / 1024 / 1024 / 1024);
			$size = $size . ' ' . $LANG_MESS_GB;
		}
		else if ($size >= 1024 * 1024)
		{
			$size = round($size / 1024 / 1024);
			$size = $size . ' ' . $LANG_MESS_MB;
		}
		else if ($size >= 1024)
		{
			$size = round($size / 1024);
			$size = $size . ' ' . $LANG_MESS_KB;
		}
		else
			$size = $size . ' ' . $LANG_MESS_B;
		if ($view != 'detailed')
		{
			$bookname = '';
			if ($series <> '')
			{
				$bookname = "<font face=Times color=green><i>$series </i><br></font>";
			}
			$bookname1 = '';
			if ($periodical <> '')
			{
				$bookname1 = "<font face=Times color=grey><i>$periodical </i><br></font>";
			}
			$bookname = $bookname1 . $bookname . $title;
			$volinf   = $ident;
			if ($volinf)
			{
				if ($ident)
					$volinf = $ident;
			}
			else
			{
				if ($ident)
					$volinf = '' . $ident;
			}
			if ($i % 2)
				$color = "";
			else
				$color = $color2;
			$vol_ed = $vol;

			if (!preg_match('~(ED|Ed|ed|ИЗД|Изд|изд|Aufl|aufl|AUFL)~', $edition))
			{
				if ($lang == 'Russian')
					$ed = ' ' . $str_edition_ru;
				else
					$ed = ' ' . $str_edition_en;
			}else{$ed = '';}



			if ($vol_ed)
			{
				if ($edition)
					$vol_ed = $vol_ed . ', ' . $edition . $ed;
			}
			else
			{
				if ($edition)
					$vol_ed = $edition . $ed;
			}
			$volume = '';
			if ($vol_ed)
				$volume = " <font face=Times color=green><i>[$vol_ed]</i></font>";
			$volstamp = '';
			if ($volinf)
				$volstamp = "<br> <font face=Times color=green><i>$volinf</i></font>";
			$ires  = ($start++) + 1;
			$tip0  = "";

			if ($mode !== 'search')
			{
				$ires = $row['ID'];
			}
			else
			{
				$ires = /*$ires. ' ' .*/$row['ID'];
			}

		
			$line = "<tr valign=top bgcolor=$color><td>$ires</td>
				<td>$author</td>
				<td width=500><a href='book/index.php?md5=$row[MD5]$openreq' title='$tip0' id=$ires>{$bookname}$volume$volstamp</a></td>
				<td>$publisher</td>
				<td nowrap>$year</td>
				<td>$pagesbook</td>
				<td nowrap>$lang</td>
				<td nowrap>$size</td>
				<td nowrap>$ext</td>
		
		
		            
				<td><a href='".$mirror_0_link."' title='".$mirror_1_tooltip."'>[1]</a></td>
				<td><a href='".$mirror_2_link."' title='".$mirror_2_tooltip."'>[2]</a></td>
				<td><a href='".$mirror_4_link."' title='".$mirror_4_tooltip."'>[3]</a></td>
				<td><a href='".$mirror_3_link."' title='".$mirror_3_tooltip."'>[4]</a></td>
				<td><a href='".$mirror_edit_link."' title='".$mirror_edit_tooltip."'>[edit]</a></td>
				</tr>\n\n";
		}
		else
		{
			$line = '<table border="0" rules="cols" width="100%">
<col width=20%><col width=100><col width=300><col width=100><col width=300>
<tbody><tr height="2" valign="top"><td bgcolor="brown" colspan="5"></td></tr>
<tr valign="top">
<td rowspan="20" width="150"><a href="/get?' . $resreq . $openreq . '&md5=' . $row['MD5'] . '"><img src="/covers/' . $coverurl . '" border="0" width="240" style="padding: 5px" alt="Download"></a></td>
<td><font color="gray">' . $LANG_MESS_5 . '</font></td>
<td colspan="2"><b><a href="../book/index.php?md5=' . $row['MD5'] . $openreq . '">' . $title . '</a></b></td>
<td><font color="gray">' . $LANG_MESS_42 . ':</font></td>
</tr>
<tr valign="top">
<td><font color="gray">' . $LANG_MESS_6 . ':</font></td>
<td colspan="3"><b>' . $author . '</b></td>
</tr>
<tr valign="top">
<td><font color="gray">' . $LANG_MESS_7 . ':</font></td>
<td>' . $series . '</td>
<td><font color="gray">' . $LANG_MESS_8 . ':</font></td>
<td>' . $periodical . '</td>
</tr>
<tr valign="top">
<td><font color="gray">' . $LANG_MESS_9 . ':</font></td>
<td>' . $publisher . '</td>
<td><font color="gray">' . $LANG_MESS_93 . ':</font></td>
<td>' . $city . '</td>
</tr>
<tr valign="top">
<td><font color="gray">' . $LANG_MESS_10 . ':</font></td>
<td>' . $year . '</td>
<td><font color="gray">' . $LANG_MESS_43 . ':</font></td>
<td>' . $edition . '</td>
</tr>
<tr valign="top">
<td><font color="gray">' . $LANG_MESS_11 . ':</font></td>
<td>' . $lang . '</td>
<td><font color="gray">' . $LANG_MESS_28 . ':</font></td>
<td>' . $pagesbook . '</td>
</tr>
<tr valign="top">
<td><font color="gray">ISBN:</font></td>
<td>' . $ident . '</td>
<td><font color="gray">ID:</font></td>
<td>' . $row['ID'] . '</td>
</tr>
<tr valign="top">
<td><font color="gray">' . $LANG_MESS_44 . ':</font></td>
<td>' . $timeadd . '</td>
<td><font color="gray">' . $LANG_MESS_45 . ':</font></td>
<td>' . $timelm . '</td>
</tr>
<tr valign="top">
<td><font color="gray">' . $LANG_MESS_26 . ':</font></td>
<td>' . $size . ' (' . $row['Filesize'] . ')</td>
<td><font color="gray">' . $LANG_MESS_12 . ':</font></td>
<td>' . $ext . '</td>
</tr>
<tr valign="top">
<td><font color="gray">BibTeX</font></td>
<td><a href="/book/bibtex.php?md5=' . $row['MD5'] . '"><b>Link</b></a></td>
<td><font color="gray">' . $LANG_MESS_54 . ':</font></td>
<td><b><a href="'.$mirror_edit_link.'">'.$mirror_edit_title.'</a></b></td>
</tr>
<tr valign="top">
<td><font color="gray">' . $LANG_MESS_13 . ':</font></td>
<td colspan="3"></td>
</tr>

<tr valign="top">
<td><font color="gray">' . $LANG_MESS_53 . ':</font></td>
<td colspan="3"><table border="0" rules="cols" width="100%">
<tbody><tr>
<td align="center" width="11,1%"><a href="'.$mirror_1_link.'">'.$mirror_1_title.'</a></td>
<td align="center" width="11,1%"><a href="'.$mirror_2_link.'">'.$mirror_2_title.'</a></td>
<td align="center" width="11,1%"><a href="'.$mirror_3_link.'">'.$mirror_3_title.'</a></td>
<td align="center" width="11,1%"><a href="'.$mirror_4_link.'">'.$mirror_4_title.'</a></td>
<td align="center" width="11,1%"><a href="'.$mirror_5_link.'">'.$mirror_5_title.'</a></td>
<td align="center" width="11,1%"><a href="'.$mirror_6_link.'">'.$mirror_6_title.'</a></td>
<td align="center" width="11,1%"><a href="'.$mirror_e2k_link.'">'.$mirror_e2k_title.'</a></td>
<td align="center" width="11,1%"><a href="'.$mirror_magnet_link.'">'.$mirror_magnet_title.'</a></td>
<td align="center" width="11,1%"><a href="'.$mirror_torrent_link.'">'.$mirror_torrent_title.'</a></td>
</tr>
</tbody></table></td>
</tr>
</tbody></table>';
		}
		echo $line;
	}
	$i++;
}
echo $footer;
if ($pages > 1)
{
	echo '<div style="text-align: center;" class="paginator" id="paginator_example_bottom"></div>
<script type="text/javascript">
    paginator_example_bottom = new Paginator(
        "paginator_example_bottom", // id контейнера, куда ляжет пагинатор
        ' . $pages . ', // общее число страниц
         ' . $maxlines . ', // число страниц, видимых одновременно
        ' . $page . ', // номер текущей страницы
        "' . $args . '&sort=' . $sort . '&sortmode=' . $sortmode1 . '&page=" // url страниц
    );
</script>
';
}
else
{
	echo "<hr size=5 color=gray>";
}
echo "<table width=100%><tr><td align='left' width=45%></td><td align=center width=10%>";
if ($page > 1 && $pages > 1)
{
	echo $arrowleft;
}
if ($page < $pages && $pages > 1)
{
	echo $arrowright;
}
echo "</td><td align='right' width=45%></td></tr></table>";
echo $htmlfoot;
mysql_free_result($result);
mysql_close($con);

?>

