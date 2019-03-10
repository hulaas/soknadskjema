
$("input[type=password]").keyup(function(){
    var ucase = new RegExp("[A-Z]+");
    var lcase = new RegExp("[a-z]+");
    var num = new RegExp("[0-9]+");

    if($("#new_password").val().length >= 8){
        $("#8char").removeClass("fas fa-times");
        $("#8char").addClass("fas fa-check");
        $("#8char").css("color","#00A41E");
    }else{
        $("#8char").removeClass("fas fa-check");
        $("#8char").addClass("fas fa-times");
        $("#8char").css("color","#FF0004");
    }

    if(ucase.test($("#new_password").val())){
        $("#ucase").removeClass("fas fa-times");
        $("#ucase").addClass("fas fa-check");
        $("#ucase").css("color","#00A41E");
    }else{
        $("#ucase").removeClass("fas fa-check");
        $("#ucase").addClass("fas fa-times");
        $("#ucase").css("color","#FF0004");
    }

    if(lcase.test($("#new_password").val())){
        $("#lcase").removeClass("fas fa-times");
        $("#lcase").addClass("fas fa-check");
        $("#lcase").css("color","#00A41E");
    }else{
        $("#lcase").removeClass("fas fa-check");
        $("#lcase").addClass("fas fa-times");
        $("#lcase").css("color","#FF0004");
    }

    if(num.test($("#new_password").val())){
        $("#num").removeClass("fas fa-times");
        $("#num").addClass("fas fa-check");
        $("#num").css("color","#00A41E");
    }else{
        $("#num").removeClass("fas fa-check");
        $("#num").addClass("fas fa-times");
        $("#num").css("color","#FF0004");
    }

    if($("#new_password").val() == $("#confirm_password").val()){
        $("#pwmatch").removeClass("fas fa-times");
        $("#pwmatch").addClass("fas fa-check");
        $("#pwmatch").css("color","#00A41E");
    }else{
        $("#pwmatch").removeClass("fas fa-check");
        $("#pwmatch").addClass("fas fa-times");
        $("#pwmatch").css("color","#FF0004");
    }
});
