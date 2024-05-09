
const projectNameInput = document.getElementById("projectname");
const yearInput = document.getElementById('year');
const startDateInput = document.getElementById("startDate");
const durationInput = document.getElementById("duration");
const endDateInput = document.getElementById("endDate");

// Get the current year
var currentYear = new Date().getFullYear();
yearInput.value = currentYear;

// Capital letter Conversion
document.addEventListener("DOMContentLoaded", function() {
    projectNameInput.addEventListener("input", function() {
        this.value = this.value.toUpperCase();
    });
});
function formattDate(date) {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
}
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

//--------------------------------------------------




const ratePerCandInput = document.getElementById('percandrate');
const expectedCountInput = document.getElementById('expcandcount');
const actualCountInput = document.getElementById('actualcandcount');
const estProjValInput = document.getElementById('estprojval');
const actProjValInput = document.getElementById('actprojval');

// Add event listener for ratePerCandInput on input
ratePerCandInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    calculateProjValTCS();
});

// Initialize values to Indian number format when the page loads
window.addEventListener('load', function() {
    // Format the initial values when the page loads
    ratePerCandInput.value = formatToIndianNumberSystem(parseFloat(ratePerCandInput.value.replace(/,/g, '')) || 0);
    expectedCountInput.value = formatToIndianNumberSystem(parseFloat(expectedCountInput.value.replace(/,/g, '')) || 0);
    actualCountInput.value = formatToIndianNumberSystem(parseFloat(actualCountInput.value.replace(/,/g, '')) || 0);
    estProjValInput.value = formatToIndianNumberSystem(parseFloat(estProjValInput.value.replace(/,/g, '')) || 0);
    actProjValInput.value = formatToIndianNumberSystem(parseFloat(actProjValInput.value.replace(/,/g, '')) || 0);

    // Calculate project values initially
    calculateProjValTCS();
});

// Function to format a number in Indian number system
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

// Function to calculate project values for TCS
function calculateProjValTCS() {
    var ratePerCand = parseFloat(ratePerCandInput.value.replace(/,/g, '')) || 0;
    var expectedCount = parseFloat(expectedCountInput.value.replace(/,/g, '')) || 0;
    var actualCount = parseFloat(actualCountInput.value.replace(/,/g, '')) || 0;
    
    // console.log("ratePerCand"+"="+ratePerCand);
    // console.log("expectedCount"+"="+expectedCount);
    // console.log("actualCount"+"="+actualCount);
    
    // Calculate estimated project value
    var estProjVal = ratePerCand * expectedCount;
    estProjValInput.value = formatToIndianNumberSystem(estProjVal.toFixed(2));

    // Calculate actual project value
    var actProjVal = ratePerCand * actualCount;
    actProjValInput.value = formatToIndianNumberSystem(actProjVal.toFixed(2));
    // console.log("estProjVal"+"="+estProjVal);
    // console.log("actProjVal"+"="+actProjVal);

    
}



































// // ------------------------------------------
// const ratePerCandInput = document.getElementById('percandrate');
// const expectedCountInput = document.getElementById('expcandcount');
// const actualCountInput = document.getElementById('actualcandcount');
// const estProjValInput = document.getElementById('estprojval');
// const actProjValInput = document.getElementById('actprojval');

// // Function to calculate project values for TCS
// function calculateProjValTCS() {
//     var ratePerCand = parseFloat(ratePerCandInput.value) || 0;
//     var expectedCount = parseFloat(expectedCountInput.value) || 0;
//     var actualCount = parseFloat(actualCountInput.value) || 0;

//     // Calculate estimated project value
//     var estProjVal = ratePerCand * expectedCount;
//     estProjValInput.value = estProjVal.toFixed(2);

//     // Calculate actual project value
//     var actProjVal = ratePerCand * actualCount;
//     actProjValInput.value = actProjVal.toFixed(2);
// }

// ratePerCandInput.addEventListener("input", calculateProjValTCS);
// expectedCountInput.addEventListener("input", calculateProjValTCS);
// actualCountInput.addEventListener("input", calculateProjValTCS);
