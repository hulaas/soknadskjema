<?php

require_once "DBController.php";

/*function sec_session_start() {

    $session_name = 'secure_session';
    $secure = SECURE;

    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }

    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    // Sets the session name to the one set above.
    session_name($session_name);


    session_start();            // Start the PHP session
    session_regenerate_id();   // regenerated the session, delete the old one.
}*/

/*function getRealIpAddr()
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
}*/



/*function login($email, $password) {
    $db_handle = new DBController();
    // Using prepared statements means that SQL injection is not possible.
    $query = "SELECT id, passord, salt FROM brukere WHERE epost = ? LIMIT 1";
    $result = $db_handle->runQuery($query, 's', array($email));
    if ($result != NULL) {
        $user_id = $result[0]['id'];
        $user_password = $result[0]['passord'];
        $user_salt = $result[0]['salt'];

        // hash the password with the unique salt.
        $password = hash('sha512', $password . $user_salt);

        // get ip from user.
        $ip = getRealIpAddr();

        if ($result != NULL) {
            // If the user exists we check if the account is locked
            // from too many login attempts
            if (checkbrute($user_id) == true) {
                // Account is locked
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                /*die(var_dump($db_password == $password));*/
                /*die(var_dump($password));

                if ($user_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    // XSS protection as we might print this value
                    $email = preg_replace("#^[^\.][\w-\.]{1,64}[^\.]@([\w-\.]*)(\.\w{2,6})$#i", "", $email);
                    $_SESSION['email'] = $email;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);

                    delete_rows($user_id, $ip);

                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $query = "INSERT INTO logginn_forsok(bruker_id, ip, tid) VALUES (?, ?, ?)";
                    $db_handle->insert($query, "sss", array($user_id, $ip, $now));
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }
}*/

/*function checkbrute($user_id) {
    $db_handle = new DBController();
    $now = time();

    // All login attempts are counted from the past 2 hours.
    $valid_attempts = $now - (2 * 60 * 60);
    $query = "SELECT count(tid) as tid 
              FROM logginn_forsok 
              WHERE bruker_id = ? AND tid > ?";
    $result = $db_handle->runQuery($query, "i", array($user_id, $valid_attempts));
    if ($result != NULL) {

        $count = $result[0]['tid'];

        // If there have been more than 5 failed logins
        if ($count > 5) {
            return true;
        } else {
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=feil2");
        exit();
    }
}*/

/*function login_check() {
    $db_handle = new DBController();

    // Check if all session variables are set
    if (isset($_SESSION['user_id'], $_SESSION['email'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $email = $_SESSION['email'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        $query = "SELECT passord FROM brukere WHERE id = ? LIMIT 1";
        $result = $db_handle->runQuery($query, "i", array($user_id));

        if ($result != NULL) {
            // If the user exists get variables from result.
            $password = $result[0]['passord'];
            $login_check = hash('sha512', $password . $user_browser);

            if ($login_check == $login_string) {
                // Logged In!!!!
                return true;
            } else {
                // Not logged in
                return false;
            }

        } else {
            // Could not prepare statement
            header("Location: ../error.php?err=feil");
            exit();
        }
    } else {
        // Not logged in
        return false;
    }
}*/

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

/*function delete_rows($user_id, $ip) {
    //delete login-attempts from users ip.
    $db_handle = new DBController();
    $query = "DELETE FROM logginn_forsok WHERE bruker_id = ? and ip = ?";
    $db_handle->update($query, "ss", array($user_id, $ip));
}

function captchaCheck(){
    //deploy captcha if to many tries.
    $ip = getRealIpAddr();

    $db_handle = new DBController();
    $query = "SELECT count(ip) AS feilet_forsok
                              FROM logginn_forsok
                              WHERE ip = ?
                              AND tid < (NOW() - INTERVAL 24 HOUR)";
    $result = $db_handle->runQuery($query, 's', array($ip));

    $count = $result[0]['feilet_forsok'];

    if($count>2) {
        return true;
    }
    else return false;
}

function ipBanned(){
    //no login if to many tries from ip
    $ip = getRealIpAddr();
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