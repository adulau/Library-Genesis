<?php
include 'strings.php';


$htmlheadbegin = "<html><head><meta http-equiv='content-type' content='text/html; charset=utf-8'/>
<title>Library Genesis</title>
<META HTTP-EQUIV='CACHE-CONTROL' CONTENT='NO-CACHE'/>
<meta name='robots' content='index,follow'/>
<meta name='keywords' content='$str_keywords'/>
<meta name='description' content='Library Genesis is a scientific community targeting collection of books on natural science disciplines and engineering.'/>
<meta name='rating' content='general'/>
<meta name='author' content='bookwarrior'/>
<style type='text/css'>
.c { font-family: Tahoma; font-size: 11px; color: #000000; LETTER-SPACING: 0px; }
A { text-decoration: none; }
td { padding: 1px; }
table { border-spacing: 1px 1px; }
</style>
";
$htmlheadend = "</head><body topmargin='0'>";
$script = "<script type='text/javascript'>
function f() { document.getElementById('searchform').focus(); }
window.onload = f;
</script>";

$htmlhead = $htmlheadbegin.$htmlheadend;
$htmlheadfocus = $htmlheadbegin.$script.$htmlheadend;
$htmlfoot = "</body></html>";
?>