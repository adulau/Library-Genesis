<?php
/**
 * ISBN
 *
 * Handle, Convert and Validate ISBN Numbers
 *
 * PHP version 5
 *
 * LICENSE: LGPL (In cases LGPL is not appropriate, it is licensed under GPL)
 *
 * Package to handle, convert and validate ISBN numbers. It includes:
 *
 *  - ISBN specifics: EAN/PrefixArrayAccess (integer)
 *  - ISBN specifics: Group/Registration Group [2001: Group identifier] (integer)
 *  - ISBN specifics: GroupTitle/Registration Group Title (string)
 *  - ISBN specifics: Publisher/Registrant [2001: Publisher identifier] (string)
 *  - ISBN specifics: Title/Publication [2001: Title identifier] (string)
 *  - ISBN specifics: Checkdigit (string)
 *  - ISBN specifics: 'ISBNBody' (string)
 *  - ISBN specifics: 'ISBNSubbody' (string)
 *  - ISBN Version handling 
 *  - Syntactical Validation plus Validation based on real ISBN Data
 *  - ISBN-10 (ISO 2108) checksum calculation
 *  - Validation (ISBN-10 and ISBN-13-978)
 *  - Conversion to ISBN-13-978
 *  - ISBN-13-978 (2005 Handbook, ISO pending; ISBN-13)
 *  - ISBN-13 checksum calculation (EAN)
 *
 * Based on standards published by international ISBN Agency
 * http://www.isbn-international.org/
 *
 * @category  Pending
 * @package   ISBN
 * @author    Tom Klingenberg <tkli-php@lastflood.net>
 * @copyright 2006-2007 Tom Klingenberg
 * @license   LGPL http://www.gnu.org/licenses/lgpl.txt
 * @version   v 0.1.6 CVS: <cvs_id>
 * @link      http://isbn.lastflood.com online docs
 * 
 * @todo      License for .js file or remove it
 * @todo      GroupTitle
 * @todo      PEAR Package.xml
 *
 */

// {{{ constants
/**
 * ISBN Versions supported
 */
define('ISBN_VERSION_NONE', false);
/**
 * VERSION_UNKNOWN is by the caller only, this shall never
 * be a value returned by a public function or getter
 */
define('ISBN_VERSION_UNKNOWN', 0);
define('ISBN_VERSION_ISBN_10', 10);
define('ISBN_VERSION_ISBN_13', 13978);
define('ISBN_VERSION_ISBN_13_978', ISBN_VERSION_ISBN_13);
define('ISBN_VERSION_ISBN_13_979', 13979);  /* reserved */

/*
 * Default ISBN Version for class input / usage
 */
define('ISBN_DEFAULT_INPUTVERSION', ISBN_VERSION_UNKNOWN);
/*
 * Default ISBN Seperator string
 */
define('ISBN_DEFAULT_COSMETIC_SEPERATOR', '-');

/*
 * ISBN_DEFAULT_PRINT_LANG_SPECIFIC_PREFIX
 *
 * When printed, the ISBN is always preceded by the letters "ISBN".
 * Note: In countries where the Latin alphabet is not used, an abbreviation
 * in the characters of the local script may be used in addition to the
 * Latin letters "ISBN".
 * This can be defined as a default value wihtin this constant.
 */
define('ISBN_DEFAULT_PRINT_LANG_SPECIFIC_PREFIX', '');
// }}}

#require_once 'PEAR/Exception.php';

// {{{ ISBN_Exception
/**
 * ISBN_Exception class
 *
 * @category  Pending
 * @package   ISBN
 * @author    Tom Klingenberg <tkli-php@lastflood.net>
 * @copyright 2006-2007 Tom Klingenberg
 * @license   LGPL http://www.gnu.org/licenses/lgpl.txt
 * @link      http://isbn.lastflood.com/
 * @since     Class available since Release 0.1.3
 */

// }}}

// {{{ ISBN
/**
 * ISBN class
 *
 * Class to Handle, Convert and Validate ISBN Numbers
 *
 * @category  Pending
 * @package   ISBN
 * @author    Tom Klingenberg <tkli-php@lastflood.net>
 * @copyright 2006-2007 Tom Klingenberg
 * @license   LGPL http://www.gnu.org/licenses/lgpl.txt
 * @link      http://isbn.lastflood.com/
 * @since     Class available since Release 0.0.0
 */
class ISBN
{
    /**
     * @var string ISBN Registration Group
     */
    private $isbn_group = '';
    /**
     * @var string ISBN Publisher
     */
    private $isbn_publisher = '';
    /**
     * @var string ISBN Title
     */
    private $isbn_title = '';

    /**
     * @var mixed ISBN number version
     */
    private $ver = ISBN_VERSION_NONE;
    
    /**
     * @var array ISBN Groups Data acting as cache
     * @see _getISBN10Groups()
     */    
    private static $varISBN10Groups = array();    

