projectval=projectValue;
// console.log(projectval);
const cbtperInput = document.getElementById("cbtper");
const resperInput = document.getElementById("resper");

const cbtpymntInput = document.getElementById("cbtpymnt");
const respymntInput = document.getElementById("respymnt");

const invamtcbtinput=document.getElementById("invamtcbt");
const invamtresinput=document.getElementById("invamtres");

const tcsinvraiseInput = document.getElementById('tcsinvraise');

const cbtPymnt1DoneInput = document.getElementById("cbtPymnt1Done");
const cbtPymnt2DoneInput = document.getElementById("cbtPymnt2Done");
const cbtPymnt3DoneInput = document.getElementById("cbtPymnt3Done");

const TotCBTPymtDoneInput =document.getElementById("TotCBTPymtDone");

const resPymnt1DoneInput = document.getElementById("resPymnt1Done");
const resPymnt2DoneInput = document.getElementById("resPymnt2Done");
const resPymnt3DoneInput = document.getElementById("resPymnt3Done");

const TotResPymtDoneInput =document.getElementById("TotResPymtDone");

const totpymntdoneInput = document.getElementById('totpymntdone');

const OutstndBalInput = document.getElementById('OutstndBal');

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
// Initialize values to Indian number format when the page loads
window.addEventListener('load', function() {
    // Initialize values for other input fields
    cbtpymntInput.value = formatToIndianNumberSystem(parseFloat(cbtpymntInput.value.replace(/,/g, '')) || 0);
    respymntInput.value = formatToIndianNumberSystem(parseFloat(respymntInput.value.replace(/,/g, '')) || 0);
    invamtcbtinput.value = formatToIndianNumberSystem(parseFloat(invamtcbtinput.value.replace(/,/g, '')) || 0);
    invamtresinput.value = formatToIndianNumberSystem(parseFloat(invamtresinput.value.replace(/,/g, '')) || 0);
    tcsinvraiseInput.value = formatToIndianNumberSystem(parseFloat(tcsinvraiseInput.value.replace(/,/g, '')) || 0);
    cbtPymnt1DoneInput.value = formatToIndianNumberSystem(parseFloat(cbtPymnt1DoneInput.value.replace(/,/g, '')) || 0);
    cbtPymnt2DoneInput.value = formatToIndianNumberSystem(parseFloat(cbtPymnt2DoneInput.value.replace(/,/g, '')) || 0);
    cbtPymnt3DoneInput.value = formatToIndianNumberSystem(parseFloat(cbtPymnt3DoneInput.value.replace(/,/g, '')) || 0);
    TotCBTPymtDoneInput.value = formatToIndianNumberSystem(parseFloat(TotCBTPymtDoneInput.value.replace(/,/g, '')) || 0);
    resPymnt1DoneInput.value = formatToIndianNumberSystem(parseFloat(resPymnt1DoneInput.value.replace(/,/g, '')) || 0);
    resPymnt2DoneInput.value = formatToIndianNumberSystem(parseFloat(resPymnt2DoneInput.value.replace(/,/g, '')) || 0);
    resPymnt3DoneInput.value = formatToIndianNumberSystem(parseFloat(resPymnt3DoneInput.value.replace(/,/g, '')) || 0);
    TotResPymtDoneInput.value = formatToIndianNumberSystem(parseFloat(TotResPymtDoneInput.value.replace(/,/g, '')) || 0);
    totpymntdoneInput.value = formatToIndianNumberSystem(parseFloat(totpymntdoneInput.value.replace(/,/g, '')) || 0);
    OutstndBalInput.value = formatToIndianNumberSystem(parseFloat(OutstndBalInput.value.replace(/,/g, '')) || 0);
});

// Update payment inputs based on percentages
function updatePaymentInputs() {
    let cbtper = parseFloat(cbtperInput.value) || 0;
    let resper = parseFloat(resperInput.value) || 0;
    const totalPercentage = cbtper + resper;
    if (totalPercentage > 100) {
        // If total percentage is greater than 100, show an error message and reset the inputs
        alert("Total percentage cannot exceed 100%");
        cbtperInput.value = "";
        resperInput.value = "";
        return;
    }
    cbtpymntInput.value = formatToIndianNumberSystem(calculatePaymentAmount(cbtper, projectValue));
    respymntInput.value = formatToIndianNumberSystem(calculatePaymentAmount(resper, projectValue));
}

