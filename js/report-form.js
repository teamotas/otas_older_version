// Initialize flatpickr for the input element

function formattDate(date) {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
}

const projectNameInput = document.getElementById("projectname");
const startDateInput = document.getElementById("startDate");
const durationInput = document.getElementById("duration");
const endDateInput = document.getElementById("endDate");

// Capital letter Conversion
document.addEventListener("DOMContentLoaded", function() {
    projectNameInput.addEventListener("input", function() {
        this.value = this.value.toUpperCase();
    });
});

// Calculate End Date 
function calculateEndDate() {
    var startDate = startDateInput.value;
    var endDate = endDateInput.value;
    var duration = durationInput.value;
    if (startDate && duration) {
        var startDate = new Date(startDate);
        var endDate = new Date(startDate);
        endDate.setDate(startDate.getDate() + parseInt(duration));
        
        var formattedEndDate = formattDate(endDate);
        endDateInput.value = formattedEndDate;
    } else {
        endDateInput.value = "";
    }
}
startDateInput.addEventListener("input",calculateEndDate);
durationInput.addEventListener("input",calculateEndDate);







const estProjValInput = document.getElementById('estprojval');
const actProjValInput = document.getElementById('actprojval');

// Function to format a number to Indian number system
function formatToIndianNumberSystem(value) {
    // Check if the value is a string
    if (typeof value !== 'string') {
        // Convert the value to a string if it's not already
        value = value.toString();
    }

    // Remove any existing commas from the value
    value = value.replace(/,/g, '');

    // Convert the value to a number and format it using Indian number system
    return Number(value).toLocaleString('en-IN');
}

// Initialize values to Indian number format when the page loads
window.addEventListener('load', function() {
  
    estProjValInput.value = formatToIndianNumberSystem(parseFloat(estProjValInput.value.replace(/,/g, '')) || 0);
    actProjValInput.value = formatToIndianNumberSystem(parseFloat(actProjValInput.value.replace(/,/g, '')) || 0);

});

flatpickr("#CBTDate", {
    mode: "multiple",
    dateFormat: "d-m-Y",
});
