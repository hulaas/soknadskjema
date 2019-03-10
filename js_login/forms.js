
function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";

    // Finally submit the form. 
    form.submit();
}

function regformhash(form, uid, email, password, conf, rolle, admin) {
    // Check each field has a value
    if (uid.value == '' || email.value == '' || password.value == '' || conf.value == '' || rolle.value == '' || admin.value == '') {
        alert('You must provide all the requested details. Please try again');
        return false;
    }
    
    // Check the username
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.username.focus();
        return false; 
    }
    
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }
    
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }
    
    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
        
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";

    // Finally submit the form. 
    form.submit();
    return true;
}

function changepwformhash(form, curr_pw, new_pw, conf_pw) {
    // Check each field has a value
    if (curr_pw.value == '' || new_pw.value == '' || conf_pw.value == '') {
        alert('Du må fylle inn alle felter. Prøv igjen');
        return false;
    }

    // Check that the password is sufficiently long (min 8 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (new_pw.value.length < 8) {
        alert('Passordet må minst bestå av 8 tegn.  Prøv igjen');
        form.new_pw.focus();
        return false;
    }

    // At least one number, one lowercase and one uppercase letter
    // At least six characters
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    if (!re.test(new_pw.value)) {
        alert('Passordet må inneholde minst ett nummer, en liten bokstav og en stor bokstav. Prøv igjen');
        return false;
    }

    // Check password and confirmation are the same
    if (new_pw.value != conf_pw.value) {
        alert('Det nye passord stemmer ikke med bekreftelses passordet. Prøv igjen');
        form.new_pw.focus();
        return false;
    }

    // Create a new element input, this will be the current hashed password field.
    var c = document.createElement("input");
    var p = document.createElement("input");

    // Add the new element to our form.
    form.appendChild(c);
    form.appendChild(p);



    c.name = "c";
    c.type = "hidden";
    c.value = hex_sha512(curr_pw.value);

    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(new_pw.value);



    // Make sure the plaintext password doesn't get sent.
    curr_pw.value = "";
    new_pw.value = "";
    conf_pw.value = "";

    // Finally submit the form.
    form.submit();
    return true;

}
