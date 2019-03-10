<?php
/*include_once '../include_login/register.inc.php';*/
include_once '../include_login/functions.php';
?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Registrering av personell</title>
    <script type="text/JavaScript" src="../js_login/sha512.js"></script>
    <script type="text/JavaScript" src="../js_login/forms.js"></script>

</head>
<body>
<!-- Registration form to be output if the POST variables are not
set or if the registration script caused an error. -->
<h1>Opprett en bruker</h1>
<?php
if (!empty($error_msg)) {
    echo $error_msg;
}
?>
<ul>
    <li>Brukernavn kan bare inneholde siffer, store og små bokstaver og understreker</li>
    <li>Epost må ha et gylig epost format</li>
    <li>Passord må minst bestå av seks tegn</li>
    <li>Passord må inneholde
        <ul>
            <li>minst en stor bokstav (A..Z)</li>
            <li>minst en liten bokstav (a..z)</li>
            <li>minst ett siffer (0..9)</li>
        </ul>
    </li>
    <li>Passordet og bekreftelse må være likt</li>
</ul>
<form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>"
      method="post"
      name="registration_form">
    Brukernavn: <input type='text'
                     name='username'
                     id='username' /><br>
    Epost: <input type="text" name="email" id="email" /><br>
    Passord: <input type="password"
                     name="password"
                     id="password"/><br>
    Bekreft passord: <input type="password"
                             name="confirmpwd"
                             id="confirmpwd" /><br>
    Rolle: <input type='text'
                     name='rolle'
                     id='rolle' /><br>
    Admin: <input type='number'
                     name='admin'
                     id='admin' /><br>
    <input type="button"
           value="Registrer bruker"
           onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd,
                                   this.form.rolle,
                                   this.form.admin);" />
</form>
<p>Gå tilbake til <a href="../index.php">logg-inn siden</a>.</p>
</body>
</html>