    // {{{ __construct
    /**
     * Constructor
     *
     * @param array $isbn String of ISBN Value to use
     * @param mixed $ver  Optional Version Constant
     *
     * @access public
     * 
     * @throws ISBN_Exception in case it fails
     */
    function __construct($isbn = '', $ver = ISBN_DEFAULT_INPUTVERSION)
    {
        /* validate & handle optional isbn parameter */
        if (is_string($isbn) == false ) {
            #throw new ISBN_Exception('ISBN parameter must be a string');
        }
        if (strlen($isbn) == 0) {
            $this->setISBN($isbn);
            return;
        }

        /* validate version parameter */
        if (self::_isbnVersionIs($ver) == false) {
            #throw new ISBN_Exception('ISBN Version parameter is not an ISBN Version');
        }

        /* ISBN has been passed, check the version now:
         *  if it is unknown, try to dertine it, if this fails
         *  throw an exception
         */
        if ($ver == ISBN_VERSION_UNKNOWN) {
            $verguess = self::_isbnVersionGuess($isbn);
            if (self::_isbnVersionIsValid($verguess)) {
                $ver = $verguess;
            } else {
                /* throw new ISBN_Exception(
                 *'ISBN Version couldn\'t determined.');
                 */                                  
                $ver = ISBN_VERSION_NONE;
            }
        }
        /* version determined */
        $this->ver = $ver;

        /* handle a complete invalid ISBN of which a version could
         * not be determined. */
        if ($ver === ISBN_VERSION_NONE) {
            $this->setISBN('');
            return;
        }

        try {
            $this->setISBN($isbn);
        } catch(Exception $e) {
            /* the isbn is invalid and not set, sothat this
             * ISBN object will be set to a blank value. */
            $this->setISBN('');
        }

    }
    // }}}

    // {{{ _extractCheckdigit()
    /**
     * extract Checkdigit of an ISBN-Number
     *
     * @param string $isbnn normalized ISBN string
     *
     * @return string|false ISBN-Body or false if failed
     *
     */
    private static function _extractCheckdigit($isbnn)
    {
        $checkdigit = false;
        $checkdigit = substr($isbnn, -1);
        return (string) $checkdigit;
    }
    // }}}

    // {{{ _extractEANPrefix()
    /**
     * extracts EAN-Prefix of a normalized isbn string
     *
     * @param string $isbnn normalized isbn string
     *
     * @return string|false Prefix or false if failed
     */
    private static function _extractEANPrefix($isbnn)
    {
        $r = settype($isbnn, 'string');
        if ($r === false) {
            return false;
        }
        if (strlen($isbnn) < 3) {
            return false;
        }
        $prefix = substr($isbnn, 0, 3);
        return $prefix;
    }
    // }}}

    // {{{ _extractGroup()
    /**
     * extract Registration Group of an ISBN-Body
     *
     * @param string $isbnbody ISBN-Body
     *
     * @return integer|false    Registration Group or false if failed
     */
    private static function _extractGroup($isbnbody)
    {
        $group   = '';
        $subbody = '';

        $r = self::_isbnBodyParts($isbnbody, $group, $subbody);
        if ($r === false) {
            return false;
        }
        return $group;
    }
    // }}}

    // {{{ _extractISBNBody()
    /**
     * extract ISBN-Body of an ISBN-Number
     *
     * @param string $isbnn normalized ISBN string
     *
     * @return string|false ISBN-Body or false if failed
     */
    private static function _extractISBNBody($isbnn)
    {
        /* extract */
        $body  = false;
        $isbnn = (string) $isbnn;

        $l = strlen($isbnn);
        if ($l == 10) {
            $body =  substr($isbnn, 0, -1);
        } elseif ($l == 13) {
            $body =  substr($isbnn, 3, -1);
        } else {
            return false;
        }
        /* verify */
        $r = settype($body, 'string');
        if ($r === false) {
            return false;
        }
        if (strlen($body) != 9) {
            return false;
        }
        if (ctype_digit($body) === false) {
            return false;
        }
        return $body;
    }
    // }}}

    // {{{ _isbnBodyParts()
    /**
     * Get the 2 Parts of the ISBN-Body (ISBN-10/ISBN-13-978)
     *
     * @param string $isbnbody           ISBN-Body
     * @param string &$registrationgroup Registration Group
     * @param string &$isbnsubbody       ISBN-Subbody
     *
     * @return boolean  False if failed, True on success
     *
     * @access private
     */
    private static function _isbnBodyParts($isbnbody, 
                                           &$registrationgroup, 
                                           &$isbnsubbody)
    {
        /* validate input (should not be needed, @access private) */
        $r = settype($isbnbody, 'string');
        if ($r === false) {
            return false;
        }
        if (strlen($isbnbody) != 9) {
            return false;
        }
        if (ctype_digit($isbnbody) === false) {
            return false;
        }
        /* extract registraion group
         * boundaries see p.13 2005 handbook
         */
        $boundaries = array();

        $boundaries[] = array(    0, 59999, 1);
        $boundaries[] = array(60000, 60099, 3); // Iran 2006-12-05
        $boundaries[] = array(60100, 69999, 0);
        $boundaries[] = array(70000, 79999, 1);
        $boundaries[] = array(80000, 94999, 2);
        $boundaries[] = array(95000, 98999, 3);
        $boundaries[] = array(99000, 99899, 4);
        $boundaries[] = array(99900, 99999, 5);
        /* segment value */
        $segment      = substr($isbnbody, 0, 5);
        $segmentvalue = intval($segment);
        /* test segment value against boundaries */
        $r = false;
        foreach ($boundaries as $boundary) {
            if ($segmentvalue >= $boundary[0] && $segmentvalue <= $boundary[1]) {
                $r = $boundary[2];
            }
        }
        if ($r === false) {
            return false;
        }
        /* $r is 0 when the boundary is not defined */
        if ($r === 0) {
            return false;
        }
        $registrationgroup = substr($isbnbody, 0, $r);
        $isbnsubbody       = substr($isbnbody, $r);
        return true;
    }
    // }}}

