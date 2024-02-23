// Initialize flatpickr for the input element

function formatDate(date) {
    const day = date.getDate().toString().padStart(2, "0");
    const month = (date.getMonth() + 1).toString().padStart(2, "0");
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}
function formattDate(date) {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
}

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




const jammerPriceInput = document.getElementById("jammer_Price");
const cctv_recordingPriceInput = document.getElementById("cctv_recordingPrice");
const cctv_live_streamingPriceInput = document.getElementById("cctv_live_streamingPrice");
const iris_scanningPriceInput = document.getElementById("iris_scanningPrice");
const biometric_capturingPriceInput = document.getElementById("biometric_capturingPrice");

const HHMD_PriceInput = document.getElementById("HHMD_Price");
const Gate_PriceInput = document.getElementById("Gate_Price");
const skill_testPriceInput = document.getElementById("skill_testPrice");

const qpcostinput = document.getElementById("qpcost");

// Question paper cost 
function updateValue(newValue) {
    qpcostinput.value = newValue;
    calculateProjVal();
}

const ratePerCandInput = document.getElementById('percandrate');
const expectedCountInput = document.getElementById('expcandcount');
const actualCountInput = document.getElementById('actualcandcount');
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
    // Format the initial values when the page loads
    qpcostinput.value = formatToIndianNumberSystem(parseFloat(qpcostinput.value.replace(/,/g,'')) || 0);
    ratePerCandInput.value = formatToIndianNumberSystem(parseFloat(ratePerCandInput.value.replace(/,/g, '')) || 0);
    expectedCountInput.value = formatToIndianNumberSystem(parseFloat(expectedCountInput.value.replace(/,/g, '')) || 0);
    actualCountInput.value = formatToIndianNumberSystem(parseFloat(actualCountInput.value.replace(/,/g, '')) || 0);
    estProjValInput.value = formatToIndianNumberSystem(parseFloat(estProjValInput.value.replace(/,/g, '')) || 0);
    actProjValInput.value = formatToIndianNumberSystem(parseFloat(actProjValInput.value.replace(/,/g, '')) || 0);

    calculateProjVal();
});

// Calculate Project Value
function calculateProjVal() {
    var ratePerCand = parseFloat(ratePerCandInput.value.replace(/,/g, ''))||0;
    var expectedCount = parseFloat(expectedCountInput.value.replace(/,/g, ''))||0;
    var actualCount = parseFloat(actualCountInput.value.replace(/,/g, ''))||0;
    var estProjVal =  parseFloat( estProjValInput.value.replace(/,/g, ''))||0;
    var actProjVal = parseFloat(actProjValInput.value.replace(/,/g, ''))||0;
    var qpcost = parseFloat(qpcostinput.value.replace(/,/g, ''))||0;

    var jammerPrice = parseFloat(jammerPriceInput.value.replace(/,/g, ''))||0;
    var cctv_recordingPrice = parseFloat(cctv_recordingPriceInput.value.replace(/,/g, ''))||0;
    var cctv_live_streamingPrice = parseFloat(cctv_live_streamingPriceInput.value.replace(/,/g, ''))||0;
    var iris_scanningPrice = parseFloat(iris_scanningPriceInput.value.replace(/,/g, ''))||0;
    var biometric_capturingPrice = parseFloat(biometric_capturingPriceInput.value.replace(/,/g, ''))||0;
    var HHMD_Price = parseFloat(HHMD_PriceInput.value.replace(/,/g, ''))||0;
    var Gate_Price = parseFloat(Gate_PriceInput.value.replace(/,/g, ''))||0;
    var skill_testPrice = parseFloat(skill_testPriceInput.value.replace(/,/g, ''))||0;
   
    // estimated project value
    if (!isNaN(ratePerCand) && !isNaN(expectedCount)) {
        var servicesTotal = jammerPrice * expectedCount +
                            cctv_live_streamingPrice * expectedCount +
                            cctv_recordingPrice * expectedCount +
                            iris_scanningPrice * expectedCount +
                            biometric_capturingPrice * expectedCount +
                            HHMD_Price * expectedCount +
                            Gate_Price * expectedCount +
                            skill_testPrice * expectedCount;

        var estProjVal = ratePerCand * expectedCount + qpcost + servicesTotal;
        estProjValInput.value = formatToIndianNumberSystem(estProjVal.toFixed(2));
    } else {
        estProjValInput.value = '';
    }
     // actual project value
     if (!isNaN(ratePerCand) && !isNaN(actualCount)) {
        
        var servicesTotal = jammerPrice * actualCount +
                            cctv_live_streamingPrice * actualCount +
                            cctv_recordingPrice * actualCount +
                            iris_scanningPrice * actualCount +
                            biometric_capturingPrice * actualCount +
                            HHMD_Price * actualCount +
                            Gate_Price * actualCount +
                            skill_testPrice * actualCount;

        var actProjVal = ratePerCand * actualCount + qpcost + servicesTotal;
        actProjValInput.value = formatToIndianNumberSystem(actProjVal.toFixed(2));
    } else {
        actProjValInput.value = '';
    }
}
// Add event listener for ratePerCandInput on input
ratePerCandInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for expectedCountInput on input
expectedCountInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for actualCountInput on input
actualCountInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for qpcostinput on input
qpcostinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for jammerPriceInput on input
jammerPriceInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for cctv_recordingPriceInput on input
cctv_recordingPriceInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for cctv_live_streamingPriceInput on input
cctv_live_streamingPriceInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for iris_scanningPriceInput on input
iris_scanningPriceInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for biometric_capturingPriceInput on input
biometric_capturingPriceInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for HHMD_PriceInput on input
HHMD_PriceInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for Gate_PriceInput on input
Gate_PriceInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

// Add event listener for skill_testPriceInput on input
skill_testPriceInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Calculate project values
    
});

ratePerCandInput.addEventListener("input",calculateProjVal); 
expectedCountInput.addEventListener("input",calculateProjVal); 
actualCountInput.addEventListener("input",calculateProjVal);
qpcostinput.addEventListener("input", calculateProjVal);
jammerPriceInput.addEventListener("input",calculateProjVal); 
cctv_recordingPriceInput.addEventListener("input",calculateProjVal);
cctv_live_streamingPriceInput.addEventListener("input",calculateProjVal); 
iris_scanningPriceInput.addEventListener("input",calculateProjVal); 
biometric_capturingPriceInput.addEventListener("input",calculateProjVal); 
HHMD_PriceInput.addEventListener("input",calculateProjVal); 
Gate_PriceInput.addEventListener("input",calculateProjVal); 
skill_testPriceInput.addEventListener("input",calculateProjVal); 

flatpickr("#AdmitLivDate", {
    mode: "multiple",
    dateFormat: "d-m-Y",
});
flatpickr("#CBTDate", {
    mode: "multiple",
    dateFormat: "d-m-Y",
});
