$(document).ready(function() {
    $('form').submit(function(event) {
        var isValid = true;

        var AdminEmail = $('#AdminId').val();
        var EmailRegex = /^[a-zA-Z0-9_.-]+@edcil\.co\.in$/;
        var password = $('#AdminPswd').val();

        if (AdminEmail === '') {
            showError('AdminEmailError', 'Email address is required.');
            isValid = false;
        } else if (!EmailRegex.test(AdminEmail)) {
            showError('AdminEmailError', 'Invalid email address.');
            isValid = false;
        }

        if (password === '') {
            showError('AdminPasswordError', 'Password is required.');
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

    hideError1('AdminEmailError', 'AdminId');
    hideError1('AdminPasswordError', 'AdminPswd');
});


// password 1
function  password1() {
    var x = document.getElementById("AdminPswd");    
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
