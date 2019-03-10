<?php
session_start();

require_once "../include_login/authCookieSessionValidate.php";

if(!$isLoggedIn) {
    header("Location: ../");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="#" />
</head>
<body>
<?php
if(isset($_COOKIE['message'])) {
    ?>
    <div class="alert alert-warning" role="alert">
        <?php
        echo $_COOKIE['message'];
        ?>
    </div>
    <?php

}
?>

<!-- Main content here -->
<p>Du er logget innæøæøå</p>


<p><a href="../change_pw/">Endre passord</a></p>


<p><a href="../include_login/logout.php">Logg ut</a></p>









</body>
</html>