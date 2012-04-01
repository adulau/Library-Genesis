<?php
    include 'config.php';
    
    // various utilites, used across the code
    
    // deduce repository directory from filename and return it
    function getRepDirByFilename($filename) {
        global $repository;
        global $filesep;
        
      	list($dir,$file) = split($filesep,$filename); //print "$dir $file<br>\n";
        

        $repdir = $repository;
        foreach  ($repository as $key => $value) {
            if(!isset($key) or $key=='') {
              // $key can't be not set, but it can be empty, in which case we skip it - it's the default value
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