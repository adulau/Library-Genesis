<?php
include 'html.php';

// if MD5 provided, go straight to the editor form
if (isset($_GET['md5']) && $_GET['md5'] != ''){
	$_POST['MD5'] = $_GET['md5'];
	$_POST['Form'] = 2;
	include 'form.php';
	exit(0);
}

$page = "<center><table border=1 cellspacing=0 cellpadding=12 bordercolor='#A00000'>
<caption><font color='#A00000'><h1>Library Genesis</h1></font></caption>

<!-- File-Upload Form -->
<tr><td><form enctype='multipart/form-data' action='form.php' method='POST'>
<input type='hidden' name='MAX_FILE_SIZE' value='200000000'/>
<input type='hidden' name='Form' value='1'/>
<input type='hidden' name='MD5' value=''/>
Choose file to upload (200 Mb max, if possible no *.rar *.zip) \\ Выберите файл для загрузки (макс. 200 Мб, если возможно без *.rar, *.zip):<br>
<input name='uploadedfile' type='file' size=120/> 
<input type='submit' value='Send!'/><br>
<font face=Arial color=gray size=1>Calculates MD5 upon completion \\ Рассчитывает MD5 после завершения загрузки</font></td></tr>
</form>

<!-- MD5-check-up Form -->
<tr><td><form enctype='multipart/form-data' action='form.php' method='POST'>
<input type='hidden' name='Form' value='2'/>
Enter MD5 to look for \\ Ввведите MD5 для просмотра записи в  БД:<br><input name='MD5' id='1' type='text' size=125 maxlength=32/> <input type='submit' value='Check MD5!'/>
<br><font face=Arial color=gray size=1>Helps avoid a tedious upload, if the book is already in the database \\ Помогает избежать нагрузки если книга есть в БД</font></td></tr>

</form>
</table></center>";

echo $htmlheadfocus;
echo $page;
echo $htmlfoot;

?>
