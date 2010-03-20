--TEST--
Unit tests for ISBN
--FILE--
<?php
// ISBN test script

require_once 'ISBN.php';

$numbersISBN = array(
	// test against real world data:
	'ISBN 0-8436-1072-7',	// Example ISBN-10 Example taken from 2001 Handbook p.5
	'9786000000004',		// Example ISBN-13 Example taken from 2005 Handbook p.13 (undefined and invalid registration group)
	'6010000009',			// Example ISBN-10 repalces 9786000000004 which is a valid iranian now 
	'9780777777770',		// Example ISBN-13 Example taken from 2005 Handbook p.13
	'0385339410',			// ISBN-10 Hannibal Rising (Hardcover) by Thomas Harris
	'978-0385339414',		// ISBN-13 Hannibal Rising (Hardcover) by Thomas Harris
	'3926529423',			// ISBN-10 Das Bush-Imperium. Wie Georg W. Bush zum Präsidenten gemacht wurde (Broschiert) von James H. Hatfield
	'978-3926529428',		// ISBN-13 Das Bush-Imperium. Wie Georg W. Bush zum Präsidenten gemacht wurde (Broschiert) von James H. Hatfield
	'2020478447',			// ISBN-10 Le Neutre : Cours au collège de France (1977-1978) (Broché) de Roland Barthes
	'978-2020478441',		// ISBN-13 Le Neutre : Cours au collège de France (1977-1978) (Broché) de Roland Barthes
	
	// format tests: (all not ok)
	'ISBN 0-',					// NOK 
	'A897710005',				// NOK 
	'A3897710005',				// NOK 

	// format tests: (all are ok in a certain way)
	'ISBN   3-  89771----000-5',// NOK / OK - ISBN-10 BETTER CHECK needed!
	'3897710005',				// OK - ISBN-10
	'3-89771-000-5',			// OK - ISBN-10 formatted
	'ISBN 3-89771-000-5',		// OK - ISBN-10 formatted extended
	'9783897710009',			// OK - ISBN-13-978
	'978-3-89771-000-9',		// OK - ISBN-13-978 formatted
	'ISBN 978-3-89771-000-9',	// OK - ISBN-13-978 formatted extended

	// empty tests:
	0,		// NOK
	false,  // NOK
	NULL,	// NOK
	''		// NOK
);

$numbersConvert = array(
	// test against real world data:
	'ISBN 0-8436-1072-7',	// Example ISBN-10 Example taken from 2001 Handbook p.5 - The Carnival of Death (L. Ron Hubbard Classic Fiction Series)
	'0385339410',			// ISBN-10 Hannibal Rising (Hardcover) by Thomas Harris
	'3926529423',			// ISBN-10 Das Bush-Imperium. Wie Georg W. Bush zum Präsidenten gemacht wurde (Broschiert) von James H. Hatfield
	'3402081172',			// ISBN-10 Kirche und Wandmalereien vom Karm al Ahbariya (Gebundene Ausgabe) [ISBN-13: 978-3402081174]
	'3790816515',			// ISBN-10 Handbuch E-Money, E-Payment & M-Payment (Gebundene Ausgabe) [ISBN-13: 978-3790816518]		
); 

echo "Test ISBN Numbers Validation\n";
echo "****************************\n";

echo "\nTest Instancing\n";
echo "----------------------------\n";
echo "new ISBN()\n";
$isbn = new ISBN();
echo 'new ISBN("ISBN 0-8436-1072-7")'."\n";
$isbn = new ISBN("ISBN 0-8436-1072-7"); // ISBN 10
echo 'new ISBN("ISBN 0-8436-1072-7", wrong version)'."\n";
$isbn = new ISBN("ISBN 0-8436-1072-7", ISBN_VERSION_ISBN_13); // ISBN 10

echo "\nTest ISBN::guessVersion\n";
echo "----------------------------\n";
foreach ($numbersISBN as $number) {
    echo "{$number}: ";
	$r = ISBN::guessVersion($number);
	var_dump($r);
}


echo "\nTest ISBN::validate\n";
echo "----------------------------\n";
foreach ($numbersISBN as $number) {
    echo "{$number}: ";
	$r = ISBN::validate($number);
	var_dump($r);
	$r = (bool) $r;
	echo "  \- bool: ";
	var_dump($r);
}

