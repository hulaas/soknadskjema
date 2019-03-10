<?php

require_once "Auth.php";

$auth = new Auth();
$db_handle = new DBController();
$util = new Util();

// Get Current date, time
$current_time = time();
$current_date = date("Y-m-d H:i:s", $current_time);

// Set Cookie expiration for 1 month
$cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  // for 1 month
$isLoggedIn = false;

if (!empty($_COOKIE["user_login"])) {
    $user_id = $_COOKIE["user_login"];
}

if (!empty($_COOKIE["user_hash"])) {
    $hash = $auth->getHashByID($user_id);
    if($_COOKIE["user_hash"] == $hash[0]['hash']) {
        $isLoggedIn = true;
    }
}

// Check if loggedin session exists
else if (! empty($_COOKIE["user_login"]) && ! empty($_COOKIE["random_password"]) && ! empty($_COOKIE["random_selector"])) {
    // Initiate auth token verification diirective to false
    $isPasswordVerified = false;
    $isSelectorVerified = false;
    $isExpiryDateVerified = false;
    
    // Get token for email
    /*die(var_dump($_COOKIE["user_login"]));*/
    $userToken = $auth->getTokenByID($_COOKIE["user_login"], 0);




    // Validate random password cookie with database
    if (password_verify($_COOKIE["random_password"], $userToken[0]["passord_hash"])) {
        $isPasswordVerified = true;
    }
    
    // Validate random selector cookie with database
    if (password_verify($_COOKIE["random_selector"], $userToken[0]["valg_hash"])) {
        $isSelectorVerified = true;
    }
    
    // check cookie expiration by date
    if($userToken[0]["utløpt_dato"] >= $current_date) {
        $isExpiryDareVerified = true;
    }

    // Redirect if all cookie based validation retuens true
    // Else, mark the token as expired and clear cookies

    /*die(var_dump($userToken[0]["passord_hash"]));*/

    if (!empty($userToken[0]["bruker_id"]) && $isPasswordVerified && $isSelectorVerified && $isExpiryDareVerified) {
        $isLoggedIn = true;

    } else {
        $auth->deleteToken($_COOKIE["user_login"]);

        // clear cookies
        $util->clearAuthCookie();
    }
}
?>