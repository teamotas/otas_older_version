$(document).ready(function() {

    $('form').submit(function(event) {
        // console.log('Form submit event triggered.');
        var isValid = true;

        // Client-side validation
        if ($('#name').val() === '') {
            showError('nameError', 'Name is required.');
            isValid = false;
        }
        if ($('#empid').val() === '') {
            showError('empIdError', 'EmployeeId is required.');
            isValid = false;
        }
        if ($('#profilename').val() === '') {
            showError('designationError', 'Designation is  required.');
            isValid = false;
        }

        // Validate Gender
        if (!$('#male').prop('checked') && !$('#female').prop('checked')) {
            showError('genderError', 'Choose Gender.');
            isValid = false;
        } else {
            hideError('genderError');
        }

        // Client-side validation for email format
        var email = $('#email').val();
        var emailRegex = /^[a-zA-Z0-9_.-]+@edcil\.co\.in$/;
        if (email === '') {
            showError('emailError', 'Email address is required.');
            isValid = false;
        } else if (!emailRegex.test(email)) {
            showError('emailError', 'Invalid email address.');
            isValid = false;
        }
        
        // Client-side validation for phone number format
        var phoneNumber = $('#mobile').val().replace(/\D/g, ''); 
        var phoneNumberRegex = /^[6-9]\d{9}$/;

        if (phoneNumber === '') {
            showError('phoneError', 'Mobile No. is required.');
            isValid = false;
        } else if (!phoneNumberRegex.test(phoneNumber)) {
            showError('phoneError', 'Invalid phone number. Please enter a 10-digit phone number.');
            isValid = false;
        }
        // If client-side validation fails, prevent form submission
        if (!isValid) {
          event.preventDefault();
        }
    });

    function showError(elementId, errorMessage) {
      $('#' + elementId).text(errorMessage).show();
    }

    function hideError(elementId) {
      $('#' + elementId).hide();
    }

    function hideError1(elementId, inputId) {
        $('#' + elementId).hide();

        // Clear input error state on focusout
        $('#' + inputId).on('focusout', function() {
            if ($(this).val().trim() !== '') {
                hideError1(elementId);
            }
        });
    }

    $('#male, #female').on('focusout', function() {
        if ($('#male').prop('checked') || $('#female').prop('checked')) {
            hideError('genderError');
        }
    });

    // Call hideError1 for each input field after the page loads
    hideError1('nameError', 'name');
    hideError1('emailError', 'email');
    hideError1('empIdError', 'empid');
    hideError1('designationError', 'profilename');
    hideError1('phoneError', 'mobile');
});

// Capital letter conversion
document.addEventListener("DOMContentLoaded", function() {
    var projectNameInput = document.getElementById("name");

    projectNameInput.addEventListener("input", function() {
        this.value = this.value.toUpperCase();
    });
});