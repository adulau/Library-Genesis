<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
  <title>BatchInfoLoad</title>
 </head>
 <body>

  
<?php
require_once '../config.php';
require_once '../amazonRequest.php';


//input
$inputSep = "\t";
$colISBN = 2;

 

$input = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$output = fopen("output.txt", "w");
$notfound = fopen("notfound.txt","w");
$output_all = fopen("output_all.txt", "w");



foreach ($input as $line) {
    
    $found = false;
    
    $inputTable = explode($inputSep, $line);
    
    $isbns = explode(",", $inputTable[$colISBN-1]);
    $colorIsbn = "<font color='blue'>".$inputTable[$colISBN-1]."</font>";

    foreach ($isbns as $isbn) {
        
        $amazonInfo = amazonInfo($isbn, $public_key, $private_key);
        $amazonError = $amazonInfo['error'];
        if($amazonError==''){
           
            $found = true;
            
            
            
            $title = $amazonInfo['Title'];
            $author = $amazonInfo['Author'];
            $year = $amazonInfo['Year'];
            $publisher = $amazonInfo['Publisher'];
            $edition = $amazonInfo['Edition'];
            $pages = $amazonInfo['Pages'];
            $identifier = $amazonInfo['ISBN'];
            $language = $amazonInfo['Language'];
            $commentary = $amazonInfo['Content'];
            $image = $amazonInfo['Image']; 
           
               
            
            
            $title4echo = htmlspecialchars($title,ENT_QUOTES);
            $colorIsbn = str_replace($isbn, "<font color='green'>".$isbn."</font>", $colorIsbn);
           
            break;
          
        }else{
           
            $title = '';
            $author = '';
            $year = '';
            $publisher = '';
            $edition = '';
            $pages = '';
            $identifier = '';
            $language = '';
            $commentary = '';
            $image = '';
            
            $title4echo = "<font color='red'>not found</font>";
            $colorIsbn = str_replace($isbn, "<font color='red'>".$isbn."</font>", $colorIsbn);
            
                     
        }
          
    }
    
    
    
    //output
    $outLine = $inputTable[0]."\t".$title."\t".$author."\t".$year."\t".$publisher."\t".$edition."\t".$pages."\t".$identifier."\t".$language."\t".$commentary."\t".$image."\n";
    
    
    
    fwrite($output_all, $outLine);
    
    if($found) fwrite($output, $outLine); 
    else fwrite($notfound, $line."\n");
    
    echo $colorIsbn." - ".$title4echo."<br>\n";
    flush();
}

?>
  
  
  
</body>
</html>
