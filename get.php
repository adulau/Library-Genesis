<?php

include 'config.php';
header("HTTP/1.0 500 Internal Server Error");
ini_set('display_errors', '0');





function error_message($message, $http_code = 0)
{
	if ($http_code != 0)
	{
		switch ($http_code)
		{
			case 404: $text = 'Not Found'; break;
			case 500: $text = 'Internal Server Error'; break;
		}
		if (isset($text))
			header($_SERVER['SERVER_PROTOCOL'] . ' ' . $http_code . ' ' . $text);
	}
	echo '<h1 style="color:#A00000">Error</h1><p>' . $message . '</p>';
	exit();
}

// формируем имя файла
function compose_filename($row)
{   
	$filename = '';
	if (!empty($row['Author']))
		$filename = $row['Author'];
	if (!empty($row['Title']))
		$filename .= '-' . $row['Title'];
	if (!empty($row['Series']))
		$filename = '(' . $row['Series'] . ') ' . $filename;
	if (!empty($row['Periodical']))
		$filename = '(' . $row['Periodical'] . ') ' . $filename;
	if (!empty($row['VolumeInfo']))
		$filename .= '. ' . $row['VolumeInfo'];
	if (!empty($row['Publisher']))
		$filename .= '-' . $row['Publisher'];
	if (!empty($row['Year']))
		$filename .= ' (' . $row['Year'] . ')';
	return (empty($filename) ? strtoupper($row['MD5']) : mb_substr($filename, 0, 200, 'utf-8'));
}

// получаем путь до файла
function get_repository_dir($filename)
{
	global $repository, $filesep;
	list($dir, $file) = explode($filesep, $filename);
	$repdir = $repository;
	foreach ($repository as $key => $value)
	{
		if (!isset($key) || $key == '')
		{
			// $key can't be not set, but it can be empty, in which case we skip it - it's the default value
			continue;
		}
		list ($start, $end) = explode('-', $key);
		if ($dir >= $start && $dir <= $end)
		{
			$repdir = $value;
			break;
		}
	}
	return $repdir;
}

// заменяем недопустимые символы в имени файла
function sanitize_filename($str)
{
	static $tbl = array(
		'<' => '_',
		'>' => '_',
		':' => '_',
		'"' => '_',
		'/' => '_',
		'\\' => '_',
		'|' => '_',
		'?' => '_',
		'*' => '_',
		'#' => '_',
		';' => '_'
	);
	return strtr($str, $tbl);
}

// транслитерируем
function translit($str)
{
	static $tbl = array('Щ' => 'SHCH', 'щ' => 'shch', 'Ё' => 'YO', 'ё' => 'yo', 'Ж' => 'ZH', 'ж' => 'zh', 
'Й' => 'J#', 'й' => 'j#', 'Ч' => 'CH', 'ч' => 'ch', 'Ш' => 'SH', 'ш' => 'sh', 'Э' => 'E#', 'э' => 'e#', 'Ю' => 'JU', 
'ю' => 'ju', 'Я' => 'JA', 'я' => 'ja', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'З' => 'Z', 
'И' => 'I', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 
'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'У' => 'Y', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'з' => 'z', 
'и' => 'i', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 
'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ъ' => '~', 'ь' => '`', 'Ъ' => '~', 'Ы' => 'Y', 'ы' => 'y', 'Ь' => '#');
	return strtr($str, $tbl);
}



if (!isset($_GET['md5']) || !preg_match('|^[a-fA-F0-9]{32}$|', $_GET['md5']))
	error_message("Specify an MD5 hash", 404);

if (($con = mysql_connect($dbhost, $dbuser_get, $dbpass_get)) === FALSE)
{
	error_message("Could not connect to the database: " . htmlspecialchars(mysql_error()) . "
<br>Cannot proceed.<p><a href=\"http://genofond.org/viewtopic.php?f=3&t=3925\">Please, report the error</a>.", 500);
}
mysql_query("SET NAMES utf8");

