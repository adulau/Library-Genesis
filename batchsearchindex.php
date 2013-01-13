<?php

$htmlheadbegin = "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
<html><head><title>Library Genesis</title>
<META HTTP-EQUIV='CACHE-CONTROL' CONTENT='NO-CACHE'>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
";
$htmlheadend = "</head><body>";
$script = "<script type='text/javascript'>
function f() {document.getElementById('1').focus();}
window.onload = f;
</script>";

$htmlhead = $htmlheadbegin.$htmlheadend;
$htmlheadfocus = $htmlheadbegin.$script.$htmlheadend;
$htmlfoot = "</body></html>";




$page = "
<center><table width = 1000 border=1 cellspacing=0 cellpadding=12 bordercolor='#A00000'>
<caption><font color='#A00000'><h1>Batch search for books Library Genesis</h1></font><br></caption>
<!-- File-DL from remote server Form -->
<tr><td>
<FORM name='filenames' enctype='multipart/form-data' METHOD='POST' ACTION='batchsearch.php'>
<table  cellspacing=0 border=0 width=100% height=100%>
<col width='50%'>
<col width='50%'>

<tr><td nowrap valign='middle' align='right'>Убрать из строки слова короче или равные N буквам:</td><td nowrap><select name='wordminlength' size='1'>
<option value='0'>0</option>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
<option value='6'>6</option>
<option value='7'>7</option>
<option value='8'>8</option>
<option value='9'>9</option>
</select>Remove from the string words shorter than or equal to N letter</td></tr>

<tr><td nowrap valign='middle' align='right'>Убрать слова в скобках ()[]{}: </td><td nowrap><input name='skobki'  VALUE='1' type='checkbox' />Remove the words in brackets ()[]{}</td></tr>
<tr><td nowrap valign='middle' align='right'>Удалить расширение (все что после последней точки): </td><td nowrap><input name='raschirenie'  VALUE='1' type='checkbox' />Remove extension (everything after the last dot)</td></tr>
<tr><td nowrap valign='middle' align='right'>Транслитерировать (LAT-RUS, kolxo3): </td><td nowrap><input name='translit'  VALUE='1' type='checkbox' />Transliterate (LAT-RUS, kolxo3)</td></tr>
<tr><td nowrap valign='middle' align='right'>Искать только MD5 хеш (по 1 MD5 в строке): </td><td nowrap><input name='md5hash'  VALUE='1' type='checkbox' />Search only MD5 hash (to one MD5 in string)</td></tr>
<tr><td nowrap valign='middle' align='right'>Искать только ISBN (по 1 ISBN в строке): </td><td nowrap><input name='isbn'  VALUE='1' type='checkbox' />Search only ISBN (to one ISBN in string)</td></tr>

<tr><td nowrap valign='middle' align='right'>Убрать из строки слова (перечислить через ',' (максимум 100 знаков))  <br>Remove words from a string (list through ',' (maximum 100 characters)) :</td><td nowrap><input name='stopwords' type='text' size=80 maxlength=100/></td></tr>
<tr><td valign='middle' align='left' colspan=2>Введите строки (максимум 500) \ Enter string (max 500):</td></tr>
</table>
<div><textarea id='teTestCode' name='dsk' rows='19' cols='120'></textarea>
<br>Пунктуация удаляется, все переводится в нижний регистр, поиск по полям: Заглавие, Автор, Серия, Издательство, Год, Журнал, Том<br>
Punctuation is removed, all translated to lower case, search the following fields: Title, Author, Series, Publisher, Year, Magazine, Volume</div>
<div><INPUT TYPE='submit' name='submit' value='Искать'></div>



</FORM>
</td></tr>
</table>
</center>";



echo $htmlheadfocus;
echo $page;
echo $htmlfoot;

?>
