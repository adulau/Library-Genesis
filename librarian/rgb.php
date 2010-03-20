<?php //include('auth.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
  <title>AWS - Example</title>
 </head>
 <body>

  
<?php

function RGBitem($record, $tag, $code)
{

    $datafield = split('<datafield tag="' . $tag . '"', $record);
    $datafield = split('</datafield>', $datafield[1]);

    $subfield = split('<subfield code="' . $code . '">', $datafield[0]);
    $subfield = split('</subfield>', $subfield[1]);

    return trim($subfield[0]);
}



$isbnForm = "<form action='" . $_SERVER["PHP_SELF"] . "' method='post' >
ISBN: <input type='text' name='isbn' size='20' maxlength='25' value='" .
    htmlspecialchars($_POST['isbn']) . "' />
<input type='submit' value='Info from RGB' name='rgb'/>
\t" . $Error . "</form>";

echo $isbnForm;

if (isset($_POST['isbn'])) {

    $isbn = htmlspecialchars($_POST['isbn']);
    $request = "http://lbc.rsl.ru/autoindex/yaztest-rsl.php?ISBN=" . $isbn;


    $response = file_get_contents($request);


    $records = split('<record xmlns="http://www.loc.gov/MARC21/slim">', $response);

    if (count($records) < 2)
        echo 'Could not find item.';

    else {

        for ($i = 1; $i < count($records); $i++) {

            // Title
            $title1 = RGBitem($records[$i], '245', 'a');
            $title2 = RGBitem($records[$i], '245', 'b');
            $title = trim(trim($title1, ':') . ':' . $title2, ':');

            // Author
            $author1_1 = RGBitem($records[$i], '110', 'a');
            $author1_2 = RGBitem($records[$i], '110', 'b');
            $author1_3 = RGBitem($records[$i], '110', 'c');
            $author = trim($author1_1 . ':' . $author1_2 . ':' . $author1_3, ':');

            if ($author == '') {
                $author2_1 = RGBitem($records[$i], '245', 'c');
                $author = trim($author2_1, ':');
            }

            if ($author == '') {
                $author3_1 = RGBitem($records[$i], '700', 'a');
                $author3_1 = RGBitem($records[$i], '700', 'b');
                $author3_1 = RGBitem($records[$i], '700', 'c');
                $author = trim($author3_1 . ':' . $author3_2 . ':' . $author3_3, ':');
            }


            $city = RGBitem($records[$i], '260', 'a');

            $publisher = RGBitem($records[$i], '260', 'b');

            $year = RGBitem($records[$i], '260', 'c');

            $edition = RGBitem($records[$i], '250', 'a');

            $volumeninfo = RGBitem($records[$i], '245', 'n');

            $pages = RGBitem($records[$i], '300', 'a');

            $identifier = RGBitem($records[$i], '020', 'a');

            $language = RGBitem($records[$i], '041', 'a');

            $topic1 = RGBitem($records[$i], '650', 'a') . '(' . RGBitem($records[$i], '650', '2') . ')';
            $topic2 = RGBitem($records[$i], '653', 'a') . '(' . RGBitem($records[$i], '653', '2') . ')';
            $topic = trim(trim($topic1 . ';' . $topic2, '()'), ';');

            $udc = RGBitem($records[$i], '080', 'a');

            $series = RGBitem($records[$i], '440', 'a');

            echo '<br /><br /><font color="blue">Title: </font>' . $title . '<br />' .
                '<font color="blue">Author: </font>' . $author . '<br />' .
                '<font color="blue">City: </font>' . $city . '<br />' .
                '<font color="blue">Publisher: </font>' . $publisher . '<br />' .
                '<font color="blue">Year: </font>' . $year . '<br />' .
                '<font color="blue">Edition: </font>' . $edition . '<br />' .
                '<font color="blue">Volumeninfo: </font>' . $volumeninfo . '<br />' .
                '<font color="blue">Pages: </font>' . $pages . '<br />' .
                '<font color="blue">Identifier: </font>' . $identifier . '<br />' .
                '<font color="blue">Language: </font>' . $language . '<br />' .
                '<font color="blue">Topic: </font>' . $topic . '<br />' .
                '<font color="blue">UDC: </font>' . $udc . '<br />' .
                '<font color="blue">Series: </font>' . $series . '<br />';
        }
    }
}
?>


  
</body>
</html>
