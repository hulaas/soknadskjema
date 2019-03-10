
<?php
require_once 'DBController.php';
include_once 'functions.php';
require '../autoload.php';
require 'Auth.php';

/*sec_session_start(); // Custom secure way of starting a PHP session.*/
session_start();

require_once "../include_login/authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ../");
}


$db_handle = new DBController();
$util = new Util();
$auth = new Auth();

// CAPTCHA TEST KEYS
$siteKey = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';
$secret = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';


//Legal keys



$isSet = false;
$isCaptchaSet = false;

if($util->captchaCheck() == true) {
/////////////////////////
    $isSet = true;
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);

    $gRecaptchaResponse = $_POST['g-recaptcha-response']; //google captcha post data
    $remoteIp = $_SERVER['REMOTE_ADDR']; //to get user's ip

    $recaptchaErrors = ''; // blank varible to store error

    $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp); //method to verify captcha
    if ($resp->isSuccess()) {
        $isCaptchaSet = true;
    }
    else $isCaptchaSet = false;
}

if (isset($_POST['email'], $_POST['p'])) {

    $isAuthenticated = false;

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['p']; // The hashed password.


    if($isCaptchaSet == true and $isSet == true or $isSet == false) {

        if($auth->authenticate_login($email, $password) == true){

            $isAuthenticated = true;

        }
        if ($isAuthenticated) {
            $id = $auth->getIDbyEmail($email);
            $user_id = $id[0]['id'];




            $user = $auth->getUserByID($user_id);
            /*$user_id = preg_replace("/[^0-9]+/", "", $user,_id);*/

            $current_time = time();
            $domain = $_SERVER['HTTP_HOST'];

            $hash = hash('sha512',$email . $current_time . $user_id . $domain);
            $auth->deleteHash($user_id);
            $auth->insertHash($user_id, $hash);

            setcookie("user_hash", $hash, 0, '/', $domain, FALSE, TRUE);
            setcookie("user_login", $user_id, 0, '/', $domain, FALSE, TRUE);
            // Set Auth Cookies if 'Husk meg' checked
            if (! empty($_POST["remember"])) {
                $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  // for 1 month
                $random_password = $util->getToken(16);
                $random_selector = $util->getToken(32);
                setcookie("user_login", $user_id, $cookie_expiration_time, '/', $domain, FALSE, TRUE);


                setcookie("random_password", $random_password, $cookie_expiration_time, '/', $domain, FALSE, TRUE);


                setcookie("random_selector", $random_selector, $cookie_expiration_time, '/', $domain, FALSE, TRUE);

                $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
                $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);


                /*die(var_dump($user_id));*/
                // mark existing token as expired
                $userToken = $auth->getTokenByID($user_id, 0);
                /*die(var_dump($userToken));*/
                if (! empty($userToken[0]["bruker_id"])) {
                    $auth->deleteToken($user_id);
                }
                // Insert new token
                $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
                $auth->insertToken($user_id, $random_password_hash, $random_selector_hash, 0 , $expiry_date);
            } else {
                $util->clearAuthCookie();
                $auth->deleteToken($user_id);
            }
            $util->redirect("../dashboard/");
        } else {
            setcookie("message", 'E-post eller passord er feil.', time()+10, '/');
            header('Location: ../');

        }

    } else {
        // Login failed
        setcookie("message", 'Du må verifisere captcha.', time()+10, '/');
        header('Location: ../');
    }
}
else {
    if($isSet == true) {
        $recaptchaErrors = $resp->getErrorCodes(); // set the error in varible
        setcookie("message", $recaptchaErrors, time()+10, '/');
        header('Location: ../');

    }
    else {
        setcookie("message", 'Du må fylle inn alle felter.', time()+10, '/');
        header('Location: ../');
    }

}

?>




