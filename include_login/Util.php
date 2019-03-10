<?php
require_once "DBController.php";
class Util {
    public function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i ++) {
            $token .= $codeAlphabet[$this->cryptoRandSecure(0, $max)];
        }
        return $token;
    }
    
    public function cryptoRandSecure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) {
            return $min; // not so random...
        }
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }
    
    public function redirect($url) {
        header("Location:" . $url);
        exit;
    }
    
    public function clearAuthCookie() {
        // get session parameters
        $params = session_get_cookie_params();

        // Delete the actual cookie.
        setcookie(session_name(),'', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        if (isset($_COOKIE["user_login"])) {
            setcookie("user_login", "", time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        if (isset($_COOKIE["random_password"])) {
            setcookie("random_password", "", time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        if (isset($_COOKIE["random_selector"])) {
            setcookie("random_selector", "", time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        if (isset($_COOKIE["user_hash"])) {
            setcookie("user_hash", "", time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }



    }

    function delete_rows($user_id, $ip) {
        //delete login-attempts from users ip.
        $pdo = new DBController();
        $query = "DELETE FROM logginn_forsok WHERE bruker_id = :user_id and ip = :ip";
        $param_value_array = array(':user_id' => $user_id, ':ip' => $ip);
        $pdo->update($query, $param_value_array);
    }

    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function captchaCheck(){
        //deploy captcha if to many tries.
        $ip = $this->getRealIpAddr();
        $pdo = new DBController();
        $now = time();
        $valid_attempts = $now - (60 * 60);
        $query = "SELECT count(ip) AS feilet_forsok
                              FROM logginn_forsok
                              WHERE ip = :ip
                              AND tid > :valid_attempts";
        $param_value_array = array(':ip' => $ip, ':valid_attempts' => $valid_attempts);
        $result = $pdo->runQuery($query, $param_value_array);

        $count = $result[0]['feilet_forsok'];

        if($count>2) {
            return true;
        }
        else return false;
    }

    /*function ipBanned(){
        //no login if to many tries from ip
        $ip = $this->getRealIpAddr();
        $db_handle = new DBController();
        $query = "SELECT count(ip) AS feilet_forsok
                              FROM logginn_forsok
                              WHERE ip = ?";
        $result = $db_handle->runQuery($query, "s", array($ip));
        $count = $result[0]['feilet_forsok'];

        if($count>4) {
            return false;
        }
        else return true;
    }*/

    function checkbrute($user_id) {
        $db_handle = new DBController();
        $now = time();

        // All login attempts are counted from the past 2 hours.
        $valid_attempts = $now - (10 * 60);
        $ip = $this->getRealIpAddr();
        $query = "SELECT count(tid) as tid 
              FROM logginn_forsok 
              WHERE bruker_id = :user_id AND tid > :valid_attempts AND ip = :ip";
        $param_value_array = array(':user_id' => $user_id, ':valid_attempts' => $valid_attempts, ':ip' => $ip);
        $result = $db_handle->runQuery($query, $param_value_array);
        $count = $result[0]['tid'];
        // If there have been more than 5 failed logins
        if ($count > 5) {
            return true;
        } else {
            return false;
        }

    }

}
?>