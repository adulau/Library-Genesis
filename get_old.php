<?php
ini_set('display_errors', '0');
// error by default
header("HTTP/1.0 500 Internal Server Error");

//file_put_contents('get_old.txt', "1\n", FILE_APPEND);

//ini_set('display_errors', '1');
if (isset($_SERVER["HTTP_REFERER"])) {
	if (strpos($_SERVER["HTTP_REFERER"], "http://adf.ly") !== false || 
strpos($_SERVER["HTTP_REFERER"], "http://ebookoid.in") !== false || 
strpos($_SERVER["HTTP_REFERER"], "http://bookos.org") !== false || 
strpos($_SERVER["HTTP_REFERER"], "http://bookinist.net") !== false || 
strpos($_SERVER["HTTP_REFERER"], "http://ebooks.myesci.com") !== false || 
strpos($_SERVER["HTTP_REFERER"], "http://anonym.to") !== false)
	{
		// play the fool
		header("HTTP/1.0 200 OK");
		die();
	}
}
/*
if (strpos($_SERVER["HTTP_REFERER"],"http://genofond.org")!==false || 
strpos($_SERVER["HTTP_REFERER"],"http://gen.lib.rus.ec")!==false || 
strpos($_SERVER["HTTP_REFERER"],"http://libgen.org")!==false ||   
strpos($_SERVER["HTTP_REFERER"],"http://flibusta.net")!==false || 
strpos($_SERVER["HTTP_REFERER"],"http://lib.rus.ec")!==false || 
strpos($_SERVER["HTTP_REFERER"],"http://rutracker.org")!==false ||
strpos($_SERVER["HTTP_REFERER"],"http://book.libertorrent.com/")!==false ||
strpos($_SERVER["HTTP_REFERER"],"http://127.0.0.1/")!==false) 
{
}
else
{
die();
}*/


include 'config.php';
//include 'resume.php';

$htmlhead="<html><head></head><body>";
$htmlfoot="</body></html>";


	@$con = mysql_connect($dbhost,$dbuser_get,$dbpass_get);
	if (!$con)
	{
		header("HTTP/1.0 500 Internal Server Error");
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font>Could not connect to the database: ".mysql_error()."<br>Cannot proceed.<p><a href='http://genofond.org/viewtopic.php?f=3&t=3925'>Please, report on the error</a>.".$htmlfoot);
	}

	mysql_query("SET session character_set_server = 'UTF8'");
	mysql_query("SET session character_set_connection = 'UTF8'");
	mysql_query("SET session character_set_client = 'UTF8'");
	mysql_query("SET session character_set_results = 'UTF8'");

	$result = mysql_select_db($db,$con);
	if (!$result)
	{
		header("HTTP/1.0 500 Internal Server Error");
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font>Could select database: ".mysql_error(). "<br>Cannot proceed.".$htmlfoot);
	}
	



// получаем хеш файла и тип отдачи файла пользователю
//echo $_GET['md5'];

if (isset($_GET['md5']))
{
if(preg_match('|^[A-Fa-f0-9]{32}$|', $_GET['md5']))
	{	
		$md5 = $_GET['md5'];
	}
	else
	{
		header("HTTP/1.0 404 Not Found");
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font><br>Wrong MD5".$htmlfoot);	
	}
}
else
{
	header("HTTP/1.0 404 Not Found");
	die($htmlhead."<font color='#A00000'><h1>Error</h1></font><br>Set MD5".$htmlfoot);
}

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
elseif(isset($_GET['nametype']) &&  $_GET['nametype'] == 'orig')
{
	$open = 0;
}
elseif(isset($_GET['nametype']) &&  $_GET['nametype'] == 'translit')
{
	$open = 1;
}
elseif(isset($_GET['nametype']) &&  $_GET['nametype'] == 'md5')
{
	$open = 2;
}
else
{
	$open = 0;
}
$sql    = "SELECT u.Title, u.Author, u.Series, u.Periodical, u.VolumeInfo, u.Publisher, u.Year, u.MD5,
CASE 
WHEN u.`Visible`='ban'
THEN 'ban'
WHEN u.`Visible`='del'
THEN 'del'
ELSE 
CONCAT(u.`ID` - (u.`ID` % 1000), '/', u.`MD5`) 
END as `Filename`, u.Extension FROM `".$dbtable."` as `u` WHERE `u`.`MD5`='" . mysql_real_escape_string($_GET['md5']) . "'";

//echo $sql;
	$result = mysql_query($sql, $con);
	if (!$result)
	{
		header("HTTP/1.0 500 Internal Server Error");
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font>Could not query database: ".mysql_error(). "<br>Cannot proceed.".$htmlfoot);
	}
		//die($htmlhead."<font color='#A00000'><h1>Error</h1></font>" . mysql_error() . "<br>Cannot proceed.<p>Please, report on the error from <a href=>the main page</a>.".$htmlfoot);
	if(mysql_num_rows($result) ==1)
	{
		$row = mysql_fetch_assoc($result);

		if($row['Filename'] == 'del')
		{
			header("HTTP/1.0 404 Not Found");
			die($htmlhead."<font color='#A00000'><h1>Error</h1></font><br>File not found on server.".$htmlfoot);
		}
		elseif($row['Filename'] == 'ban')
		{
			if(!isset($_GET['banned']))
			{
				header("HTTP/1.0 404 Not Found");
				die($htmlhead."<font color='#A00000'><h1>Error</h1></font><br>File banned .".$htmlfoot);
			}	
		}


	}
	else
	{
		header("HTTP/1.0 404 Not Found");
		die($htmlhead."<font color='#A00000'><h1>Error</h1></font><br>MD5 not found on DB.".$htmlfoot);
	}



	mysql_free_result($result);
	mysql_close($con);



