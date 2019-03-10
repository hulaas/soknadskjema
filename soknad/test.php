<!DOCTYPE html>
<html lang="en">
<head>
    <title>Søknad</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<style>
    .content {
        margin-top: 1em;
        align: center;
    }


</style>
<body>

<div class="container">
    <?php if(isset($_COOKIE['message'])) { ?>
        <div class="alert alert-warning" role="alert" id="message">
            <?php echo $_COOKIE['message']; ?>
        </div>
    <?php } ?>
    <div class="content">
        <form name="soknadform" class="form-horizontal" action="Action_form.php" method="post">
            <div class="form-group">
                <label class="col-md-4 control-label">Fullt Navn</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="navn" name="navn" placeholder="Fullt navn" class="form-control" required="true" value="" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Fødsels- og personnummer</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="fodsel" name="fodsel" placeholder="Fødsels- og personnummer" class="form-control" required="true" value="" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Adresse</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input id="adresse" name="adresse" placeholder="Adresse" class="form-control" required="true" value="" type="text">
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label">By</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input id="city" name="city" placeholder="By" class="form-control" required="true" value="" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Postkode</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input id="postkode" name="postkode" placeholder="Postkode" class="form-control" required="true" value="" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Telefon nummer</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input id="telefon" name="telefon" placeholder="Telefon nummer" class="form-control" required="true" value="" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Email</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="email" name="email" placeholder="Email" class="form-control" required="true" value="" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Har du førerkort og/eller tilgang til bil?</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" id="bil" name ="bil">
                            <option>Førerkort</option>
                            <option>Bil og førerkort</option>
                            <option>Ingen</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Norskferdigheter 1-5</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" id="norskferd" name ="norskferd">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Dataferdigheter 1-5</label>
                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                        <select class="selectpicker form-control" id="dataferd" name ="dataferd">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-2 col-xs-offset-4">
                    <a href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" onclick="return validateForm();">Send søknad</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
<script>
    function validateForm() {
        var navnField = document.forms["soknadform"]["navn"].value;
        var fodselsnrField = document.forms["soknadform"]["fodsel"].value;
        var adresseField = document.forms["soknadform"]["adresse"].value;
        var cityField = document.forms["soknadform"]["city"].value;
        var postkodeField = document.forms["soknadform"]["postkode"].value;
        var telefonField = document.forms["soknadform"]["telefon"].value;
        var emailField = document.forms["soknadform"]["email"].value;


        //verifisere at ingen felter er tomme
        if (navnField == "" || fodselsnrField == "" || adresseField == "" || cityField == "" || postkodeField == "" || telefonField == "" || emailField == "") {
            alert("Alle felter må fylles");
            return false;
        }

        //verifisere fødselsnummer
        reFodsel = /^[0-9]{2}[0,1][0-9][0-9]{2}[ ]?[0-9]{5}/;
        if (!reFodsel.test(fodselsnrField)) {
            alert("Fødsels- og personnummer må være 11 siffer med gyldig dato!")
            return false;
        }

        //verifisere telefon
        reTelefon = /^[0-9]{8}$/;
        if (!reTelefon.test(telefonField))  {
            alert("Telefon må inneholde 8 siffer");
            return false;
        }

        //verifisere postkode
        rePostkode = /^[0-9]{4}$/;
        if (!rePostkode.test(postkodeField))  {
            alert("Postkode må være 4 siffer");
            return false;
        }

        //verifisere mail
        reMail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!reMail.test(emailField)) {
            alert("Email må være gyldig format. Eks: Ola.nordmann@hotmail.com");
            return false;
        }

        // alt ok submit
        document.forms["soknadform"].submit();
        return true;
    }
</script>
</html>