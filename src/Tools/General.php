<?php

// Namespace
namespace WarezAddict\Tools;

// Utilz Class
class General
{
    // Clean POST Data
    public static function cleanData($data)
    {
        $clean = filter_var($data, FILTER_SANITIZE_STRING);
        return $clean;
    }

    public static function sanitize($text)
    {

        // Transliterate the text/string to US ASCII
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // Lowercase text/string
        $text = strtolower($text);

        // Only allow a to z and/or 0 to 9
        $text = preg_replace('/([^a-zA-Z 0-9]+)/', '', $text);

        // Trim whitespace
        $text = trim($text);

        // Return cleaned text/string
        return $text;
    }

    /**
     * Timestamp
     *
     * Current Universal Time in the specified format.
     *
     * @static
     * @param  string $format format of the timestamp
     * @return string $timestamp formatted timestamp
     */
    public static function timestamp($format = 'Y-m-d H:i:s')
    {
        return gmdate($format);
    }

    /**
     * Truncate a string to a specified length without cutting a word off.
     *
     * @param   string  $string  The string to truncate
     * @param   integer $length  The length to truncate the string to
     * @param   string  $append  Text to append to the string IF it gets
     *                           truncated, defaults to '...'
     * @return  string
     */
    public static function safe_truncate($string, $length, $append = '...')
    {
        $ret        = substr($string, 0, $length);
        $last_space = strrpos($ret, ' ');

        if ($last_space !== false && $string != $ret) {
            $ret     = substr($ret, 0, $last_space);
        }

        if ($ret != $string) {
            $ret .= $append;
        }

        return $ret;
    }

    /**
     * Truncate the string to given length of characters.
     *
     * @param string  $string The variable to truncate
     * @param integer $limit  The length to truncate the string to
     * @param string  $append Text to append to the string IF it gets
     *                        truncated, defaults to '...'
     * @return string
     */
    public static function limit_characters($string, $limit = 100, $append = '...')
    {
        if (mb_strlen($string) <= $limit) {
            return $string;
        }

        return rtrim(mb_substr($string, 0, $limit, 'UTF-8')) . $append;
    }

    /**
     * Truncate the string to given length of words.
     *
     * @param $string
     * @param $limit
     * @param string $append
     * @return string
     */
    public static function limit_words($string, $limit = 100, $append = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $limit . '}/u', $string, $matches);

