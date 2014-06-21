<?php
	include 'connect.php';
	include 'html.php';
	// form 1 (new record) and 2 (editing) defaults
	$author = '';
	$generic = '';
	$topic = '';
	$volinfo = '';
	$year = '';
	$publisher = '';
        $city = '';
	$edition = '';
        $series = '';
        $periodical = '';
	$pages = '';
	$identifier = '';
	$language = '';
	$library = '';
	$issue = '';
	$orientation = '';
	$dpi = '';
	$color = '';
	$cleaned = '';
	$commentary = '';
	$coverurl = '';
	$udc = '';
	$lbc = '';
	$bookcode = '';
    
	// form 1 or 2 submitted?
	if ($_POST['Form'] == 1) //new record
	{
		if (trim($_FILES['uploadedfile']['name']) == '')
			die($htmlhead."<font color='#A00000'><h1>No file selected</h1></font>Use 'Browse...' to choose a file on your computer, then 'Send!' to upload it.<br><a href='registration.php'>Return to the last page</a> and try again!".$htmlfoot);

		$pi = pathinfo($_FILES['uploadedfile']['name']);

		$md5 = md5_file($_FILES['uploadedfile']['tmp_name']);

		$title = htmlspecialchars($pi['filename'],ENT_QUOTES);
		$filesize = $_FILES['uploadedfile']['size'];
		@$fileext = strtolower($pi['extension']);

		if (is_null($fileext))
			die($htmlhead."<font color='#A00000'><h1>Error</h1></font>Cannot upload a file with no extension. Assign one and try again!".$htmlfoot);
	}
	elseif ($_POST['Form'] == 2) //edit record
	{
		if (strlen($_POST['MD5']) != 32)
			die($htmlhead."<font color='#A00000'><h1>Wrong MD5</h1></font>MD5-hashsum must contain 32 symbols.<br>Check it and <a href='registration.php'>try again</a>.<p><h2>Thank you!</h2>".$htmlfoot);

		$md5 = $_POST['MD5'];

		$title = '';
		$filesize = 0;
		$fileext = '';
	}
    else
    {
      die($htmlhead."<font color='#A00000'><h1>Internal error</h1></font>The server experiecned an internal error. Try again.<p><h2>Thank you!</h2>".$htmlfoot);
    }

	// now look up in the database
	$sql="SELECT DISTINCT $db.$dbtable.*, $db.$descrtable.descr 
          FROM $db.$dbtable LEFT JOIN $db.$descrtable ON $db.$dbtable.md5 = $db.$descrtable.md5
          WHERE $db.$dbtable.MD5='$md5'";
	$result = mysql_query($sql,$con);
	if (!$result)
	{
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font>".mysql_error()."<br>Cannot proceed.<p>Please, report the error from <a href=>the main page</a>.".$htmlfoot);
	}

	$rows = mysql_fetch_assoc($result);
	mysql_close($con);

	// if book found
	if (strlen($rows['MD5']) == 32){
		$editing = true;
		$mode = "<font color=red><h1>Editing existing record</h1></font>";

		// replace all single-quotes, they work as delimiters in HTML and SQL

		$generic = htmlspecialchars($rows['Generic'],ENT_QUOTES);
		$title = htmlspecialchars($rows['Title'],ENT_QUOTES);
		$filesize = $rows['Filesize'];
		$fileext = $rows['Extension'];
		$author = htmlspecialchars($rows['Author'],ENT_QUOTES);
		$topic = htmlspecialchars($rows['Topic'],ENT_QUOTES);
		$volinfo = htmlspecialchars($rows['VolumeInfo'],ENT_QUOTES);
		$year = $rows['Year'];
		$publisher = htmlspecialchars($rows['Publisher'],ENT_QUOTES);
        $city = htmlspecialchars($rows['City'],ENT_QUOTES);
		$edition = htmlspecialchars($rows['Edition'],ENT_QUOTES);
		$pages = htmlspecialchars($rows['Pages'],ENT_QUOTES);
		$identifier = htmlspecialchars($rows['Identifier'],ENT_QUOTES);
		$language = htmlspecialchars($rows['Language'],ENT_QUOTES);
		$library = htmlspecialchars($rows['Library'],ENT_QUOTES);
		$issue = htmlspecialchars($rows['Issue'],ENT_QUOTES);
		$orientation = htmlspecialchars($rows['Orientation'],ENT_QUOTES);
		$dpi = $rows['DPI'];
		$color = htmlspecialchars($rows['Color'],ENT_QUOTES);
		$cleaned = htmlspecialchars($rows['Cleaned'],ENT_QUOTES);
		$commentary = htmlspecialchars($rows['Commentary'],ENT_QUOTES);
		$series = htmlspecialchars($rows['Series'],ENT_QUOTES);
        $periodical = htmlspecialchars($rows['Periodical'],ENT_QUOTES);
        $coverurl = htmlspecialchars($rows['Coverurl'],ENT_QUOTES);
		$udc = htmlspecialchars($rows['UDC'],ENT_QUOTES);
		$lbc = htmlspecialchars($rows['LBC'],ENT_QUOTES);
		$bookcode = htmlspecialchars($rows['BooksellingCode'],ENT_QUOTES);
		$description = htmlspecialchars($rows['descr'],ENT_QUOTES);
	} else {
		$editing = false;
		$mode = "<font color=green><h1>Registering a new book \\ Регистрация новой книги</h1></font>";
	}
    
	if(isset($_POST['amazon'])){
       
        $filesize = $_GET['filesize'];
        $fileext = $_GET['fileext'];
       
        $number = htmlspecialchars($_POST['isbn'],ENT_QUOTES);
        
        if(strlen($number)!=10){
            
        require_once 'ISBN-0.1.6/ISBN.php';
        $number = ISBN::convert($number, ISBN::validate($number), ISBN_VERSION_ISBN_10);
            
        }
        
        $isbn = $number;
        
        include 'amazonRequest.php';
        $amazonInfo = amazonInfo($isbn, $public_key, $private_key);
        $amazonError = $amazonInfo['error'];
        if($amazonError==''){
           
            $title = htmlspecialchars($amazonInfo['Title'],ENT_QUOTES);
            $author = htmlspecialchars($amazonInfo['Author'],ENT_QUOTES);
            $year = htmlspecialchars($amazonInfo['Year'],ENT_QUOTES);
            $publisher = htmlspecialchars($amazonInfo['Publisher'],ENT_QUOTES);
            $edition = htmlspecialchars($amazonInfo['Edition'],ENT_QUOTES);
            $pages = htmlspecialchars($amazonInfo['Pages'],ENT_QUOTES);
            $identifier = 'ISBN '.htmlspecialchars($amazonInfo['ISBN'],ENT_QUOTES);
            $language = htmlspecialchars($amazonInfo['Language'],ENT_QUOTES);
            //$commentary = htmlspecialchars($amazonInfo['Content'],ENT_QUOTES); 
            $description = htmlspecialchars($amazonInfo['Content'],ENT_QUOTES); 
            $coverurl = htmlspecialchars($amazonInfo['Image'],ENT_QUOTES);
        }   
    }

    if(isset($_POST['ozon'])){
        
        
        $filesize = $_GET['filesize'];
        $fileext = $_GET['fileext'];
        
        $number = htmlspecialchars($_POST['isbn'],ENT_QUOTES);
        
        if( !(substr_count(trim($number),'-') == 3)&&(strlen(trim($number))==13) || !(substr_count(trim($number),'-') == 4)&&(strlen(trim($number))==17)){
            
            require_once 'ISBN-0.1.6/ISBN.php';
            $isbn = new ISBN($number);
            $number = substr($isbn->getISBNDisplayable(),9);
            
        }
       
        $isbn = $number;
        
        include 'ozonRequest.php';
        $ozonError = $ozonInfo['error'];
        if($ozonError==''){
           
            $title = htmlspecialchars($ozonInfo['Title'],ENT_QUOTES);
            $author = htmlspecialchars($ozonInfo['Author'],ENT_QUOTES);
            $publisher = htmlspecialchars($ozonInfo['Publisher'],ENT_QUOTES);
            $year = htmlspecialchars($ozonInfo['Year'],ENT_QUOTES);
            $pages = htmlspecialchars($ozonInfo['Pages'],ENT_QUOTES);
            $identifier = 'ISBN '.$isbn;
            //$commentary = htmlspecialchars($ozonInfo['Content'],ENT_QUOTES);
            $description = htmlspecialchars($ozonInfo['Content'],ENT_QUOTES);
            $topic = htmlspecialchars($ozonInfo['Topic'],ENT_QUOTES); 
            $coverurl = htmlspecialchars($ozonInfo['Image'], ENT_QUOTES);
            $coverurl = str_replace("/small", "", $image);
            $coverurl = str_replace(".gif", ".jpg", $image);    
        }   
    }
    
    //RGB
    if(isset($_POST['rgb'])){
        
        
        $filesize = $_GET['filesize'];
        $fileext = $_GET['fileext'];
        
        $number = htmlspecialchars($_POST['isbn']);
        
        if( !(substr_count(trim($number),'-') == 3)&&(strlen(trim($number))==13) || !(substr_count(trim($number),'-') == 4)&&(strlen(trim($number))==17)){
            
            require_once 'ISBN-0.1.6/ISBN.php';
            $isbn = new ISBN($number);
            $number = substr($isbn->getISBNDisplayable(),9);
            
        }
       
        $isbn = $number;
        
        include 'rgbRequest.php';
        
    }
    
    $isbnForm = "<form action='registration.php?md5=".$md5."&filesize=".$filesize."&fileext=".$fileext."' method='post' >
