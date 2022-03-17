$(document).ready(function () {
    $("#myForm").submit(function (event) {
        console.log("calling")
        if (!$("#email").val()) {
            $("#email").addClass("is-invalid");
            event.preventDefault();
        }
        else {
            $("#email").removeClass("is-invalid");
            $("#email").addClass("is-valid");
        }
        if (!$("#password").val()) {
            $("#password").addClass("is-invalid");
            event.preventDefault();
        }
        else {
            $("#password").removeClass("is-invalid");
            $("#password").addClass("is-valid");
        }
    });


    $("#myRegForm").submit(function (event) {
        console.log("calling")
        if (!$("#email").val()) {
            $("#email").addClass("is-invalid");
            event.preventDefault();
        }
        else {
            $("#email").removeClass("is-invalid");
            $("#email").addClass("is-valid");
        }
        if (!$("#password").val()) {
            $("#password").addClass("is-invalid");
            event.preventDefault();
        }
        else {
            $("#password").removeClass("is-invalid");
            $("#password").addClass("is-valid");
        }
        if (!$("#firstname").val()) {
            $("#firstname").addClass("is-invalid");
            event.preventDefault();
        }
        else {
            $("#firstname").removeClass("is-invalid");
            $("#firstname").addClass("is-valid");
        }
        if (!$("#phone").val()) {
            $("#phone").addClass("is-invalid");
            event.preventDefault();
        }
        else {
            $("#phone").removeClass("is-invalid");
            $("#phone").addClass("is-valid");
        }
        if (!$("#lastname").val()) {
            $("#lastname").addClass("is-invalid");
            event.preventDefault();
        }
        else {
            $("#lastname").removeClass("is-invalid");
            $("#lastname").addClass("is-valid");
        }
        if ($("#role").val() == 0) {
            $("#role").addClass("is-invalid");
            event.preventDefault();
        }
        else {
            $("#role").removeClass("is-invalid");
            $("#role").addClass("is-valid");
        }
    });



$("#myForm2").submit(function (event) {
    console.log("calling")
    if ((!$("#declaring_major").val()) && (!$("#adding_major").val()) && (!$("#changing_major_from").val()) && (!$("#changing_major_to").val()) && (!$("#drop_major").val()) && (!$("#declaring_minor").val()) && (!$("#adding_minor").val()) && (!$("#changing_minor_from").val()) && (!$("#changing_minor_to").val()) && (!$("#drop_minor").val())) {
        (($("#declaring_major").addClass("is-invalid")) && ($("#adding_major").addClass("is-invalid")) && ($("#changing_major_from").addClass("is-invalid")) && ($("#changing_major_to").addClass("is-invalid")) && ($("#drop_major").addClass("is-invalid"))($("#declaring_minor").addClass("is-invalid")) && ($("#adding_minor").addClass("is-invalid")) && ($("#changing_minor_from").addClass("is-invalid")) && ($("#changing_minor_to").addClass("is-invalid")) && ($("#drop_minor").addClass("is-invalid"))) ;
        event.preventDefault();
    }
    else {
        (($("#declaring_major").removeClass("is-invalid")) && ($("#adding_major").removeClass("is-invalid")) && ($("#changing_major_from").removeClass("is-invalid")) && ($("#changing_major_to").removeClass("is-invalid")) && ($("#drop_major").removeClass("is-invalid"))($("#declaring_minor").removeClass("is-invalid")) && ($("#adding_minor").removeClass("is-invalid")) && ($("#changing_minor_from").removeClass("is-invalid")) && ($("#changing_minor_to").removeClass("is-invalid")) && ($("#drop_minor").removeClass("is-invalid")));
        (($("#declaring_major").addClass("is-valid")) && ($("#adding_major").addClass("is-valid")) && ($("#changing_major_from").addClass("is-valid")) && ($("#changing_major_to").addClass("is-valid")) && ($("#drop_major").addClass("is-valid"))($("#declaring_minor").addClass("is-valid")) && ($("#adding_minor").addClass("is-valid")) && ($("#changing_minor_from").addClass("is-valid")) && ($("#changing_minor_to").addClass("is-valid")) && ($("#drop_minor").addClass("is-valid")));
    }
    
});

});