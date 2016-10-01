<?php
ini_set('display_errors', '0');
//получаем ID + список полей, возвращаем их значения в JSON

header('HTTP/1.0 500 Internal Server Error');

include 'connect.php';

header('HTTP/1.0 400 Bad Request');

if (isset($_REQUEST['limit1']) && preg_match('|[0-9]|', $_REQUEST['limit1']))
{
	$limit1 = $_REQUEST['limit1'];
}
else
{
	$limit1 = '1000';
}


if (isset($_REQUEST['limit2']) && preg_match('|[0-9]|', $_REQUEST['limit2']))
{
	$limit2 = $_REQUEST['limit2'];
}
else
{
	$limit2 = '';
}



function isbn_find_req($isbn)
{
	$isbn             = preg_replace('/[[:punct:]]+/u', ' ', str_replace('-', '', $isbn)); //для подстановки в sql запрос
	$isbn             = preg_replace('/[\s]+/u', ' ', trim($isbn));
	$sql_req = " MATCH(`IdentifierWODash`) AGAINST (' +".str_replace(' ', ' +', $isbn)."' IN BOOLEAN MODE) ";
	return($sql_req);
}



if($limit2 == '') $limit = ' LIMIT '.$limit1;
else $limit = ' LIMIT '.$limit1.', '.$limit2;


if (isset($_REQUEST['timefirst']))
{
	$timefirst = $_REQUEST['timefirst'];
}
else
{
	$timefirst = '';
}

if (isset($_REQUEST['timelast']))
{
	$timelast = $_REQUEST['timelast'];
}
else
{
	$timelast = '';
}



if (isset($_REQUEST['mode']) && in_array($_REQUEST['mode'], array('last', 'modified', 'newer' )))
{
	$mode = $_REQUEST['mode'];
}
else
{
	$mode = '';
}




if(isset($_REQUEST['fields']))
{
	$fields = strtolower($_REQUEST['fields']);
	if ($fields=='*') 
	{
		$fields='*';
	} 
	else 
	{
		$fieldsarray = explode(',', $fields);
		if(count(array_diff($fieldsarray, array(
		'id', 'title', 'volumeinfo', 'series', 'periodical', 'author', 'year',
		'edition', 'publisher', 'city', 'pages', 'language', 'topic', 'library',
		'issue', 'identifier', 'issn', 'asin', 'udc', 'lbc', 'ddc', 'lcc', 'doi',
		'googlebookid', 'openLibraryid', 'commentary', 'dpi', 'color', 'cleaned',
		'orientation', 'paginated', 'scanned', 'bookmarked', 'searchable', 'filesize',
		'extension', 'md5', 'generic',
		'visible', 'locator', 'local', 'timeadded', 'timelastmodified', 'coverurl','identifierwodash', 'tags','pagesinfile'
		))) == 0)
		{
		$fields = implode('`,`', $fieldsarray);
		$fields = "`".$fields."`";
		}
		else
		{
			die("WRONG FIELDS");
		}
	}
}
else
{
die("WHERE FIELDS?");
}

$ids = array();
if(isset($_REQUEST['ids']) && $mode == '')
{
	if(preg_match('|^[0-9,]+$|', $_REQUEST['ids']) || preg_match('|^[0-9A-Za-z]{32}$|', $_REQUEST['ids']))
	{
		$ids = $_REQUEST['ids'];
	}
	else
	{
		die("WRONG IDS");
	}
}
elseif(isset($_REQUEST['doi']) && !empty($_REQUEST['doi']))
{
	$doi = $_REQUEST['doi'];
}
elseif(isset($_REQUEST['isbn']) && !empty($_REQUEST['isbn']))
{
	$isbn = $_REQUEST['isbn'];
}
elseif(!isset($_REQUEST['ids']) && $mode == '')
{
	die("WHERE IDS?");
}


