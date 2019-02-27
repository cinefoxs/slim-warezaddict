<?php

// Namespace
namespace WarezAddict;

/**
 * Info Class
 *
 * Get web browser info and IP of a user
 *
 */
class Info
{
    /**
     * Get Browser Info
     *
     * @return array Array of browser info
     *
     */
    public static function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        // Get Platform
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'Linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'Mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'Windows';
        }

        // Get Useragent Name, Seperately
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // Get Version Number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // No Match, So Continue...
        }

        // How Many?
        $i = count($matches['browser']);

        if ($i != 1) {
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // Have A Number?
        if ($version == null || $version == "") {
            $version = "?";
        }

        // Return All Data
        $browserInfo = [
            'Platform' => $platform,
            'Browser' => $bname,
            'UserAgent' => $u_agent,
            'Version' => $version,
            //'pattern' => $pattern,
        ];
        return $browserInfo;
    }

    /**
     * Get Users IP
     *
     * @return string IP Address of the user
     *
     */
    public static function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //$userIp = htmlspecialchars($_SERVER['HTTP_CLIENT_IP']);
            $userIp = filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //$userIp = htmlspecialchars($_SERVER['HTTP_X_FORWARDED_FOR']);
            $userIp = filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP);
        } else {
            //$userIp = htmlspecialchars($_SERVER['REMOTE_ADDR']);
            $userIp = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        }
        return $userIp;
    }

    public static function userInfo($json = false)
    {
        $ip = ['IP' => self::getIp()];
        $browser = self::getBrowser();

        $data = array_merge($ip, $browser);

        if ($json) {
            return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
        }
        return $data;
    }
}
