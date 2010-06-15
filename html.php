<?php
include 'strings.php';

$htmlheadbegin = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head><meta http-equiv="content-type" content="text/html"; charset="utf-8">
<title>Library Genesis</title>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<meta name="robots" content="index,follow">
<meta name="keywords" content="$str_keywords">
<meta name="description" content="Library Genesis is a scientific library.">
<meta name="rating" content="general">
<meta name="author" content="bookwarrior">
<style type="text/css">
.c { font-family: Tahoma; font-size: 11px; color: #000000; LETTER-SPACING: 0px; }
A { text-decoration: none; }
td { padding: 1px; }
table { border-spacing: 1px 1px; }
</style>
';
$htmlheadend = "</head><body topmargin=0 marginheight=0>
<table height=100% width=100%>
<td>
";
$script = "<script type='text/javascript'>
function f() { document.getElementById('searchform').focus(); }
window.onload = f;
</script>";

$htmlhead = $htmlheadbegin.$htmlheadend;
$htmlheadfocus = $htmlheadbegin.$script.$htmlheadend;
$htmlfoot = "</td></table></body></html>";
?>