if(isset($_REQUEST['timenewer']) && $mode == 'newer')
{
	if(preg_match('|^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$|', $_REQUEST['timenewer'])) 
	{
		$timenewer = $_REQUEST['timenewer'];
		if(isset($_REQUEST['idnewer']))
		{		
			if(preg_match('|^[0-9]+$|', $_REQUEST['idnewer']))
			{
				$idnewer=$_REQUEST['idnewer'];
			}
			else
			{
			die("WRONG IDNEWER");
			}		
		}
		else 
		{
			$idnewer='';
		}
	}
	else
	{
		die("WRONG TIMENEWER");
	}
} 
elseif(!isset($_REQUEST['timenewer']) && $mode == 'newer')
{
	die("WHERE TIMENEWER?");
}


if ($mode == 'modified')
{
	if($timefirst !='' && $timelast == '') {$timelast = date("Y-m-d");}
	if(preg_match('|^[0-9]{4}-[0-9]{2}-[0-9]{2}$|', $timefirst) && preg_match('|^[0-9]{4}-[0-9]{2}-[0-9]{2}$|', $timelast))
	{
		$where = " (`TimeLastModified` BETWEEN STR_TO_DATE('" . $timefirst . " 00:00:00','%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('" . $timelast . " 23:59:59','%Y-%m-%d %H:%i:%s') ) ";
	}
	$orderby = "";
}
elseif ($mode == 'last')
{
	if($timefirst !='' && $timelast == '') {$timelast = date("Y-m-d");}
	if(preg_match('|^[0-9]{4}-[0-9]{2}-[0-9]{2}$|', $timefirst) && preg_match('|^[0-9]{4}-[0-9]{2}-[0-9]{2}$|', $timelast)){
		$where = " (`TimeAdded` BETWEEN STR_TO_DATE('" . $timefirst . " 00:00:00','%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('" . $timelast . " 23:59:59','%Y-%m-%d %H:%i:%s') ) ";
	}
	$orderby = "";
}
elseif ($mode == 'newer')
{
	if ($idnewer == '')
	{
		$where = " (`TimeLastModified` > '" . addslashes($timenewer) . "') ";
	}
	else
	{
		$where = " (`TimeLastModified` = '" . addslashes($timenewer) . "' AND ID > '" . addslashes($idnewer) . "') OR (`TimeLastModified` > '" . addslashes($timenewer) . "') ";
	}
	$orderby = " ORDER BY `TimeLastModified`, `ID` ";
}
elseif(isset($doi))
{
	$where = "`Doi` = '".mysql_real_escape_string($doi)."'";
	$orderby = " ORDER BY `TimeLastModified`, `ID` ";
}
elseif(isset($isbn))
{
//1 ищем убрав дефисы из поиск. запроса через Match against
//2 если не найдено ничего и поисковый запрос содержит дефисы -ищем по фразе через match against
//3 если ничего не найдено, то убрираем дефисы из колонки и из запроса и ищем через like



	$where = isbn_find_req($isbn);

	$orderby = " ORDER BY `TimeLastModified`, `ID` ";
}
else
{
	if(preg_match('|^[0-9,]+$|', $ids))
	$where = "`ID` IN (".$ids.")";
 	if(preg_match('|^[0-9A-Za-z,]{32}$|', $ids))
	$where = "`MD5` IN ('". $ids."')";

	$orderby = " ORDER BY `TimeLastModified`, `ID` ";
}

header('HTTP/1.0 500 Internal Server Error');

$return_arr = array();
$sql = "SELECT ".$fields." FROM `updated` WHERE ".$where." ".$orderby." ".$limit;
//echo $sql;

mysql_query("SET time_zone='+00:00'",$con); 
$fetch = mysql_query($sql, $con);
if (!$fetch)
{
	die('SQL ERROR');
}
while ($row = mysql_fetch_assoc($fetch)) 
{
	array_push($return_arr,$row);
}

header('HTTP/1.0 200 Ok');
echo json_encode($return_arr);

?>