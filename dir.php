<?php

// php.ini: extension=php_com_dotnet.dll

//ini_set("display_errors", 1);
//ini_set("track_errors", 1);
//ini_set("html_errors", 1);
//error_reporting(E_ALL);

if ($_SERVER['DOCUMENT_URI']==$_SERVER['SCRIPT_NAME']) {
   header('HTTP/1.0 403 Forbidden');
   die('<html><head><title>403 Forbidden</title></head><body><h1>403 Forbidden</h1></body></html>');
}

$reqdir=urldecode($_SERVER['REQUEST_URI']);
$dirpath=$_SERVER['DOCUMENT_ROOT'].'/'.substr($reqdir,strlen($_SERVER['DOCUMENT_URI']));
$dirpath=str_replace('/','\\',$dirpath);

$show_dirname=true;
$show_updir=true;
date_default_timezone_set('UTC');

header('Content-Type: text/html; charset=utf-8');


$fs = new COM("Scripting.FileSystemObject", null, CP_UTF8);
if (!$fs->FolderExists($dirpath)) {   
   header('HTTP/1.0 404 Not Found');
   die('<html><head><title>404 Not Found</title></head><body><h1>404 Not Found</h1></body></html>');
}

function print_file_row($name,$sep,$vtdate, $size)
{
   echo "<tr>";
   echo '<td><a href="'.rawurlencode($name).$sep.'">'.htmlspecialchars($name).$sep.'</a></td>';
   echo '<td align="right">'.date('Y-m-d H:m:s',variant_date_to_timestamp($vtdate)).'</td>';
   echo '<td align="right">'.$size.'</td>';
   echo "</tr>\n";
}
   
echo "<html><body>\n";

if ($show_dirname) {
   echo "<h1>Index of ".htmlspecialchars($reqdir)."</h1>\n";
}

echo "<hr/>\n";

echo "<table>\n";

$dir = $fs->GetFolder($dirpath);

if ($show_updir) {
   echo "<tr>";
   echo '<td><a href="'.'..'.'/">'.'..'.'/</a></td>';
   echo '<td align="right">'.''.'</td>';
   echo '<td align="right">'.''.'</td>';
   echo "</tr>\n";
}   
foreach ($dir->SubFolders() as $v) {
   print_file_row($v->Name,'/',$v->DateLastModified,'-');
}
foreach ($dir->Files as $v) {
   print_file_row($v->Name,'',$v->DateLastModified,$v->Size);
}

echo "</table>\n";

echo "<hr/>\n";

echo "</body></html>\n";

?>