ISBN: <input type='text' name='isbn' size='20' maxlength='25' value='".htmlspecialchars($_POST['isbn'],ENT_QUOTES)."' />
search in: 
<input type='submit' value='Info from Amazon' name='amazon'/>
<input type='submit' value='Info from Ozon' name='ozon'/>
<input type='submit' value='Info from RSL' name='rgb'/>
\t".$amazonError.$ozonError.$rgbError."</form>";
   
    $regform = $htmlheadfocus.$isbnForm."<form action='register.php' method='post'>
<table width=100% border=0 cellspacing=0>
<caption>".$mode."</caption>
<tr><td width=52%><font face=arial size=3><b><a href='http://free-books.dontexist.com/librarian/Topic.txt'>Topics \\ Тематика</b> <font size=2 color=gray>(разделитель '/')</font></font><td><input type='text' name='Topic' id='1' size=90 value='".$topic."' maxlength=500/>
<tr><td><font face=arial size=3><b>Authors \\ Авторы</b> <font size=2 color=gray>(Формат: Иванов А.А., Петров В.В., ...)</font></font><td><input type='text' name='Author' size=90 value='".$author."' maxlength=1000/>
<tr><td><font face=arial size=3><b>Title \\ Заголовок</b></font><td><input type='text' name='Title' size=90 value='".$title."' maxlength=500/>
<tr><td><font face=arial size=3><b>Volume \\ Том</b> <font size=2 color=gray>(part 1, issue 3-6, глава A, ...)</font></font><td><input type='text' name='VolumeInfo' size=90 value='".$volinfo."' maxlength=500/>
<tr><td><font face=arial size=3><b>Year of Issue \\ Год издания</b></font><td><input type='text' name='Year' size=10 value='".$year."' maxlength=10/>
<tr><td><font face=arial size=3><b>Edition \\ Издание</b></font><td><input type='text' name='Edition' size=10 value='".$edition."' maxlength=50/>
<tr><td><font face=arial size=3><b>Series \\ Серия</b> <font size=2 color=gray>(вместе с порядковым № в серии)</font></font><td><input type='text' name='Series' size=90 value='".$series."' maxlength=300/>
<tr><td><font face=arial size=3><b>Periodical \\ Журналы</b> <font size=2 color=gray>(вместе с №, напр. Левша 2009-06)</font></font><td><input type='text' name='Periodical' size=90 value='".$periodical."' maxlength=300/>
<tr><td><font face=arial size=3><b><a href='http://free-books.dontexist.com/librarian/publisher.txt'>Publisher \\ Издательство</b></font><td><input type='text' name='Publisher' size=90 value='".$publisher."' maxlength=200/>
<tr><td><font face=arial size=3><b>City \\ Город</b></font><td><input type='text' name='City' size=90 value='".$city."' maxlength=200/>
<tr><td><font face=arial size=3><b>Number of Pages \\ Число страниц</b></font><td><input type='text' name='Pages' size=5 value='".$pages."' maxlength=10/>
<tr><td><font face=arial size=3><b><a href='http://free-books.dontexist.com/librarian/lang.txt'>Language</b> <font size=2 color=gray>(Russian, English, ...)</font></font><td><input type='text' name='Language' size=90 value='".$language."' maxlength=50/>
<tr><td><font face=arial size=3><b>ISBN</b> <font size=2 color=gray>(напр.:ISBN10:0-0000-0000-0;ISBN13:978-0-0000 0000-0)</font></font><td><input type='text' name='Identifier' size=20 value='".$identifier."' maxlength=100/>
<tr><td><font face=arial size=3><b>Library \\ Библиотека</b> <font size=2 color=gray>(kolxoz, homelab, ...)</font></font><td><input type='text' name='Library' size=10 value='".$library."' maxlength=50/>
<tr><td><font face=arial size=3><b>Issue \\ Издание библиотеки</b> <font size=2 color=gray>(DVD-, release №, ...)</font></font><td><input type='text' name='Issue' size=5 value='".$issue."' maxlength=10/>
<tr><td><font face=arial size=3><b>Orientation \\ Ориентация скана</b> <font size=2 color=gray>(landscape, portrait)</font></font><td><input type='text' name='Orientation' size=15 value='".$orientation."' maxlength=50/>
<tr><td><font face=arial size=3><b>DPI \\ Разрешение</font></font><td><input type='text' name='DPI' size=5 value='".$dpi."' maxlength=6/>
<tr><td><font face=arial size=3><b>Color \\ Цветной скан</b> <font size=2 color=gray>(yes, no)</font></font><td><input type='text' name='Color' size=10 value='".$color."' maxlength=50/>
<tr><td><font face=arial size=3><b>Cleaned \\ Обрезанный скан</b> <font size=2 color=gray>(yes, no)</font></font><td><input type='text' name='Cleaned' size=10 value='".$cleaned."' maxlength=50/>
<tr><td><font face=arial size=3><b>Commentary \\ Комментарий</b> <font size=2 color=gray>(5000 символов макс.)</font></font><td><input type='text' name='Commentary' size=90 value='".$commentary."' maxlength=5000/>
<tr><td><font face=arial size=3><b>MD5 of a Better Version \\ MD5 лучшей версии</b></font><td><input type='text' name='Generic' size=35 value='".$generic."' maxlength=32/>
<tr><td><font face=arial size=3><b>CoverURL \\ Ссылка на обложку</b> <font size=2 color=gray></font></font><td><input type='text' name='Coverurl' size=90 value='".$coverurl."' maxlength=199/>
<tr><td><font face=arial size=3><b><a href='http://en.wikipedia.org/wiki/Universal_Decimal_Classification'>UDC \\ УДК</a></b></font><td><input type='text' name='UDC' size=90 value='".$udc."' maxlength=50/>
<tr><td><font face=arial size=3><b><a href='http://www.indiana.edu/~libslav/slavcatman/bbkover.html'>LBC \\ ББК</a></b></font><td><input type='text' name='LBC' size=90 value='".$lbc."' maxlength=50/>
<tr><td><font face=arial size=3 color=gray><b>Filesize \\ Размер файла</b> <font size=2>(bytes)</font></font><td><input readonly type='text' name='Filesize' size=10 value='".$filesize."' maxlength=20/>
<tr><td><font face=arial size=3 color=gray><b>MD5</b></font><td><input readonly type='text' name='MD5' size=35 value='".$md5."' maxlength=32/>
<tr><td><font face=arial size=3 color=gray><b>File Extension \\ Расширение файла</b></font><td><input readonly type='text' name='Extension' size=10 value='".$fileext."' maxlength=50/>
<tr><td><font face=arial size=3 color=gray><b>Book description \\ Описание книги</b></font><td><textarea name='Description' rows=10 cols=90>".$description."</textarea>
<tr><th colspan=2><input type='submit' value='Register!'/>
</table>

<input type='hidden' name='Edit' value='".$editing."'/>
</form>".$htmlfoot;

	// add new record, edit if already exists
	if ($_POST['Form'] == 1){
		if ($editing){
			echo $regform;
		} else {
			// save from the cache to the temporary directory (otherwise it might be automatically wiped);
			// to be copied to the repository in case of successful database registration (follows after this step)
			$tmp=str_replace('\\','/',getcwd().'/'.$tmpdir);
			@mkdir($tmp,0777,true);
			$saveto = "{$tmp}/{$md5}";
			if(copy($_FILES['uploadedfile']['tmp_name'],$saveto)) {
				echo $regform;
			} else {
				echo $htmlhead."<font color='#A00000'><h1>Upload failed</h1></font>There was an error uploading the file. Please try again!".$htmlfoot;
			}
		}
	}

	// edit, if MD5 found
	if ($_POST['Form'] == 2){
		if ($editing || isset($_POST['amazon']) || isset($_POST['ozon'])) echo $regform;
		else echo $htmlhead."<font color='#A00000'><h1>Book not found</h1></font>There is no such book in the database.<br>You are welcome to upload this piece!<p><a href='registration.php'>Go back to the upload page</a><p><h2>Thank you!</h2>".$htmlfoot;
	}
?>