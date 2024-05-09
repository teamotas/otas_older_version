$(document).ready(function() {
    $('form').submit(function(event) {
        var isValid = true;

        var UserEmail = $('#UserEmail').val();
        var EmailRegex = /^[a-zA-Z0-9_.-]+@edcil\.co\.in$/;
        var userpassword = $('#pswd').val();

        if (UserEmail === '') {
            showError('UserEmailError', 'Email address is required.');
            isValid = false;
        } else if (!EmailRegex.test(UserEmail)) {
            showError('UserEmailError', 'Invalid email address.');
            isValid = false;
        }

        if (userpassword === '') {
            showError('UserPasswordError', 'Password is required.');
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    function showError(elementId, errorMessage) {
        $('#' + elementId).text(errorMessage).show();
    }

    // function hideError(elementId) {
    //     $('#' + elementId).hide();
    // }

    function hideError1(elementId, inputId) {
        $('#' + elementId).hide();

        // Clear input error state on focusout
        $('#' + inputId).on('focusout', function() {
            if ($(this).val().trim() !== '') {
                hideError1(elementId);
            }
        });
    }
    hideError1('UserEmailError', 'UserEmail');
    hideError1('UserPasswordError', 'pswd');
});


// password 2
function  password2() {
    var x = document.getElementById("pswd");    
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}