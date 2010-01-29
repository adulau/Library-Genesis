<?php
    include 'config.php';
    
    // various utilites, used across the code
    
    // deduce repository directory from filename and return it
    function getRepDirByFilename($filename) {
        global $repository;
        global $filesep;
        
      	list($dir,$file) = split($filesep,$filename); //print "$dir $file<br>\n";
        
        $repdir=$repository[''];
        foreach  ($repository as $key => $value) {
            if(!isset($key)) {
              continue;
            }
            
            list ($start,$end)=split('-',$key);
            if ($dir>=$start and $dir<=$end) {
                $repdir=$value; 
                break;
            }
        }
        
        return $repdir;
    }    
?>