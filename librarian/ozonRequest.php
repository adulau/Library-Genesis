<?php

function xml2array($xml) {
        $xmlary = array();
               
        $reels = '/<(\w+)\s*([^\/>]*)\s*(?:\/>|>(.*)<\/\s*\\1\s*>)/s';
        $reattrs = '/(\w+)=(?:"|\')([^"\']*)(:?"|\')/';

        preg_match_all($reels, $xml, $elements);

        foreach ($elements[1] as $ie => $xx) {
                $xmlary[$ie]["name"] = $elements[1][$ie];
               
                if ($attributes = trim($elements[2][$ie])) {
                        preg_match_all($reattrs, $attributes, $att);
                        foreach ($att[1] as $ia => $xx)
                                $xmlary[$ie]["attributes"][$att[1][$ia]] = $att[2][$ia];
                }

                $cdend = strpos($elements[3][$ie], "<");
                if ($cdend > 0) {
                        $xmlary[$ie]["text"] = substr($elements[3][$ie], 0, $cdend - 1);
                }

                if (preg_match($reels, $elements[3][$ie]))
                        $xmlary[$ie]["elements"] = xml2array($elements[3][$ie]);
                else if ($elements[3][$ie]) {
                        $xmlary[$ie]["text"] = $elements[3][$ie];
                }
        }

        return $xmlary;
}


function ozon_request($isbn)
{
    
    // some paramters
    $method = "GET";
    $host = "www.ozon.ru";

    // create request
    $request = "/webservice/webservice.asmx/SearchWebService?searchText=".$isbn."&searchContext=";
    
    // do request
    $response = file_get_contents("http://".$host.$request);

    if ($response === False)
    {
        return False;
    }
    else
    {
        // parse XML
        $xmlAr = xml2array($response);
        
        return $xmlAr;
        
    }
}


$ozonInfo = array('error'=>'');
$ozonXmlArray = ozon_request($isbn);

if ($ozonXmlArray === False)
 {
     $ozonInfo['error'] = "Did not work.\n";
 }
 else
 {
     if ($ozonXmlArray[13]['elements'][0]['elements'][1]['text'] != '')
     {
         
         $ozonInfo['ID'] = $ozonXmlArray[13]['elements'][0]['elements'][0]['text'];
         $ozonInfo['Title'] = $ozonXmlArray[13]['elements'][0]['elements'][1]['text'];
         $ozonInfo['Author'] = $ozonXmlArray[13]['elements'][0]['elements'][2]['text'];
         $ozonInfo['Year'] = $ozonXmlArray[13]['elements'][0]['elements'][5]['text'];
         $ozonInfo['Content'] = $ozonXmlArray[13]['elements'][0]['elements'][10]['text'];
         $ozonInfo['Image'] = $ozonXmlArray[13]['elements'][0]['elements'][11]['text'];
        
        // information from ozon-htmlcode
	
    include("phpHTMLParser.php");
	
    $htmlcode = file_get_contents("http://www.ozon.ru/context/detail/id/".$ozonInfo['ID']."/");
    $parser = new phpHTMLParser(str_replace('<br>',' ',$htmlcode));
	$HTMLObject = $parser->parse_tags(array("td"));
	$tds = $HTMLObject->getTagsByName("td");
  
    foreach ($tds as $td) {
		if ($td->innerTag == 'class="detail_centralcell vertpadd"') {
			$ozonInfo['Content'] = iconv('windows-1251', 'utf-8//IGNORE',$td->innerHTML);break;
		}
	}
    
    $descr = split('detail_centralcell vertpadd">',$htmlcode);
    $descr = split('</td>',$descr[1]);
    #echo trim($descr[0]);
    
    $publ = split('title="Издательство">',$htmlcode);
    $publ = split('</a>',$publ[1]);
    $ozonInfo['Publisher'] = iconv('windows-1251', 'utf-8//IGNORE', trim($publ[0]));
    
    $pages = split('title="Издательство">',$htmlcode);
    $pages = split('<br>',$pages[1]);
    $pages = split(',',$pages[1]);
    $ozonInfo['Pages'] = iconv('windows-1251', 'utf-8//IGNORE', trim($pages[1]));
    
    $categ = split('<div class="frame_content small">',$htmlcode);
    $categ = split('</div>',$categ[1]);
    $categCode = trim($categ[0]);
    $parser = new phpHTMLParser($categCode);
    $HTMLObject = $parser->parse_tags(array("a"));
    $spans = $HTMLObject->getTagsByName("a");
    foreach ($spans as $span) {
         $cat = $cat.'/'.$span->innerHTML;
   }
    $cat = split('Каталог',$cat);
    $ozonInfo['Topic'] = iconv('windows-1251', 'utf-8//IGNORE', $cat[1]); 
     }
     
     
     
     
     else
     {
         $ozonInfo['error'] = "Could not find item.\n";
     }
 }


?>
