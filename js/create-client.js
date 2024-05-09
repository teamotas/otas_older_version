// Country State
$('#country').on('change', function() {
    var country_id = this.value;
    // console.log(country_id);
    $.ajax({
        url: 'state.php',
        type: "POST",
        data: {
            country_data: country_id
        },
        success: function(result) {
            $('#state').html(result);
            // console.log(result);
        }
    })
});
// state city
$('#state').on('change', function() {
    var state_id = this.value;
    // console.log(country_id);
    $.ajax({
        url: 'city.php',
        type: "POST",
        data: {
            state_data: state_id
        },
        success: function(data) {
            $('#city').html(data);
            // console.log(data);
        }
    })
});
// City dropdown change event
$('#city').on('change', function() {
    var selectedCity = this.value;
    var otherCityInput = $('#otherCityInput');
    
    if (selectedCity === 'other') {
        otherCityInput.show();
        $('label[for="otherCity"]').show();
        $('#otherCity').prop('required', true); // Add 'required' attribute
    } else {
        otherCityInput.hide();
        $('label[for="otherCity"]').hide();
        $('#otherCity').prop('required', false); // Remove 'required' attribute
    }
});


// Capital letter conversion
document.addEventListener("DOMContentLoaded", function() {
    var projectNameInput = document.getElementById("clientName");

    projectNameInput.addEventListener("input", function() {
        this.value = this.value.toUpperCase();
    });
});

// validate Client Form
function validateForm() 
{
    var role = document.getElementById("country").value;
    var role1 = document.getElementById("state").value;
    var role2 = document.getElementById("city").value;
    var clientSelect = document.getElementById("chooseClient");
    var selectedOption = clientSelect.options[clientSelect.selectedIndex];
    var selectedClientId1 = selectedOption.getAttribute("data-clientid1");

    if (role == "") {
    alert("Please Select Country.");
    return false;
    }
    if (role1 == "") {
    alert("Please Select State.");
    return false;
    }
    if (role2 == "") {
    alert("Please Select City.");
    return false;
    }

    if (selectedClientId1 === "") {
        alert("Please select a Client.");
        return false;
    }
    // Set the selected client ID as the value of the hidden input field
    document.getElementById("selectedClient1").value = selectedClientId1;
    return true;
}