// Calculate payment amount based on percentage and project value
function calculatePaymentAmount(percentage, projectValue) {
    return parseFloat((percentage / 100) * projectValue).toFixed(2);
}

// Calculate total invoice amount
function totinvamt() {
    var invamtcbt = parseFloat(invamtcbtinput.value.replace(/,/g, '')) || 0;
    var invamtres = parseFloat(invamtresinput.value.replace(/,/g, '')) || 0;
    var totinvraise = invamtcbt + invamtres;
    tcsinvraiseInput.value = formatToIndianNumberSystem(totinvraise.toFixed(2));
}

// Calculate total CBT payment done
function totcbtPymntDone() {
    var cbtPymnt1Done = parseFloat(cbtPymnt1DoneInput.value.replace(/,/g, '')) || 0;
    var cbtPymnt2Done = parseFloat(cbtPymnt2DoneInput.value.replace(/,/g, '')) || 0;
    var cbtPymnt3Done = parseFloat(cbtPymnt3DoneInput.value.replace(/,/g, '')) || 0;
    var totCBTPymtDone = cbtPymnt1Done + cbtPymnt2Done + cbtPymnt3Done;
    TotCBTPymtDoneInput.value = formatToIndianNumberSystem(totCBTPymtDone.toFixed(2));
}

// Calculate total result payment done
function totresPymntDone() {
    var resPymnt1Done = parseFloat(resPymnt1DoneInput.value.replace(/,/g, '')) || 0;
    var resPymnt2Done = parseFloat(resPymnt2DoneInput.value.replace(/,/g, '')) || 0;
    var resPymnt3Done = parseFloat(resPymnt3DoneInput.value.replace(/,/g, '')) || 0;
    var totResPymtDone = resPymnt1Done + resPymnt2Done + resPymnt3Done;
    TotResPymtDoneInput.value = formatToIndianNumberSystem(totResPymtDone.toFixed(2));
}

// Calculate total payment done
function totpymntDone() {
    var cbtPymnt = parseFloat(TotCBTPymtDoneInput.value.replace(/,/g, '')) || 0;
    var resultPymnt = parseFloat(TotResPymtDoneInput.value.replace(/,/g, '')) || 0;
    var totalPymnt = cbtPymnt + resultPymnt;
    totpymntdoneInput.value = formatToIndianNumberSystem(totalPymnt.toFixed(2));
}

// Calculate outstanding balance
function outstnd() {
    var invraise = parseFloat(tcsinvraiseInput.value.replace(/,/g, '')) || 0;
    var amountrcvd = parseFloat(totpymntdoneInput.value.replace(/,/g, '')) || 0;
    var outstandingBalance = (invraise - amountrcvd).toFixed(2);
    OutstndBalInput.value = formatToIndianNumberSystem(outstandingBalance);
}

// Handle input changes
function handleInputChanges() {
    totinvamt();
    totcbtPymntDone();
    totresPymntDone();
    totpymntDone();
    outstnd();
}

cbtperInput.addEventListener("input", updatePaymentInputs);
resperInput.addEventListener("input", updatePaymentInputs);
// invamtcbtinput.addEventListener("input", handleInputChanges);
// invamtresinput.addEventListener("input", handleInputChanges);
// cbtPymnt1DoneInput.addEventListener("input",handleInputChanges);
// cbtPymnt2DoneInput.addEventListener("input",handleInputChanges);
// cbtPymnt3DoneInput.addEventListener("input",handleInputChanges);
// resPymnt1DoneInput.addEventListener("input",handleInputChanges);
// resPymnt2DoneInput.addEventListener("input",handleInputChanges);
// resPymnt3DoneInput.addEventListener("input",handleInputChanges);


// Add event listener for invamtcbtinput on input
invamtcbtinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for invamtresinput on input
invamtresinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for cbtPymnt1DoneInput on input
cbtPymnt1DoneInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for cbtPymnt2DoneInput on input
cbtPymnt2DoneInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for cbtPymnt3DoneInput on input
cbtPymnt3DoneInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for resPymnt1DoneInput on input
resPymnt1DoneInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for resPymnt2DoneInput on input
resPymnt2DoneInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for resPymnt3DoneInput on input
resPymnt3DoneInput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});












