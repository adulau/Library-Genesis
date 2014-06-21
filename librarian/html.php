<?php
$htmlheadbegin = "<html><head><title>Library Genesis</title>
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
?>
