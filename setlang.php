<?php
if(isset($_GET["lang"])) {
  $lang = $_GET["lang"];
  if($lang == 'ru') { 
   SetCookie('lang', 'ru', time()+3600); 
   }
  if($lang == 'en') {
   SetCookie('lang', 'en', time()+3600); 
   }
 }
echo'<meta http-equiv="refresh" content="0;url=search.php" />';
?>