//функция формирующая имя файла
function downloadname($row)
{	
	$title        = stripslashes($row['Title']);
	$author       = stripslashes($row['Author']);
	$periodical   = stripslashes($row['Periodical']);
	$series       = stripslashes($row['Series']);
	$vol          = stripslashes($row['VolumeInfo']);
	$publisher    = stripslashes($row['Publisher']);
	$year         = $row['Year'];
	$pages        = $row['Pages'];
	$lang         = stripslashes($row['Language']);
	$ident        = stripslashes($row['Identifier']);
	$volume       = stripslashes($row['VolumeInfo']);
	$edition      = stripslashes($row['Edition']);
	$ext          = stripslashes($row['Extension']);
	$library      = stripslashes($row['Library']);
	$filename     = stripslashes($row['Filename']);

	// the name, under which the user is going to download the book
	$downloadname = '';
	if (!empty($author)) {
		$downloadname = $author;
	}
	if (!empty($title)) {
		$downloadname = $downloadname . '-' . $title;
	}
	if (!empty($series)) {
		$downloadname = '(' . $series . ') ' . $downloadname;
	}
	if (!empty($periodical)) {
		$downloadname = '(' . $periodical . ') ' . $downloadname;
	}
	if (!empty($volume)) {
		$downloadname = $downloadname . '. ' . $volume;
	}
	if (!empty($publisher)) {
		$downloadname = $downloadname . '-' . $publisher;
	}
	if (!empty($year)) {
		$downloadname = $downloadname . ' (' . $year . ')';
	}
	if (empty($downloadname)) {
		$downloadname = 'unknown';
	}
	$downloadname = mb_substr($downloadname, 0, 200, 'utf-8');
return($downloadname);
}

//функция получения пути до файла 

    function getRepDirByFilename($filename) 
	{
        global $repository;
        global $filesep;
        
      	list($dir,$file) = explode($filesep,$filename); //print "$dir $file<br>\n";
        

        $repdir = $repository;
        foreach  ($repository as $key => $value) 
	    {
            if(!isset($key) or $key=='') 
	    {
              // $key can't be not set, but it can be empty, in which case we skip it - it's the default value
              continue;
            }
            
            list ($start,$end)=explode('-',$key);
            if ($dir>=$start and $dir<=$end) 
	    {
                $repdir=$value; 
                break;
            }
        }
        
        return $repdir;
    } 

//удаляем недопустимые символы
function removeillegal($str)
{
	static $tbl = array('<' => '_', '>' => '_', ':' => '_', '"' => '_', '/' => '_', '\\' => '_', '|' => '_', '?' => '_', '*' => '_', ';' => '_');
	return strtr($str, $tbl);
}
//транслитерируем
function translit($str)
{
	static $tbl = array('Щ' => 'SHCH', 'щ' => 'shch', 'Ё' => 'YO', 'ё' => 'yo', 'Ж' => 'ZH', 'ж' => 'zh', 'Й' => 'J#', 'й' => 'j#', 'Ч' => 'CH', 'ч' => 'ch', 'Ш' => 'SH', 'ш' => 'sh', 'Э' => 'E#', 'э' => 'e#', 'Ю' => 'JU', 'ю' => 'ju', 'Я' => 'JA', 'я' => 'ja', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'З' => 'Z', 'И' => 'I', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'У' => 'Y', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'з' => 'z', 'и' => 'i', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ъ' => '~', 'ь' => '`', 'Ъ' => '~', 'Ы' => 'Y', 'ы' => 'y', 'Ь' => '#');
	return strtr($str, $tbl);
}


$fullfilename = getRepDirByFilename($row['Filename']) . '\\' . $row['Filename']; // eg c:/library/9000/<md5>
$fullfilename = str_replace('/', '\\', $fullfilename);
#$fullfilename = str_replace(':\\', ':\\\\', $fullfilename);
//echo '/internal/'.$fullfilename;

#echo "X-Accel-Redirect: /internal/$fullfilename";

if (!file_exists($fullfilename))
{
	header("HTTP/1.0 404 Not Found");
	die($htmlhead."<font color='#A00000'><h1>File not found!</h1></font><a href='http://genofond.org/viewtopic.php?f=1&t=6423'>Please, report to the administrator.</a>".$htmlfoot);
}

$downloadname = removeillegal(downloadname($row));
$ext = $row['Extension'];
//echo $open;




if($open == 0)
{

	if (isset($_SERVER['SERVER_SOFTWARE'])&&substr($_SERVER['SERVER_SOFTWARE'],0,5)=='nginx') 
	{
//echo $open;
		header('Content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . $downloadname . '.' . $ext . '"');      
		header('X-Accel-Redirect: /internal/'.$fullfilename);
	} 
}
elseif($open == 1)
{

	if (isset($_SERVER['SERVER_SOFTWARE'])&&substr($_SERVER['SERVER_SOFTWARE'],0,5)=='nginx') 
	{

		header('Content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . translit($downloadname) . '.' . $ext . '"');      
		header("X-Accel-Redirect: /internal/$fullfilename");
	} 
}
elseif($open == 2)
{
	if (isset($_SERVER['SERVER_SOFTWARE'])&&substr($_SERVER['SERVER_SOFTWARE'],0,5)=='nginx') 
	{

		header('Content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . $md5 . '.' . $ext . '"');    
		header("X-Accel-Redirect: /internal/$fullfilename");
	} 
}
elseif($open == 3)
{
		header("HTTP/1.0 200 OK");	
		header('Content-type: application/'.$ext);
		readfile($fullfilename); //открыть в браузере
}
?>