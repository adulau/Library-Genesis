<?php

function RGBitem($record, $tag, $code)
{

    $datafield = split('<datafield tag="' . $tag . '"', $record);
    $datafield = split('</datafield>', $datafield[1]);

    $subfield = split('<subfield code="' . $code . '">', $datafield[0]);
    $subfield = split('</subfield>', $subfield[1]);

    return trim($subfield[0]);
}

$request = "http://lbc.rsl.ru/autoindex/yaztest-rsl.php?ISBN=" . $isbn;
$response = file_get_contents($request);
$records = split('<record xmlns="http://www.loc.gov/MARC21/slim">', $response);

if (count($records) < 2) $rgbError = "Could not find item.\n";
else {
    
    $rgbError = "";
    $i = 1;
    // Title
    $title1 = RGBitem($records[$i], '245', 'a');
    $title2 = RGBitem($records[$i], '245', 'b');
    $title = htmlspecialchars(trim(trim($title1, ':') . ':' . $title2, ':'),ENT_QUOTES);

    // Author
    $author1_1 = RGBitem($records[$i], '110', 'a');
    $author1_2 = RGBitem($records[$i], '110', 'b');
    $author1_3 = RGBitem($records[$i], '110', 'c');
    $author = htmlspecialchars(trim($author1_1 . ':' . $author1_2 . ':' . $author1_3, ':'),ENT_QUOTES);

    if ($author == '') {
        $author2_1 = RGBitem($records[$i], '245', 'c');
        $author = htmlspecialchars(trim($author2_1, ':'),ENT_QUOTES);
    }

    if ($author == '') {
        $author3_1 = RGBitem($records[$i], '700', 'a');
        $author3_1 = RGBitem($records[$i], '700', 'b');
        $author3_1 = RGBitem($records[$i], '700', 'c');
        $author = htmlspecialchars(trim($author3_1 . ':' . $author3_2 . ':' . $author3_3, ':'),ENT_QUOTES);
    }


    $city = htmlspecialchars(RGBitem($records[$i], '260', 'a'),ENT_QUOTES);

    $publisher = htmlspecialchars(RGBitem($records[$i], '260', 'b'),ENT_QUOTES);

    $year = htmlspecialchars(RGBitem($records[$i], '260', 'c'),ENT_QUOTES);

    $edition = htmlspecialchars(RGBitem($records[$i], '250', 'a'),ENT_QUOTES);

    $volumeninfo = htmlspecialchars(RGBitem($records[$i], '245', 'n'),ENT_QUOTES);

    $pages = htmlspecialchars(RGBitem($records[$i], '300', 'a'),ENT_QUOTES);

    $identifier = htmlspecialchars(RGBitem($records[$i], '020', 'a'),ENT_QUOTES);

    $language = htmlspecialchars(RGBitem($records[$i], '041', 'a'),ENT_QUOTES);

    $topic1 = RGBitem($records[$i], '650', 'a') . '(' . RGBitem($records[$i], '650', '2') . ')';
    $topic2 = RGBitem($records[$i], '653', 'a') . '(' . RGBitem($records[$i], '653', '2') . ')';
    $topic = htmlspecialchars(trim(trim($topic1 . ';' . $topic2, '()'), ';'),ENT_QUOTES);

    $udc = htmlspecialchars(RGBitem($records[$i], '080', 'a'),ENT_QUOTES);

    $series = htmlspecialchars(RGBitem($records[$i], '440', 'a'),ENT_QUOTES);
    
    
}

?>