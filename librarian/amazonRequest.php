<?php

include("aws_signed_request.php");

function amazonInfo($isbn, $public_key, $private_key){
    
    
    $result = array('error'=>'');
    
    $pxml = aws_signed_request("com", array("Operation"=>"ItemLookup","ItemId"=>$isbn,"ResponseGroup"=>"Medium"), $public_key, $private_key);
    
    if ($pxml === False)
    {
     $result['error']="Did not work.";
    }
    else
    {
        if (isset($pxml->Items->Item->ItemAttributes->Title))
        {
            $result['Title']=$pxml->Items->Item->ItemAttributes->Title; 
            $result['Author']=$pxml->Items->Item->ItemAttributes->Author;
            $result['Publisher']=$pxml->Items->Item->ItemAttributes->Publisher;
            $result['Language']=$pxml->Items->Item->ItemAttributes->Languages->Language->Name;
            $result['ISBN']=$pxml->Items->Item->ItemAttributes->ISBN;
            $result['EAN']=$pxml->Items->Item->ItemAttributes->EAN;
            $result['Edition']=$pxml->Items->Item->ItemAttributes->Edition;
            $result['Pages']=$pxml->Items->Item->ItemAttributes->NumberOfPages;
            $result['Year']=substr($pxml->Items->Item->ItemAttributes->PublicationDate,0,4);
            $result['Image']=$pxml->Items->Item->LargeImage->URL;
            $result['Content']=$pxml->Items->Item->EditorialReviews->EditorialReview->Content;
         
        }
        else
        {
            $result['error']="Could not find item.";
        }
    }
      
    return $result;
    
}

?>