if (($result = mysql_select_db($db, $con)) === FALSE)
{
	error_message("Could not select the database: " . htmlspecialchars(mysql_error()) . "<br>Cannot proceed.", 500);
}
$result = mysql_query(
"SELECT u.Title, u.Author, u.Series, u.Periodical, u.VolumeInfo, u.Publisher, u.Year, u.MD5,
CASE 
WHEN `Visible`='ban'
THEN 'ban'
WHEN `Visible`='del'
THEN 'del'
ELSE 
CONCAT(u.`ID` - (u.`ID` % 1000), '/', u.`MD5`) 
END as `Filename`, u.Extension
FROM `".$dbtable."` u WHERE u.MD5='" . mysql_real_escape_string($_GET['md5']) . "' ", $con);

//`filename` as `file_exists`, 
//u.Visible


if (!$result)
{
	error_message("Could not query the database: " . htmlspecialchars(mysql_error()). "<br>Cannot proceed.", 500);
}
if (mysql_num_rows($result) == 1)
{
	$row = mysql_fetch_assoc($result);
	if ($row['Filename'] == 'del')
	{
		error_message("File not found", 404);
	}
	elseif ($row['Filename'] == 'ban' && !isset($_GET['banned']))
	{
		error_message("File is banned", 404);
	}

	
}
else
{
	error_message("Book with such MD5 hash isn't found", 404);
}


$fullfilename = get_repository_dir($row['Filename']) . '\\' . $row['Filename'];
$fullfilename = str_replace('/', '\\', $fullfilename);

if (!file_exists($fullfilename))
	error_message("File not found! Please, <a href=\"http://genofond.org/viewtopic.php?f=1&t=6423\">report to the administrator</a>.", 404);
// реальное скачивание

mysql_free_result($result);
mysql_free_result($res_ads);
mysql_close($con);

//file_put_contents('get.txt', "\n", FILE_APPEND);
	//file_put_contents('get_ref.txt', $_SERVER['REQUEST_URI']."\t".$_SERVER["HTTP_X_REAL_IP"]."\n", FILE_APPEND);
if (isset($_GET['dl']) && $_GET['dl'] == 1) //условие из nginx 			proxy_pass     http://download_upstream_hosts/get.php?md5=$1&dl=1; # multi upstream (load balancing) mode
{
	//file_put_contents('get.txt', "4".$_SERVER["REQUEST_URI"]."\t".$_SERVER["HTTP_REFERER"]."\n", FILE_APPEND);
	header('Content-Type: application/octet-stream');
//	header('Content-Disposition: attachment; filename="' . addslashes($filename . '.' . $row['Extension']) . '"');
	header('X-Accel-Redirect: /internal/' . $fullfilename);
}
else // перенаправление на скачивание
{
	if (!isset($_SERVER["HTTP_X_REAL_IP"])) //для localhost или зеркала  в i2p не проксируем
	{
		header('Location: '.str_replace('/get', '/get_old', $_SERVER["REQUEST_URI"]), true, 301);
		die();
	}



	if (isset($_GET['open']))
	{
		if (preg_match('|^[0123]$|', $_GET['open']))
			$open = $_GET['open'];
		else
			$open = 0;
	}
	else if (isset($_GET['nametype']))
	{
		$a = array(
			'orig'     => 0,
			'translit' => 1,
			'md5'      => 2
		);
		$open = in_array($_GET['nametype'], $a) ? $a[$_GET['nametype']] : 0;
	}
	else
	   $open = 0;
	switch ($open)
	{
		case 1:  $filename = translit(sanitize_filename(compose_filename($row))); break;
		case 2:  $filename = strtoupper($_GET['md5']); break;
		default: $filename = sanitize_filename(compose_filename($row));
	}
	// перенаправляем на адрес вида /get/7a69d29eabe406cddbbad6dabcb1c7ee/filename.pdf
	// должен обрабатываться frontend веб-сервером
	header('Location: /get/' . strtoupper($_GET['md5']) . '/' . str_replace('+', '%20', urlencode($filename . '.' . strtolower($row['Extension']))));
}
//exit();
// выводим сообщение об ошибке и выходим

?>