    // {{{ _isbnSubbodyParts()
    /**
     * Get the 2 Parts of the ISBN-Subbody (ISBN-10/ISBN-13)
     *
     * @param string  $isbnsubbody  ISBN-Subbody
     * @param integer $groupid      Registrationgroup
     * @param string  &$registrant  Registrant
     * @param string  &$publication Publication
     *
     * @return boolean  False if failed, true on success
     *
     * @access private
     */
    private static function _isbnSubbodyParts($isbnsubbody, 
                                              $groupid, 
                                              &$registrant, 
                                              &$publication)
    {
        /* validate input (should not be needed, @access private) */
        $r = settype($isbnsubbody, 'string');
        if ($r === false) {
            return false;
        }
        $l = strlen($isbnsubbody);
        if ( $l < 1 || $l > 8) {
            return false;
        }
        if (ctype_digit($isbnsubbody) === false) {
            return false;
        }
        $r = settype($groupid, 'integer');
        if ($r === false) {
            return false;
        }
        if ($groupid < 0 || $groupid > 99999) {
            return false;
        }
        /* extract registrant based on group and registrant range
         * parse this specific group format: 
         *  array(
         *      'English speaking area',
         *      '00-09;10-19;200-699;7000-8499;85000-89999;' .
         *         '900000-949999;9500000-9999999'
         *      );
         */ 
        
        $group = self::_getISBN10Group($groupid);
        if ($group === false) {
            return false;
        }

        $len = self::_getRegistrantLength($isbnsubbody, $group[1]);
        if ($len === false) {
            return false;
        }        
        $registrant  = substr($isbnsubbody, 0, $len);
        $publication = substr($isbnsubbody, $len);
        return true;
    }
    // }}}

    // {{{ _getRegistrantLength()
    /**
     * Return Length of Registrant part within an ISBNSubbody in a specific
     * grouprange in this specific format:
     *
     * '00-09;10-19;200-699;7000-8499;85000-89999;900000-949999;9500000-9999999'
     *
     * Info: This function is compatible with Groupranges formatted in the
     * .js file and might become obsolete if new formats are more fitting.
     *
     * @param string $isbnsubbody ISBN-Subbody
     * @param string $grouprange  Grouprange in the Format '#a1-#z1;#a2-z2[...]'
     *
     * @return boolean|int  False if failed or Length (in chars) of Registrant
     *
     * @access private
     */
    private static function _getRegistrantLength($isbnsubbody, $grouprange)
    {
        $r = settype($grouprange, 'string');
        if ($r === false) {
            return false;
        }
        if (strlen($grouprange) < 3) {
            return false;
        }
        
        $sl     = strlen($isbnsubbody);
        $ranges = explode(';', $grouprange);
        foreach ($ranges as $range) {
            $range  = trim($range);
            $fromto = explode('-', $range);
            if (count($fromto) !== 2) {
                return false;
            }
            /* validation:
             * from and to need to be in the same class,
             * having the same length.
             * registrant can not be bigger or same then the
             * whole subbody, at least there is one digit for
             * the publication.
             */

            $l = strlen($fromto[0]);
            if ($l != strlen($fromto[1])) {
                return false;
            }
            if ($l >= $sl) {
                return false;
            }

            /* check that from/to values are in order */
            if (strcmp($fromto[0], $fromto[1]) >= 0) {
                return false;
            }

            /* compare and fire if matched */
            $comparec = substr($isbnsubbody, 0, $l);

            if (strcmp($fromto[0], $comparec) < 1 && 
                strcmp($fromto[1], $comparec) > -1) {
                return $l;
            }
        }        
        return false;
    }
    // }}}

    // {{{ _getISBN10Group()
    /**
     * Get ISBN-10 Registration Group Data by its numeric ID
     *
     * @param integer $id Registration Group Identifier
     *
     * @return mixed    array:   group array
     *                  boolean: False if failed
     */
    private static function _getISBN10Group($id)
    {
        $r = settype($id, 'integer');
        if ($r === false) {
            return false;
        }
        $groups = self::_getISBN10Groups();
        if ($groups === false) {
            return false;
        }
        if (isset($groups[$id]) === false) {
            return false;
        }
        $group = $groups[$id];
        return $group;
    }
    // }}}

    // {{{ _getISBN10Groups()
    /**
     * Get all ISBN-10 Registration Groups
     *
     * @return array    groups array
     *
     * Info: This function connects outer world data into this class logic
     *       which can be generated with the supplied tools.
     *       A user should not alter the array data. This data should be altered
     *       together with the international ISBN Agency only.
     */
    private static function _getISBN10Groups()
    {
        /* check if data has been already loaded */
        if (sizeof(self::$varISBN10Groups) > 0 ) {
                return self::$varISBN10Groups;      
        }
        
        /* load external data */
        try {       
            $t = file_get_contents('data/groups.csv', true, null);
        } catch(Exception $e) {
            throw new ISBN_Exception(
                'Unable to read ISBN Groups Data file.'
            );          
        }
        
        /* parse external data */
        $groups = array();      
        $tls    = split("\n", $t);
        $line   = 0;
        foreach ($tls as $tl) {
            $line++;            
            $tlp = split(',', $tl);
            if (sizeof($tlp) == 3) {
                $index = intval($tlp[0]);
                if (isset($groups[$index])) {
                    throw new ISBN_Exception(
                        'ISBN Groups Data is invalid, Group ' .
                        $index . 'is a duplicate.'
                    );                  
                }
                /* edit+ mature: sanitize external 
                   data */
                $groups[$index] = array($tlp[1],$tlp[2]);                       
            } else {
                throw new ISBN_Exception(
                    'ISBN Groups Data is malformed on line #' . $line . 
                    ' (' . sizeof($tlp) . ').'
                );
            }               
        }
        
        /* verify minimum */    
        if (sizeof($groups) == 0 ) {
            throw new ISBN_Exception(
                'ISBN Groups Data does not contain any valid data.'
            );          
        }
        
        self::$varISBN10Groups = $groups;
        
        /* return groups */
        return $groups;
    }
    // }}}

