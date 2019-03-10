
<?php


require_once 'Auth.php';
$auth = new Auth();
$util = new Util();
/*sec_session_start();*/
session_start();
$user_id = $_COOKIE['user_login'];
$auth->deleteToken($user_id);
$auth->deleteHash($user_id);

// Unset all session values 
$_SESSION = array();

// clear cookies
$util->clearAuthCookie();

/*// get session parameters
$params = session_get_cookie_params();

// Delete the actual cookie. 
setcookie(session_name(),'', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);*/

// Destroy session 
session_destroy();

setcookie("message", 'Du er logget ut', time()+10, '/');

header("Location: ../");
exit();
