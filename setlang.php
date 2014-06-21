<?php
if(isset($_GET["lang"])) {
  $lang = $_GET["lang"];
  if($lang == 'ru') { 
   SetCookie('lang', 'ru', time()+360000); 
   }
  if($lang == 'en') {
   SetCookie('lang', 'en', time()+360000); 
   }
 }


if (isset($_SERVER["HTTP_REFERER"])) {
	if(preg_match('|^http://libgen.org|', $_SERVER["HTTP_REFERER"]))
	{
		echo'<meta http-equiv="refresh" content="0;url='.$_SERVER["HTTP_REFERER"].'" />';
	}
}

?>