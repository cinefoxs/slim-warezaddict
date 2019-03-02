<?php

// Namespace
namespace WarezAddict\MovieDB;

// Use Libs
// use \Symfony\Component\DomCrawler\Crawler;

class Helpers
{
    // Clean User Input
    public static function clean($data)
    {
        // If Array
        if (is_array($data)) {
            $output = [];
            foreach($data as $var => $val) {
                $output[$var] = filter_var($val, FILTER_SANITIZE_STRING);
            }
            return $output;
        } else {
            // Sanitize & remove chars with ASCII value > 127
            return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        }
    }

    // Check if int and within a range
    public function checkInt($int, $min, $max)
    {
        $chk = filter_var($int, FILTER_VALIDATE_INT, array("options" => array(
            "min_range" => $min,
            "max_range" => $max,
        )));
        if ($chk) {
            // Int and within min max range
            return true;
        } else {
            // Negative Ghostrider
            return false;
        }
    }

    // Sanitize and validate email addresses
    public function checkEmail($email)
    {
        $sani = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($sani, FILTER_VALIDATE_EMAIL) === false) {
            // Valid (& Clean) Email
            return true;
        } else {
            // Thats a big ol negative!
            return false;
        }
    }

    // PDO Database Connection
    public function pdoMysql($ip, $db, $user, $pass)
    {
        // Try to connect
        try {
            // Connection
            $conn = new \PDO("mysql:host=$ip;dbname=$db", $user, $pass);
            // Exception Error Mode
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert Data
            // $sql = "INSERT INTO Favs (userId, movieId) VALUES (123, 'tt000000')";
            // Use exec() because no result expected
            // $conn->exec($sql);
            // More Info: https://www.w3schools.com/php7/php7_mysql_prepared_statements.asp
        }

        // Error No Connection
        catch (\PDOException $e) {
            $msg = ['error' => $e->getMessage()];
            return $msg;
        }
    }

    /**
     * getImdbScrapeUrl
     *
     * Generates imdb.com URL to scrape
     *
     * @param  string $query Search query
     *
     * @return string        imdb.com URL to scrape
     *
     */
    public static function getImdbUrl($query)
    {
        // TODO: Sanitize $query
        $query = preg_replace('/ /', '+', $query);

        $base = 'http://www.imdb.com/search/title?title=';
        $end  = '&title_type=feature,tv_movie,tv_series,tv_special,documentary&sort=num_votes&!genres=Adult';
        return $base . $query . $end;
    }

    /**
     * scrape
     *
     * Scrapes URL and returns HTML
     *
     * @param  string $url URL to scrape
     *
     * @return string      HTML from URL
     *
     */
    public static function scrape($url)
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Accept-Language:en;q=0.8,en-US;q=0.6'));
        curl_setopt($handle, CURLOPT_URL, str_replace(' ', '%20', $url));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

        $html = curl_exec($handle);
        curl_close($handle);

        return $html;
    }

    /**
     * public static function crawler($html)
     * {
     *     $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
     *     return $crawler;
     * }
     *
     */

    /**
     * extractYear
     *
     * Extracts the year from a file/torrent name
     *
     * @param  string $title Filename, torrent name, etc
     *
     * @return string        The year
     *
     */
    public static function extractYear($title)
    {
        if ($title) {
            // Fine XXXX Year In Title
            preg_match('/([0-9]{4})/', $title, $matches);

            // If Found
            if (isset($matches[1])) {
                // Return Year
                return $matches[1];
            }
        }
        // No Year Found
        return false;
    }

    /**
     * extractImdbId
     *
     * Extracts the IMDB ID from name/data/string
     *
     * @param  string $data String of text that may contain IMDB ID
     *
     * @return string       IMDB ID
     *
     */
    public static function extractImdbId($data)
    {
        if (! empty($data)) {
            // Find IMDB ID
            preg_match('/(tt[0-9]+)\//', $data, $matches);

            // If Found
            if (isset($matches[1])) {
                // Return IMDB ID
                return $matches[1];
            }
        }
        // Not Found
        return false;
    }

    /**
     * currentTimestamp
     *
     * Returns Current Timestamp
     *
     * @return string Current Timestamp
     *
     */
    public static function currentTimestamp()
    {
        return \Carbon\Carbon::now();
    }
}