        if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
            return $string;
        }

        return rtrim($matches[0]).$append;
    }

    public static function onlyNum($input)
    {
        $inputA = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        $inputB = preg_replace('/(-)/', '', $inputA);
        $inputC = preg_replace('/[^1-9]/', '', $inputB);
        if (is_numeric($inputC)) {
            return (int)$inputC;
        }
        // NOT Numeric
        return false;
    }

    public static function makeSlug($string = '')
    {
        $string = iconv('utf-8', "us-ascii//TRANSLIT", $string);
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return trim($string, '-');
    }

    /**
     * Is Empty
     *
     * Checks if a string is empty. PHP's empty() returns true for a string
     * of "0"... and also doesn't apply trim() to the value to ensure it's
     * not just a bunch of spaces!
     *
     * @static
     * @param  string $value string(s) to be checked
     * @return boolean whether or not the string is empty
     */
    public static function isEmpty()
    {
        foreach (func_get_args() as $value) {
            if (trim($value) == '') {
                return true;
            }
        }

        return false;
    }

    // Pretty JSON
    public static function prettyJson($data)
    {
        /** json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); **/
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    }

    /**
     * Convert Timestamp
     *
     * @param  string $dateTime Epoch Timestamp from time()
     * @return string           Pretty Timestamp!
     *
     */
    public static function convertTimestamp($dateTime)
    {
        $newTimestamp = date('m-d-Y g:i:s A', $dateTime);
        return $newTimestamp;
    }

    private function getCsv($dir = dirname(__DIR__, 2) . '/data/')
    {
        $files = [];
        $dh = opendir($dir);
        if ($dh === false) {
            //throw new InvalidArgumentException('Could not open directory');
            return false;
        }
        while (($file = readdir($dh)) !== false) {
            //if ($file == '.' or $file == '..' or substr($file, -4) !== '.csv') {
            if (substr($file, -4) !== '.csv') {
                continue;
            }
            $files[] = $file;
        }
        closedir($dh);
        return $files;
    }

    /**
     * Does string start with a substring?
     *
     * @param string $haystack Given string
     * @param string $needle   String to search at the beginning of $haystack
     * @param bool   $case     Case sensitive
     *
     * @return bool True if $haystack starts with $needle.
     *
     */
    public static function startsWith($haystack, $needle, $case = true)
    {
        if ($case) {
            return (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
        }
        return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
    }

    /**
     * Tells if a string ends with a substring
     *
     * @param string $haystack Given string.
     * @param string $needle   String to search at the end of $haystack.
     * @param bool   $case     Case sensitive.
     *
     * @return bool True if $haystack ends with $needle.
     *
     */
    public static function endsWith($haystack, $needle, $case = true)
    {
        if ($case) {
            return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
        }
        return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
    }

    /**
     * htmlspecialchars() wrapper, supports multidimensional array of strings
     *
     * @param mixed $input Data to escape: single string or rray of strings
     *
     * @return string escaped
     *
     */
    public static function escape($input)
    {
        if (is_bool($input)) {
            return $input;
        }

        if (is_array($input)) {
            $out = array();
            foreach ($input as $key => $value) {
                $out[$key] = escape($value);
            }
            return $out;
        }
        return htmlspecialchars($input, ENT_COMPAT, 'UTF-8', false);
    }

    /**
     * Unescape stuff
     *
     * @param string $str the string to unescape
     *
     * @return string unescaped string
     *
     */
    public static function unescape($str)
    {
        return htmlspecialchars_decode($str);
    }

    /**
     * Generates API Key
     *
     * Note: methods used here are predictable and NOT secure
     * or suitable for crypto!
     *
     * USE WITH CAUTION! YOU HAVE BEEN WARNED!
     *
     * PHP 7 provides random_int(), designed for crypto, bro
     *
     * @param string $username Username
     * @param string $salt     Password hash salt
     *
     * @return string|bool Generated API secret, 12 char length
     *
     */
    public static function generate_api_secret($username, $salt)
    {
        if (empty($username) || empty($salt)) {
            return false;
        }

        return str_shuffle(substr(hash_hmac('sha512', uniqid($salt), $username), 10, 12));
    }

    /**
     * Replaces multi whitespaces with a single space
     *
     * @param string $string Input string
     *
     * @return mixed Normalized string
     *
     */
    public static function normalize_spaces($string)
    {
        return preg_replace('/\s{2,}/', ' ', trim($string));
    }

    /**
     * Check if input is integer, no matter its real type
     *
     * PHP is shitty at this...
     * is_int() - returns false if input is a string
     * ctype_digit() - returns false if input is integer OR negative
     *
     * @param mixed $input value
     *
     * @return bool true if the input is an integer, false otherwise
     *
     */
    public static function is_integer_mixed($input)
    {
        if (is_array($input) || is_bool($input) || is_object($input)) {
            return false;
        }
        $input = strval($input);
        return ctype_digit($input) || (self::startsWith($input, '-') && ctype_digit(substr($input, 1)));
    }

    /**
     * Convert 16 Megabytes (16M) to bytes
     *
     * @param string $val Size expressed in string
     *
     * @return int Size expressed in bytes
     *
     */
    public static function return_bytes($val)
    {
        if (self::is_integer_mixed($val) || $val === '0' || empty($val)) {
            return $val;
        }
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        $val = intval(substr($val, 0, -1));
        switch ($last) {
            case 'g':
                $val *= 1024;
                break;
            case 'm':
                $val *= 1024;
                break;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }

    /**
     * Convert ugly bytes to pretty, human readable size
     *
     * @param int $bytes value
     *
     * @return string Human readable size
     *
     */
    public static function human_bytes($bytes)
    {
        if ($bytes === '') {
            return t('Setting not set');
        }
        if (! self::is_integer_mixed($bytes)) {
            return $bytes;
        }
        $bytes = intval($bytes);
        if ($bytes === 0) {
            return t('Unlimited');
        }

        $units = [t('B'), t('kiB'), t('MiB'), t('GiB')];
        for ($i = 0; $i < count($units) && $bytes >= 1024; ++$i) {
            $bytes /= 1024;
        }

        return round($bytes) . $units[$i];
    }
}