echo "\nTest oISBN->isValid\n";
echo "----------------------------\n";
foreach ($numbersISBN as $number) {
    echo "{$number}: ";
	try {
		$isbn = new ISBN($number);
		$r = $isbn->isValid();
		var_dump($r);
	} catch (Exception $e) {
		echo "Exception: " . $e->getMessage() . "\n";
	}
}

echo "\nTest ISBN::convert\n";
echo "----------------------------\n";
foreach ($numbersConvert as $number) {
    echo "{$number}: ";
	$r = ISBN::convert($number);
	var_dump($r);
}

?>
--EXPECT--
Test ISBN Numbers Validation
****************************

Test Instancing
----------------------------
new ISBN()
new ISBN("ISBN 0-8436-1072-7")
new ISBN("ISBN 0-8436-1072-7", wrong version)

Test ISBN::guessVersion
----------------------------
ISBN 0-8436-1072-7: int(10)
9786000000004: int(13978)
6010000009: int(10)
9780777777770: int(13978)
0385339410: int(10)
978-0385339414: int(13978)
3926529423: int(10)
978-3926529428: int(13978)
2020478447: int(10)
978-2020478441: int(13978)
ISBN 0-: bool(false)
A897710005: bool(false)
A3897710005: bool(false)
ISBN   3-  89771----000-5: int(10)
3897710005: int(10)
3-89771-000-5: int(10)
ISBN 3-89771-000-5: int(10)
9783897710009: int(13978)
978-3-89771-000-9: int(13978)
ISBN 978-3-89771-000-9: int(13978)
0: bool(false)
: bool(false)
: bool(false)
: bool(false)

Test ISBN::validate
----------------------------
ISBN 0-8436-1072-7: int(10)
  \- bool: bool(true)
9786000000004: int(13978)
  \- bool: bool(true)
6010000009: bool(false)
  \- bool: bool(false)
9780777777770: int(13978)
  \- bool: bool(true)
0385339410: int(10)
  \- bool: bool(true)
978-0385339414: int(13978)
  \- bool: bool(true)
3926529423: int(10)
  \- bool: bool(true)
978-3926529428: int(13978)
  \- bool: bool(true)
2020478447: int(10)
  \- bool: bool(true)
978-2020478441: int(13978)
  \- bool: bool(true)
ISBN 0-: bool(false)
  \- bool: bool(false)
A897710005: bool(false)
  \- bool: bool(false)
A3897710005: bool(false)
  \- bool: bool(false)
ISBN   3-  89771----000-5: int(10)
  \- bool: bool(true)
3897710005: int(10)
  \- bool: bool(true)
3-89771-000-5: int(10)
  \- bool: bool(true)
ISBN 3-89771-000-5: int(10)
  \- bool: bool(true)
9783897710009: int(13978)
  \- bool: bool(true)
978-3-89771-000-9: int(13978)
  \- bool: bool(true)
ISBN 978-3-89771-000-9: int(13978)
  \- bool: bool(true)
0: bool(false)
  \- bool: bool(false)
: bool(false)
  \- bool: bool(false)
: bool(false)
  \- bool: bool(false)
: bool(false)
  \- bool: bool(false)

Test oISBN->isValid
----------------------------
ISBN 0-8436-1072-7: bool(true)
9786000000004: bool(true)
6010000009: bool(false)
9780777777770: bool(true)
0385339410: bool(true)
978-0385339414: bool(true)
3926529423: bool(true)
978-3926529428: bool(true)
2020478447: bool(true)
978-2020478441: bool(true)
ISBN 0-: bool(false)
A897710005: bool(false)
A3897710005: bool(false)
ISBN   3-  89771----000-5: bool(true)
3897710005: bool(true)
3-89771-000-5: bool(true)
ISBN 3-89771-000-5: bool(true)
9783897710009: bool(true)
978-3-89771-000-9: bool(true)
ISBN 978-3-89771-000-9: bool(true)
0: Exception: ISBN parameter must be a string
: Exception: ISBN parameter must be a string
: Exception: ISBN parameter must be a string
: bool(false)

Test ISBN::convert
----------------------------
ISBN 0-8436-1072-7: string(13) "9780843610727"
0385339410: string(13) "9780385339414"
3926529423: string(13) "9783926529428"
3402081172: string(13) "9783402081174"
3790816515: string(13) "9783790816518"