    // {{{ _getVersion()
    /**
     * Get the Version of am ISBN Number
     *
     * @param string $isbn ISBN Number ofwhich the version to get
     *
     * @return mixed false for no, or fully identifyable ISBN
     *                              Version Constant
     *
     * @access private
     */
    private static function _getVersion($isbn)
    {
        $ver = self::_isbnVersionGuess($isbn);
        $r   = self::_isbnVersionIsValid($ver);
        return $r;
    }
    // }}}

    // {{{ _checkdigitISBN10()
     /**
     * Calculate checkdigit of an ISBN-10 string (ISBN-Body)
     * as documented on pp.4-5 2001 handbook.
     *
     * @param string $isbnbody ISBN-Body
     *
     * @return string|false Checkdigit [0-9,X] or false if failed
     *
     * @access private
     */
    private static function _checkdigitISBN10($isbnbody)
    {
        /* The check digit is the last digit of an ISBN. It is calculated
         * on a modulus 11 with weights 10-2, using X in lieu of 10 where
         * ten would occur as a check digit.
         * This means that each of the first nine digits of the ISBN �
         * excluding the check digit itself � is multiplied by a number
         * ranging from 10 to 2 and that the resulting sum of the products,
         * plus the check digit, must be divisible by 11 without a
         * remainder. (pp.4-5 2001 Handbook)
         */
        if (strlen($isbnbody) != 9) {
            return false;
        }
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $v    = intval(substr($isbnbody, $i, 1));
            $sum += $v * (10 - $i);
        }
        $remainder  = $sum % 11;
        $checkdigit = 11 - $remainder;
        if ($remainder == 0) {
            $checkdigit = 0;
        }
        if ($checkdigit == 10) {
            $checkdigit = 'X';
        }
        return (string) $checkdigit;
    }
    // }}}

    // {{{ _checkdigitISBN13()
     /**
     * Calculate checkdigit of an ISBN-13 string (Prefix + ISBN-Body)
     * as documented on pp.10-11 2005 handbook.
     *
     * @param string $isbnbody ISBN-Body
     * @param string $prefix   EAN-Prefix (Default 978 for ISBN13-978)
     *
     * @return string|false Checkdigit [0-9] or false if failed
     *
     * @access private
     */
    private static function _checkdigitISBN13($isbnbody, $prefix = '978')
    {
        $prefixandisbnbody = $prefix . $isbnbody;

        $t = $prefixandisbnbody;
        $l = strlen($t);
        if ($l != 12) {
            return false;
        }
        /* Step 1: Determine the sum of the weighted products for the first 12
        *  digits of the ISBN (see p.10 2005 handbook)
        */
        $ii = 1;
        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $ii   = 1 - $ii;
            $sum += intval(substr($t, $i, 1)) * ($ii * 2 + 1);
        }
        /* Step 2: Divide the sum of the weighted products of the first 12
         * digits of the ISBN calculated in step 1 by 10, determining the
         * remainder. (see p.11 2005 handbook)
         */
        $remainder = $sum % 10;

        /* Step 3: Subtract the remainder calculated in step 2 from 10. The
         * resulting difference is the value of the check digit with one
         * exception. If the remainder from step 2 is 0, the check
         * digit is 0. (ebd.)
         */
        $checkdigit = 10 - $remainder;
        if ($remainder == 0) {
            $checkdigit = 0;
        }
        /* return string value */
        if (is_int($checkdigit)) {
            $checkdigit = (string) $checkdigit;
        }
        if (is_string($checkdigit) == false) {
            return false;
        }
        return $checkdigit;
    }
    // }}}

    // {{{ _isIsbnValid()
    /**
     * Validate an ISBN value
     *
     * @param string $isbn Number to validate
     * @param string $ver  Version to validate against     
     *
     * @return integer|false    Returns the Version to signal validity or false if 
     *                            ISBN number is not valid
     *
     * @access private
     */
    private static function _isIsbnValid($isbn, $ver = ISBN_DEFAULT_INPUTVERSION)
    {
        /* version handling */
        $r = self::_isbnVersionIs($ver);
        if ($r === false) {
            return false;
        }
        if ($ver === ISBN_VERSION_UNKNOWN) {
            $ver = self::_isbnVersionGuess($isbn);
        }
        if (self::_isbnVersionIsValid($ver) === false) {
            return false;
        }
        /* since a version is available now, normalise the ISBN input */
        $isbnn = self::_normaliseISBN($isbn);
        if ($isbnn === false) {
            return false;
        }
        /* normalzied ISBN and Version available, it's ok now
         * to perform indepth checks per version */
        switch ($ver) {
        case ISBN_VERSION_ISBN_10:

            /* check syntax against checkdigit */
            $isbnbody = self::_extractISBNBody($isbnn);
            $check    = self::_extractCheckdigit($isbnn);
            if ($check === false) {
                return false;
            }
            $checkdigit = self::_checkdigitISBN10($isbnbody);
            if ($checkdigit === false) {
                return false;
            }
            if ($checkdigit !== $check) {
                return false;
            }

            /* check registrationgroup validity */
            $registrationgroup = false;
            $subbody           = false;

            $r = self::_isbnBodyParts($isbnbody, $registrationgroup, $subbody);
            if ($r == false) {
                return false;
            }

            /* check for undefined registrationgroup */
            if (strlen($registrationgroup) == 0) {
                return false;
            }

            /* check registrant validity */
            $groupid     = intval($registrationgroup);
            $registrant  = false;
            $publication = false;

            $r = self::_isbnSubbodyParts($subbody, $groupid, 
                                         $registrant, $publication);
            if ($r == false) {
                return false;
            }
            return true;

        case ISBN_VERSION_ISBN_13:
        case ISBN_VERSION_ISBN_13_978:

            /* validate EAN Prefix */
            $ean = self::_extractEANPrefix($isbnn);
            if ($ean !== '978') {
                return false;
            }

            /* check syntax against checkdigit */
            $isbnbody = self::_extractISBNBody($isbnn);
            $check    = self::_extractCheckdigit($isbnn);
            if ($check === false) {
                return false;
            }
            $checkdigit = self::_checkdigitISBN13($isbnbody);
            if ($checkdigit === false) {
                return false;
            }
            if ($check !== $checkdigit) {
                return false;
            }

            /* validate group */
            $isbnbody = self::_extractISBNBody($isbnn);
            if ($isbnbody === false) {
                return false;
            }

            $registrationgroup = false;
            $subbody           = false;

            $r = self::_isbnBodyParts($isbnbody, $registrationgroup, $subbody);
            if ($r === false) {
                return false;
            }

            /* check for undefined registrationgroup */
            if (strlen($registrationgroup) == 0) {
                return false;
            }

            /* validate publisher */
            $registrant  = false;
            $publication = false;

            $r = self::_isbnSubbodyParts($subbody, $registrationgroup, 
                                         $registrant, $publication);
            if ($r === false) {
                return false;
            }
            return $ver;

        case ISBN_VERSION_ISBN_13_979:
            /* not yet standarized */
            return false;

        }
        return false;
    }
    // }}}

    // {{{ _isbnVersionGuess()
    /**
     * Guesses the version of an ISBN
     *
     * @param string $isbn ISBN Number of which the Version to guess
     *
     * @return integer|false Version Value or false (ISBN_VERSION_NONE) if failed
     * @access private
     */
    private static function _isbnVersionGuess($isbn)
    {
        $isbn = self::_normaliseISBN($isbn);
        if ($isbn === false) {
            return ISBN_VERSION_NONE;
        }
        if ( strlen($isbn) == 10) {
            return ISBN_VERSION_ISBN_10;
        } else {
            return ISBN_VERSION_ISBN_13;
        }
    }
    // }}}

    // {{{ _isbnVersionIs()
    /**
     * Validate an ISBN Version value
     *
     * @param mixed $ver version to be checked being a valid ISBN Version
     *
     * @return bool true if value is valid, false if not
     *
     * @access private
     */
    private static function _isbnVersionIs($ver)
    {
        if (is_bool($ver) === false && is_integer($ver) === false) {
            return false;
        }
        switch ($ver) {
        case ISBN_VERSION_NONE:
        case ISBN_VERSION_UNKNOWN:
        case ISBN_VERSION_ISBN_10:
        case ISBN_VERSION_ISBN_13:
        case ISBN_VERSION_ISBN_13_978:
        case ISBN_VERSION_ISBN_13_979:
            return true;

        default:
            return false;

        }
    }
    // }}}

    // {{{ _isbnVersionIsValid()
    /**
     * Validate an ISBN value being a valid (identifyable -10 / -13) value
     *
     * @param mixed $ver value to be checked being a valid ISBN Version
     *
     * @return bool true if value is valid, false if not
     *
     * @access private
     */
    private static function _isbnVersionIsValid($ver)
    {
        $r = self::_isbnVersionIs($ver);
        if ($r === false) {
            return false;
        }

        switch ($ver) {
        case ISBN_VERSION_ISBN_10:
        case ISBN_VERSION_ISBN_13_978:
            return true;
        default:
            return false;
        }
    }
    // }}}

    // {{{ _normaliseISBN()
    /**
     * downformat "any" ISBN Number to the very basics
     * an isbn number is a 10 or 13 digit. with the
     * 10 digit string, the last digit can be 0-9 and
     * X as well, all other are 0-9 only
     * additionally this fucntion can be used to validate
     * the isbn against correct length and chars
     *
     * @param string $isbn ISBN String to normalise
     *
     * @return string|false normalised ISBN Number or false if the function was
     *                        not able to normalise the input
     *
     * @access private
     */
    private static function _normaliseISBN($isbn)
    {
        /* validate input */
        $r = settype($isbn, 'string');
        if ($r === false) {
            return false;
        }

        /* normalize (trim & case)*/
        $isbn = trim($isbn);
        $isbn = strtoupper($isbn);

        /* remove lang specific prefix (if any) */
        $isbn = self::_normaliseISBNremoveLangSpecific($isbn);

        /* remove ISBN-10: or ISBN-13: prefix (if any) */
        if (strlen($isbn > 8)) {
            $prefix = substr($isbn, 0, 8);
            if ($prefix == 'ISBN-10:' || $prefix == 'ISBN-13:') {
                $isbn = substr($isbn, 8);
                $isbn = ltrim($isbn);
            }
        }

        /* remove lang specific prefix again (if any) */
        $isbn = self::_normaliseISBNremoveLangSpecific($isbn);

        /* remove "ISBN" prefix (if any)*/
        if (substr($isbn, 0, 4) == 'ISBN') {
            $isbn = substr($isbn, 4);
        }

        /* remove cosmetic chars and different type of spaces */
        $isbn = str_replace(array('-', ' ', '\t', '\n'), '', $isbn);

        /* take the length to check and differ between versions
         * sothat a syntaxcheck can be made */
        $l = strlen($isbn);
        if ($l != 10 && $l != 13) {
            return false;
        } elseif ($l == 10) {
            if (!preg_match('/^[0-9]{9}[0-9X]$/', $isbn)) {
                return false;
            }
        } elseif ($l == 13) {
            if (!ctype_digit($isbn)) {
                return false;
            }
        }
        return $isbn;
    }
    // }}}

    // {{{ _normaliseISBNremoveLangSpecific()
    /**
     * helper function for _normaliseISBN to
     * remove lang sepcific ISBN prefix
     *
     * @param string $isbn ISBN String to check (partially normalised)
     *
     * @return string   input value passed through helper
     *
     * @access private
     */
    private static function _normaliseISBNremoveLangSpecific($isbn)
    {
        $lang = strtoupper(ISBN_DEFAULT_PRINT_LANG_SPECIFIC_PREFIX);
        $l    = strlen($lang);
        if ($l > 0 ) {
            if (substr($isbn, 0, $l) == $lang) {
                $isbn = substr($isbn, $l);
            }
        }
        return $isbn;
    }
    // }}}

    // {{{ convert()
    /**
     * converts an ISBN number from one version to another
     * can convert ISBN-10 to ISBN-13 and ISBN-13 to ISBN-10
     * 
     * @param string  $isbnin  ISBN to convert, must be a valid ISBN Number
     * @param integer $verfrom version value of the input ISBN
     * @param integer $verto   version value to convert to
     *
     * @return string|false converted ISBN Number or false if conversion failed
     */
    public static function convert($isbnin, $verfrom = ISBN_VERSION_ISBN_10, 
                                   $verto = ISBN_VERSION_ISBN_13)
    {
        /* validate input */
        if (!self::_isbnVersionIsValid($verfrom)) {
            return false;
        }
        if (!self::_isbnVersionIsValid($verto)) {
            return false;
        }
        $r = self::validate($isbnin, $verfrom);
        if ($r === false) {
            return false;
        }
        /* normalize input */
        $isbnn = self::_normaliseISBN($isbnin);
        /* input is ok now, let's convert */
        switch(true) {
        case $verfrom == ISBN_VERSION_ISBN_10 && $verto == ISBN_VERSION_ISBN_13:
            /* convert 10 to 13 */
            $isbnbody = self::_extractISBNBody($isbnn);
            if ($isbnbody === false) {
                return false;
            }
            $isbnout = '978' . $isbnbody . self::_checkdigitISBN13($isbnbody);
            return $isbnout;
        case $verfrom == ISBN_VERSION_ISBN_13 && $verto == ISBN_VERSION_ISBN_10:
            /* convert 13 to 10 */
            $isbnbody = self::_extractISBNBody($isbnn);
            if ($isbnbody === false) {
                return false;
            }
            $isbnout = $isbnbody . self::_checkdigitISBN10($isbnbody);
            return $isbnout;
        case $verfrom == $verto:
            /* version is the same so there is no need to convert */
            /* hej, praktisch! */           
            return $isbnn;              
        }        
        return false;
    }
    // }}}

    // {{{ getCheckdigit()
    /**
     * Get the Checkdigit Part of ISBN Number
     *
     * @return string|false Checkdigit or false if failed
     */
    public function getCheckdigit()
    {
        $ver   = $this->getVersion();
        $check = false;

        switch ($ver) {
        case ISBN_VERSION_ISBN_10:
            $check = self::_checkdigitISBN10($this->_getISBNBody());
            break;

        case ISBN_VERSION_ISBN_13:
            $check = self::_checkdigitISBN13($this->_getISBNBody());
            break;

        }

        return $check;
    }
    // }}}

    // {{{ getEAN()
    /**
     * Get the EAN Prefix of ISBN Number (ISBN-13)
     *
     * @return string|false EAN Prefix or false if failed
     */
    public function getEAN()
    {
        $ver = $this->getVersion();
        if ($ver === false ) {
            return false;
        }
        if ($ver == ISBN_VERSION_ISBN_13_978) {
            return '978';
        }
        if ($ver == ISBN_VERSION_ISBN_13_979) {
            return '979';
        }
        return '';
    }
    // }}}

    // {{{ getGroup()
    /**
     * Get the Registrationgroup Part of the ISBN Number
     *
     * @return string|false Group Identifier or false if failed
     */
    public function getGroup()
    {
        return $this->isbn_group;
    }
    // }}}

    // {{{ _setGroup()
    /**
     * Setter for the Registrationgroup Part of the ISBN Number
     *
     * @param string $group Registrationsgroup to set
     * 
     * @return void 
     * 
     * @throws ISBN_Exception in case it fails
     */
    private function _setGroup($group)
    {
        if (is_string($group) == false) {
            #throw new ISBN_Exception('Wrong Vartype');
        }
        $l = strlen($group);
        if ($l < 1 || $l > 5) {
            #throw new ISBN_Exception('Wrong Group Length (' . $l . ')');
        }
        $testbody  = substr($group . '000000000', 0, 9);
        $testgroup = self::_extractGroup($testbody);
        if ($testgroup === false ) {
            #throw new ISBN_Exception('Invalid Group');
        }
        if ($testgroup != $group) {
            #throw new ISBN_Exception('Invalid Group');
        }        
        $this->isbn_group = $group;
    }

    // {{{ getISBN()
    /**
     * Get whole ISBN Number
     *
     * @return string ISBN Number (unformatted); empty string if this is 
     *                not a valid ISBN
     */
    public function getISBN()
    {
        $ver = $this->getVersion();
        if ($ver === false ) {
            return '';
        }

        $isbn = '';

        $r = self::_isbnVersionIsValid($ver);
        if ($r === false ) {
            return $isbn;
        }

        $isbn .= $this->getEAN();
        $isbn .= $this->_getISBNBody();
        $isbn .= $this->getCheckdigit();

        return $isbn;
    }
    // }}}
    
    // {{{ getISBNDisplayable()
    /**
     * Get whole ISBN Number in a displayable fashion (see Handbook p. 15)
     *
     * @param string $format Formatstring 1-4 Chars:
     *               each character is a control char:
     *               #1 i or not: use international pre-prefix
     *               #2 i or not: "ISBN" in front or v: incl. version
     *               #3 : or not: insert a ":"
     *               #4 - or not: use - after EAN (ISBN 13 only)
     *               #4 or =: use - between each ISBN part
     *               Example 1:
     *                  '   --' 978-0-385-33941-4
     *                  classic displayable ISBN
     *               Example 2: 
     *                  ' v:-' ISBN-13: 978-0385339414 
     *                  ISBN-Format used by amazon
     *               Example 3: 
     *                  'iv:=' ISBN-13: 978-0-385-33941-4  
     *                  full blown: more is more!
     *   
     * @return string ISBN Number (formatted); empty string if this is 
     *                not a valid ISBN
     */    
    public function getISBNDisplayable($format = '')
    {
        if ( strlen($format)==0 ) {
            $format = 'iv:='; //edit $this->ISBNFormatstring;
        }
        $format = substr($format . '    ', 0, 4);
        
        $ver = $this->getVersion();
        if ($ver === false ) {
            return '';
        }

        $isbn = '';

        $r = self::_isbnVersionIsValid($ver);
        if ($r === false ) {
            return $isbn;
        }

        if ($format[0] == 'i') {
            $isbn .= ISBN_DEFAULT_PRINT_LANG_SPECIFIC_PREFIX;
            if (strlen($isbn)) $isbn .= ' ';
        }
        
        if ($format[1] == 'i' || $format[1] == 'v') {
            $isbn .= 'ISBN';
            if ($format[1] == 'v') {
                switch ($ver) {
                case ISBN_VERSION_ISBN_10:
                    $isbn .= '-10';
                    break;
                case ISBN_VERSION_ISBN_13:
                    $isbn .= '-13';
                    break;
                }               
            }
        }
        
        if ($format[2] == ':') {
            $isbn .= ':';
        }
        
        if (strlen($isbn)) {
            $isbn .= ' ';
        }
        
        if ($ver == ISBN_VERSION_ISBN_13_978 || $ver == ISBN_VERSION_ISBN_13_979) {
            $isbn .= $this->getEAN();
            if ($format[3] == '-' || $format[3] == '=') {
                $isbn .= ISBN_DEFAULT_COSMETIC_SEPERATOR;
            }
        }
        
        $seperator = ($format[3] == '=') ? ISBN_DEFAULT_COSMETIC_SEPERATOR : '';
                
        $isbn .= $this->getGroup() . $seperator;
        $isbn .= $this->getPublisher() . $seperator;
        $isbn .= $this->getTitle() . $seperator;        
        $isbn .= $this->getCheckdigit();

        return $isbn;
        
    }
    // }}}

    // {{{ setISBN()
    /**
     * Setter for ISBN
     *
     * @param string $isbn ISBN Number
     *          this is a valid ISBN Number or it is an Empty string
     *          which will reset the class
     * 
     * @return void
     * 
     * @throws ISBN_Exception in case it fails
     * 
     */
    public function setISBN($isbn)
    {
        if ($isbn == '') {
            $this->ver            = ISBN_VERSION_NONE;
            $this->isbn_group     = '';
            $this->isbn_publisher = '';
            $this->isbn_title     = '';
        } else {
            $isbnn = self::_normaliseISBN($isbn);
            $ver   = self::_getVersion($isbnn);
            if ($ver === false) {
                throw new ISBN_Exception('Invalid ISBN');
            }
            if ($ver != $this->ver and $this->ver !== ISBN_VERSION_NONE) {
                throw new ISBN_Exception(
                  'ISBN Version of passed ISBN (' . $ver . ') '.
                  'does not match existing (' . $this->ver . ').'
                );
            } elseif ($this->ver === ISBN_VERSION_NONE) {
                $this->ver = $ver;
            }
            $body = self::_extractISBNBody($isbnn);
            if ($body === false) {
                throw new ISBN_Exception('Invalid ISBN (could not extract body)');
            }
            try {
                $this->_setISBNBody($body);
            } catch (ISBN_Exception $e) {
                throw new ISBN_Exception(
                    'Invalid ISBN (invalid body "' . $body . '")', $e
                );
            }
        }
    }
    // }}}

    // {{{ _getISBNBody()
    /**
     * _getISBNBody()
     *
     * @return string ISBN Body (not an offical term)
     */
    private function _getISBNBody()
    {
        $body  = '';
        $body .= $this->getGroup();
        $body .= $this->_getISBNSubbody();
        return $body;
    }
    // }}}

    // {{{ _setISBNBody()
    /**
     * _setISBNBody()
     *
     * Setter for ISBNBody
     *
     * @param string $body ISBNBody
     * 
     * @return void
     * 
     * @throws ISBN_Exception in case it fails 
     */
    private function _setISBNBody($body)
    {
        /* validate parameter */
        if (is_string($body) == false) {
            throw new ISBN_Exception('Not a Body: wrong variabletype');
        }
        if (strlen($body) != 9) {
            throw new ISBN_Exception('Not a Body: wrong body length');
        }
        if (ctype_digit($body) !== true) {
            throw new ISBN_Exception('Not a Body: syntactically not a body');
        }

        /* validate body by extracting and validating parts */
        $group   = false;
        $subbody = false;

        $r = self::_isbnBodyParts($body, $group, $subbody);
        if ($r == false) {
            #throw new ISBN_Exception('Invalid Body');
        }
        
        
        $this->_setGroup($group);
        

        
        $this->_setISBNSubbody($subbody);
        
        
    }
    // }}}

    // {{{ _getISBNSubbody()
    /**
     * Get ISBNSubbody ()
     *
     * @return ISBN Subbody
     */
    private function _getISBNSubbody()
    {
        $subbody  = '';
        $subbody .= $this->getPublisher();
        $subbody .= $this->getTitle();
        return $subbody;
    }
    // }}}

    // {{{ _setISBNSubbody()
    /**
     * _setISBNSubbody
     *
     * Setter for the ISBN Subbody
     *
     * @param string $subbody ISBN Subbody
     * 
     * @return void
     * 
     * @throws ISBN_Exception in case it fails
     */
    private function _setISBNSubbody($subbody)
    {
        /* validate parameter */
        if (is_string($subbody) == false) {
            #throw new ISBN_Exception('Wrong Vartype');
        }
        $l = strlen($subbody);
        if ( $l < 4 || $l > 8) {
            #throw new ISBN_Exception('Not a Subbody by length');
        }
        /* validate by setting apart */
        $registrant  = false;
        $publication = false;
        $groupid     = intval($this->isbn_group);
        
        $r = self::_isbnSubbodyParts($subbody, $groupid, $registrant, $publication);
        if ($r === false) {
            #throw new ISBN_Exception('Can\'t break');
        }
        /* edit+ setter/getter for Registrant/Publisher and Title/Publication */
        $this->isbn_publisher = $registrant;
        $this->isbn_title     = $publication;
    }

    // {{{ getPublisher()
    /**
     * Get the Publication Part of the ISBN Number
     *
     * @return string|false Publisher or false if failed
     */
    public function getPublisher()
    {
        return $this->isbn_publisher;
    }
    // }}}

    // {{{ getTitle()
    /**
     * Get the Title Part of the ISBN Number
     *
     * @return string|false Title or false if failed
     */
    public function getTitle()
    {
        return $this->isbn_title;
    }
    // }}}


    // {{{ isValid()
    /**
     * Returns this ISBN validity
     *
     * @return boolean
     */
    public function isValid()
    {
        $isbn = $this->getISBN();
        $r    = self::validate($this->getISBN(), $this->getVersion());
        return (bool) $r;
    }

    // {{{ validate()
    /**
     * Validates an ISBN
     * 
     * @param string  $isbn ISBN to validate
     * @param integer $ver  ISBN-Version to validate against
     *
     * @return integer|false    Version value of a valid ISBN or false 
     *                          if it did not validate
     */
    public static function validate($isbn, $ver = ISBN_DEFAULT_INPUTVERSION)
    {
        $r = self::_isbnVersionIs($ver);
        if ($r === false) {
            return false;
        }
        if ($ver === ISBN_VERSION_UNKNOWN) {
            $ver = self::_isbnVersionGuess($isbn);
        }
        if (self::_isbnVersionIsValid($ver) === false) {
            return false;
        }
        $r = self::_isIsbnValid($isbn, $ver);
        if ($r === false) {
            return false;
        }
        return $ver;
    }
    // }}}

    // {{{ getVersion()
    /**
     * Returns version of this objects ISBN
     *
     * @return integer|false  Version value or ISBN_VERSION_NONE
     */
    public function getVersion()
    {
        return $this->ver;
    }


    // {{{ guessVersion()
    /**
     * Guesses ISBN version of passed string
     *
     * Note: This is not Validation. To get the validated
     * version of an ISBN Number use self::validate();
     *     
     * @param string $isbn ISBN Number to guess Version of
     * 
     * @return integer|false    Version Value or false if failed
     * 
     * @see validate();
     */
    public static function guessVersion($isbn)
    {
        $r = self::_isbnVersionGuess($isbn);
        return $r;
    }
    // }}}

}
?>