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
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bytt passord</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <script type="text/JavaScript" src="../js_login/sha512.js"></script>



    <style>
        #current_password {
            margin-bottom: 50px;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="col-sm-6 col-sm">

        <h1>Bytt Passord</h1>
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
        <form id="passwordform" action="../include_dashboard/process_change_pw.php" method="post">
            <div class="form-group">
                <input type="password" name="current_password" class="form-control input_pass" value="" id="current_password" placeholder="Nåværende passord" autofocus autocomplete="off">
            </div>
            <div class="form-group">
                <input type="password" name="new_password" class="form-control input_pass" value="" id="new_password" placeholder="Nytt passord" autocomplete="off">
            </div>


            <div class="d-flex">
                <div class="col-sm-6">
                    <span id="8char" class="fas fa-times" style="color:#FF0004;"></span> Minimum 8 tegn<br>
                    <span id="ucase" class="fas fa-times" style="color:#FF0004;"></span> En stor bokstav
                </div>
                <div class="col-sm-6">
                    <span id="lcase" class="fas fa-times" style="color:#FF0004;"></span> En liten bokstav<br>
                    <span id="num" class="fas fa-times" style="color:#FF0004;"></span> Ett nummer
                </div>
            </div>



            <div class="form-group">
                <input type="password" name="confirm_password" class="form-control input_pass" value="" id="confirm_password" placeholder="Bekreft passord" autocomplete="off">
                <span id="pwmatch" class="fas fa-times" style="color:#FF0004;"></span> Passordet samsvarer
            </div>

            <div class="d-flex">
                <div class="col-sm-6">
                    <input type="button"
                           class="btn save_btn"
                           value="Gå tilbake"
                           onclick="location.href = '/dashboard/'" />
                </div>
                <div class="col-sm-6">
                    <input type="button"
                           class="btn save_btn"
                           value="Lagre passord"
                           onclick="return changepwformhash(this.form,
                                                       this.form.current_password,
                                                       this.form.new_password,
                                                       this.form.confirm_password);" />
                </div>
            </div>




        </form>
    </div>
</div>

</body>
<script type="text/JavaScript" src="validate.js"></script>
<script type="text/JavaScript" src="../js_login/forms.js"></script>
</html>