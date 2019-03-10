<?php

/*include_once "../include_login/functions.php";*/
require_once "../include_login/Auth.php";

/*sec_session_start();*/

session_start();

$pdo = new DBController();
$util = new Util();

//FOR USER FEEDBACK
$auth = new Auth();



require_once "../include_login/authCookieSessionValidate.php";


if ($isLoggedIn) {

    $util->redirect("../dashboard/");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ringerike Kommune Valgsystem</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--<script src="../js/jquery.min.js"></script>-->
    <script type="text/JavaScript" src="../js_login/sha512.js"></script>
    <script type="text/JavaScript" src="../js_login/forms.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link href="stylesheet/stylesheet.css" rel="stylesheet">
    <style>
        <?php if($util->captchaCheck($pdo) == true && isset($_COOKIE['message'])) { ?>
        .user_card {
            height: 540px;
        }

    <?php } else if($util->captchaCheck($pdo) == true) { ?>
            .user_card {
            height: 470px;
        }
            <?php
    } else if(isset($_COOKIE['message'])) { ?>
        .user_card {
            height: 445px;
        }
        <?php }?>
        </style>

</head>
<body>

<div class="container h-100">

    <div class="d-flex justify-content-center h-100">

        <div class="user_card">

            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <img src="../images/logo.svg" class="brand_logo" alt="Logo">
                </div>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form id="loginform" action="../include_login/process_login.php" method="post">



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


                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="email" name="email" class="form-control input_user" value="" id="email" placeholder="epost" autofocus>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control input_pass" value="" id="password" placeholder="passord">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" id="customControlInline">
                            <label class="custom-control-label" for="customControlInline">Husk meg</label>
                        </div>
                    </div>
                    <?php if($util->captchaCheck($pdo) == true) { ?>
                        <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" data-theme="dark"
                             style="transform:scale(0.92);transform-origin:0;-webkit-transform:scale(0.92);
                            transform:scale(0.92);-webkit-transform-origin:0 0;transform-origin:0 0;"></div>
                    <?php } ?>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <input class="btn login_btn"
                               type="button"
                               name="button"
                               value="Logg inn"
                               onclick="formhash(this.form, this.form.password);" />
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-center links">
                            Registrer deg for valg<a href="#" class="ml-2">SOk her</a>
                        </div>
                        <div class="d-flex justify-content-center links">
                            <a href="#">Glemt passord?</a>
                            <a href="../soknad/soknad.php">soknad</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<a href="../register/register.php">register bruker</a>
</body>
</html>
