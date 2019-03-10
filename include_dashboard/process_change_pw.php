<?php
require_once '../include_login/DBController.php';
require '../include_login/Auth.php';

session_start();

$pdo = new DBController();
$auth = new Auth();

$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);



if (isset($_POST['p'], $_POST['c'])) {


    $user_id = $_COOKIE['user_login'];
    $user_credentials = $auth->getPasswordByID($user_id);

    if ($user_credentials != NULL && $user_id != NULL) {

        $user_password = $user_credentials[0]['passord'];
        $user_salt = $user_credentials[0]['salt'];

        $password = hash('sha512', $_POST['c'] . $user_salt);

        if($user_password == $password) {

            $new_password = hash('sha512', $_POST['p'] . $user_salt);
            $query = "UPDATE brukere SET passord = :password WHERE id = :user_id";
            $param_value_array = array(':user_id' => $user_id, 'password' => $new_password);
            $pdo->update($query, $param_value_array);

            setcookie("message", 'Passordet er endret', time()+10, '/');
            header('Location: ../dashboard/');


        } else {
            setcookie("message", 'Nåværende passord er feil, prøv igjen', time()+10, '/');
            header('Location: ../change_pw/');
        }
    } else {
        setcookie("message", 'Cookiene dine fungerer ikke, godta cookies', time()+10, '/');
        header('Location: ../change_pw/');
    }
} else {
    setcookie("message", 'Du må fylle inn alle felter.', time()+10, '/');
    header('Location: ../change_pw/');
}
