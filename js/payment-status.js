const actualVal = projectValue;
const expectVal = ExpectProjVal;

const stage1nameinput = document.getElementById("stageval1");
const stage2nameinput = document.getElementById("stageval2");
const stage3nameinput = document.getElementById("stageval3");
const stage4nameinput = document.getElementById("stageval4");
const stage5nameinput = document.getElementById("stageval5");

const stage1pcntinput = document.getElementById("stage1pcnt");
const stage2pcntinput = document.getElementById("stage2pcnt");
const stage3pcntinput = document.getElementById("stage3pcnt");
const stage4pcntinput = document.getElementById("stage4pcnt");
const stage5pcntinput = document.getElementById("stage5pcnt");

const stg1amtinput = document.getElementById("stg1amt");
const stg2amtinput = document.getElementById("stg2amt");
const stg3amtinput = document.getElementById("stg3amt");
const stg4amtinput = document.getElementById("stg4amt");
const stg5amtinput = document.getElementById("stg5amt");


// Invoice Amount-----------------------------------------------
const stg1InvAmtinput = document.getElementById("stg1InvAmt"); //1
const stg2InvAmtinput = document.getElementById("stg2InvAmt"); //2
const stg3InvAmtinput = document.getElementById("stg3InvAmt"); //3
const stg4InvAmtinput = document.getElementById("stg4InvAmt"); //4
const stg5InvAmtinput = document.getElementById("stg5InvAmt"); //5


// Invoice Raised
const InvAmtRaisedInput = document.getElementById('InvAmtRaised');



// Payment Recieved-------------------------------------------
// stage 1
const stg1pymntRcvdinput = document.getElementById("stg1pymntRcvd");
const stg1NetPymntinput = document.getElementById("stg1NetPymnt");
const stg1TDSinput = document.getElementById("stg1TDS");
const stg1GstTDSinput = document.getElementById("stg1GstTDS");
const stg1GrossPymntinput = document.getElementById("stg1GrossPymnt");

// stage 2
const stg2pymntRcvdinput = document.getElementById("stg2pymntRcvd");
const stg2NetPymntinput = document.getElementById("stg2NetPymnt");
const stg2TDSinput = document.getElementById("stg2TDS");
const stg2GstTDSinput = document.getElementById("stg2GstTDS");
const stg2GrossPymntinput = document.getElementById("stg2GrossPymnt");

// stage 3
const stg3pymntRcvdinput = document.getElementById("stg3pymntRcvd");
const stg3NetPymntinput = document.getElementById("stg3NetPymnt");
const stg3TDSinput = document.getElementById("stg3TDS");
const stg3GstTDSinput = document.getElementById("stg3GstTDS");
const stg3GrossPymntinput = document.getElementById("stg3GrossPymnt");

// stage 4
const stg4pymntRcvdinput = document.getElementById("stg4pymntRcvd");
const stg4NetPymntinput = document.getElementById("stg4NetPymnt");
const stg4TDSinput = document.getElementById("stg4TDS");
const stg4GstTDSinput = document.getElementById("stg4GstTDS");
const stg4GrossPymntinput = document.getElementById("stg4GrossPymnt");

// stage 5
const stg5pymntRcvdinput = document.getElementById("stg5pymntRcvd");
const stg5NetPymntinput = document.getElementById("stg5NetPymnt");
const stg5TDSinput = document.getElementById("stg5TDS");
const stg5GstTDSinput = document.getElementById("stg5GstTDS");
const stg5GrossPymntinput = document.getElementById("stg5GrossPymnt");

// Amount Rcvd By Client
const TotalAmountRcvdInput = document.getElementById('Amountrcvd');

// TOtal Ouststanding Balance
const TotOutstndBalInput = document.getElementById('TotOutstndBal');

// Function to format a number to Indian number system
function formatToIndianNumberSystem(value) {
    // Check if the value is a string
    if (typeof value !== 'string') {
        // Convert the value to a string if it's not already
        value = value.toString();
    }

    // Remove any existing commas from the value
    value = value.replace(/,/g, '');

    // Convert the value to a number and format it using the Indian number system
    return Number(value).toLocaleString('en-IN');
}

// Function to format input values to Indian number system onload
window.onload = function() {
    // Stage Amounts
    stg1amtinput.value = formatToIndianNumberSystem(parseFloat(stg1amtinput.value.replace(/,/g, '')) || 0);
    stg2amtinput.value = formatToIndianNumberSystem(parseFloat(stg2amtinput.value.replace(/,/g, '')) || 0);
    stg3amtinput.value = formatToIndianNumberSystem(parseFloat(stg3amtinput.value.replace(/,/g, '')) || 0);
    stg4amtinput.value = formatToIndianNumberSystem(parseFloat(stg4amtinput.value.replace(/,/g, '')) || 0);
    stg5amtinput.value = formatToIndianNumberSystem(parseFloat(stg5amtinput.value.replace(/,/g, '')) || 0);

    // Invoice Amounts
    stg1InvAmtinput.value = formatToIndianNumberSystem(parseFloat(stg1InvAmtinput.value.replace(/,/g, '')) || 0);
    stg2InvAmtinput.value = formatToIndianNumberSystem(parseFloat(stg2InvAmtinput.value.replace(/,/g, '')) || 0);
    stg3InvAmtinput.value = formatToIndianNumberSystem(parseFloat(stg3InvAmtinput.value.replace(/,/g, '')) || 0);
    stg4InvAmtinput.value = formatToIndianNumberSystem(parseFloat(stg4InvAmtinput.value.replace(/,/g, '')) || 0);
    stg5InvAmtinput.value = formatToIndianNumberSystem(parseFloat(stg5InvAmtinput.value.replace(/,/g, '')) || 0);

    // Total Invoice Stage
    InvAmtRaisedInput.value = formatToIndianNumberSystem(parseFloat(InvAmtRaisedInput.value.replace(/,/g, '')) || 0);

    // Payment Received - Stage 1
    stg1pymntRcvdinput.value = formatToIndianNumberSystem(parseFloat(stg1pymntRcvdinput.value.replace(/,/g, '')) || 0);
    // stg1NetPymntinput.value = formatToIndianNumberSystem(parseFloat(stg1NetPymntinput.value.replace(/,/g, '')) || 0);
    // stg1TDSinput.value = formatToIndianNumberSystem(parseFloat(stg1TDSinput.value.replace(/,/g, '')) || 0);
    // stg1GstTDSinput.value = formatToIndianNumberSystem(parseFloat(stg1GstTDSinput.value.replace(/,/g, '')) || 0);
    // stg1GrossPymntinput.value = formatToIndianNumberSystem(parseFloat(stg1GrossPymntinput.value.replace(/,/g, '')) || 0);

    // Payment Received - Stage 2
    stg2pymntRcvdinput.value = formatToIndianNumberSystem(parseFloat(stg2pymntRcvdinput.value.replace(/,/g, '')) || 0);
    // stg2NetPymntinput.value = formatToIndianNumberSystem(parseFloat(stg2NetPymntinput.value.replace(/,/g, '')) || 0);
    // stg2TDSinput.value = formatToIndianNumberSystem(parseFloat(stg2TDSinput.value.replace(/,/g, '')) || 0);
    // stg2GstTDSinput.value = formatToIndianNumberSystem(parseFloat(stg2GstTDSinput.value.replace(/,/g, '')) || 0);
    // stg2GrossPymntinput.value = formatToIndianNumberSystem(parseFloat(stg2GrossPymntinput.value.replace(/,/g, '')) || 0);

    // Payment Received - Stage 3
    stg3pymntRcvdinput.value = formatToIndianNumberSystem(parseFloat(stg3pymntRcvdinput.value.replace(/,/g, '')) || 0);
    // stg3NetPymntinput.value = formatToIndianNumberSystem(parseFloat(stg3NetPymntinput.value.replace(/,/g, '')) || 0);
    // stg3TDSinput.value = formatToIndianNumberSystem(parseFloat(stg3TDSinput.value.replace(/,/g, '')) || 0);
    // stg3GstTDSinput.value = formatToIndianNumberSystem(parseFloat(stg3GstTDSinput.value.replace(/,/g, '')) || 0);
    // stg3GrossPymntinput.value = formatToIndianNumberSystem(parseFloat(stg3GrossPymntinput.value.replace(/,/g, '')) || 0);

    // Payment Received - Stage 4
    stg4pymntRcvdinput.value = formatToIndianNumberSystem(parseFloat(stg4pymntRcvdinput.value.replace(/,/g, '')) || 0);
    // stg4NetPymntinput.value = formatToIndianNumberSystem(parseFloat(stg4NetPymntinput.value.replace(/,/g, '')) || 0);
    // stg4TDSinput.value = formatToIndianNumberSystem(parseFloat(stg4TDSinput.value.replace(/,/g, '')) || 0);
    // stg4GstTDSinput.value = formatToIndianNumberSystem(parseFloat(stg4GstTDSinput.value.replace(/,/g, '')) || 0);
    // stg4GrossPymntinput.value = formatToIndianNumberSystem(parseFloat(stg4GrossPymntinput.value.replace(/,/g, '')) || 0);

    // Payment Received - Stage 5
    stg5pymntRcvdinput.value = formatToIndianNumberSystem(parseFloat(stg5pymntRcvdinput.value.replace(/,/g, '')) || 0);
    // stg5NetPymntinput.value = formatToIndianNumberSystem(parseFloat(stg5NetPymntinput.value.replace(/,/g, '')) || 0);
    // stg5TDSinput.value = formatToIndianNumberSystem(parseFloat(stg5TDSinput.value.replace(/,/g, '')) || 0);
    // stg5GstTDSinput.value = formatToIndianNumberSystem(parseFloat(stg5GstTDSinput.value.replace(/,/g, '')) || 0);
    // stg5GrossPymntinput.value = formatToIndianNumberSystem(parseFloat(stg5GrossPymntinput.value.replace(/,/g, '')) || 0);

    // // Amount Received By Client
    TotalAmountRcvdInput.value = formatToIndianNumberSystem(parseFloat(TotalAmountRcvdInput.value.replace(/,/g, '')) || 0);

    // Total Outstanding Balance
    TotOutstndBalInput.value = formatToIndianNumberSystem(parseFloat(TotOutstndBalInput.value.replace(/,/g, '')) || 0);
};


function updatePaymentInputs() {
    var stage1pcnt = parseFloat(stage1pcntinput.value) || 0;
    var stage2pcnt = parseFloat(stage2pcntinput.value) || 0;
    var stage3pcnt = parseFloat(stage3pcntinput.value) || 0;
    var stage4pcnt = parseFloat(stage4pcntinput.value) || 0;
    var stage5pcnt = parseFloat(stage5pcntinput.value) || 0;

    const totalPercentage = stage1pcnt + stage2pcnt + stage3pcnt + stage4pcnt + stage5pcnt;

    if (totalPercentage > 100) {
        alert("Total percentage cannot exceed 100%");
        return;
    }

    calculateAndUpdatePaymentAmount(1, stage1pcnt, expectVal, actualVal);
    calculateAndUpdatePaymentAmount(2, stage2pcnt, expectVal, actualVal);
    calculateAndUpdatePaymentAmount(3, stage3pcnt, expectVal, actualVal);
    calculateAndUpdatePaymentAmount(4, stage4pcnt, expectVal, actualVal);
    calculateAndUpdatePaymentAmount(5, stage5pcnt, expectVal, actualVal);
}

function calculateAndUpdatePaymentAmount(stageNumber, stagePcnt, expectVal, actualVal) {
    const stageInput = document.getElementById(`stageval${stageNumber}`);
    const stageAmtInput = document.getElementById(`stg${stageNumber}amt`);

    // console.log(`stageNumber: ${stageNumber}`);
    // console.log(`stageInput.value: ${stageInput.value}`);
    // console.log(`stageAmtInput: ${stageAmtInput}`);

    if (stageInput.value != "") {
        if (stageInput.value === 'Advance') {
            stageAmtInput.value = calculatePaymentAmount(stagePcnt, expectVal);
        }
        else if(stageInput.value === 'Application Go live'){
            stageAmtInput.value = calculatePaymentAmount(stagePcnt, expectVal);
        }
        else {
            stageAmtInput.value = calculatePaymentAmount(stagePcnt, actualVal);
        }
    } else {
        console.error(`Element with ID stg${stageNumber}amtinput not found`);
    }
}

function calculatePaymentAmount(percentage, projectval) {
    return formatToIndianNumberSystem(parseFloat((percentage / 100) * projectval).toFixed(2));
}

// Event listeners for dropdowns and percentages
stage1nameinput.addEventListener("input", updatePaymentInputs);
stage2nameinput.addEventListener("input", updatePaymentInputs);
stage3nameinput.addEventListener("input", updatePaymentInputs);
stage4nameinput.addEventListener("input", updatePaymentInputs);
stage5nameinput.addEventListener("input", updatePaymentInputs);

stage1pcntinput.addEventListener("input", updatePaymentInputs);
stage2pcntinput.addEventListener("input", updatePaymentInputs);
stage3pcntinput.addEventListener("input", updatePaymentInputs);
stage4pcntinput.addEventListener("input", updatePaymentInputs);
stage5pcntinput.addEventListener("input", updatePaymentInputs);



function calculateGrossPayment(stage) {
    var netPymnt = parseFloat(document.getElementById(`stg${stage}NetPymnt`).value) || 0;
    var tds = parseFloat(document.getElementById(`stg${stage}TDS`).value) || 0;
    var gstTDS = parseFloat(document.getElementById(`stg${stage}GstTDS`).value) || 0;

    var grossPayment = netPymnt + tds + gstTDS;

    document.getElementById(`stg${stage}GrossPymnt`).value = grossPayment.toFixed(2);
}

// Attach the function to the input fields for each stage
for (var i = 1; i <= 5; i++) {
    document.getElementById(`stg${i}NetPymnt`).addEventListener("input", function (event) {
        calculateGrossPayment(event.target.id.match(/\d+/)[0]);
    });
    document.getElementById(`stg${i}TDS`).addEventListener("input", function (event) {
        calculateGrossPayment(event.target.id.match(/\d+/)[0]);
    });
    document.getElementById(`stg${i}GstTDS`).addEventListener("input", function (event) {
        calculateGrossPayment(event.target.id.match(/\d+/)[0]);
    });
}

//////////////total invoice amount calculate/////////////////////
function totinvamt() {
    var stg1InvAmt = parseFloat(stg1InvAmtinput.value.replace(/,/g, '')) || 0;
    var stg2InvAmt = parseFloat(stg2InvAmtinput.value.replace(/,/g, '')) || 0;
    var stg3InvAmt = parseFloat(stg3InvAmtinput.value.replace(/,/g, '')) || 0;
    var stg4InvAmt = parseFloat(stg4InvAmtinput.value.replace(/,/g, '')) || 0;
    var stg5InvAmt = parseFloat(stg5InvAmtinput.value.replace(/,/g, '')) || 0;

    var totinvraise = stg1InvAmt + stg2InvAmt + stg3InvAmt + stg4InvAmt + stg5InvAmt;

    // if (totinvraise > projectval) {
    //     alert("Exceeding the project value.");
    //     InvAmtRaisedInput.value = "";
    //     // preventDefault() ;
    //     return;
    // }
    InvAmtRaisedInput.value = formatToIndianNumberSystem(totinvraise.toFixed(2));
}

///////////////amount rcvd by client calculate////////////////
function TotalAmountRcvdByClient() {
    var stg1pymntRcvd = parseFloat(stg1pymntRcvdinput.value.replace(/,/g, '')) || 0;
    var stg2pymntRcvd = parseFloat(stg2pymntRcvdinput.value.replace(/,/g, '')) || 0;
    var stg3pymntRcvd = parseFloat(stg3pymntRcvdinput.value.replace(/,/g, '')) || 0;
    var stg4pymntRcvd = parseFloat(stg4pymntRcvdinput.value.replace(/,/g, '')) || 0;
    var stg5pymntRcvd = parseFloat(stg5pymntRcvdinput.value.replace(/,/g, '')) || 0;
    var totalPymntRCVD =stg1pymntRcvd + stg2pymntRcvd + stg3pymntRcvd + stg4pymntRcvd + stg5pymntRcvd;
    // if (totalPymntRCVD > projectval) {
    //     alert("Total payment received cannot exceed actual project value.");
    //     // stg5pymntRcvdrcvdinput.value = "";
    //     // admitPymntrcvdinput.value = "";
    //     // cbtPymntrcvdinput.value = "";
    //     resultPymntrcvdinput.value = "";
    //     // TotalAmountRcvdInput.value = "";
    //     return;
    // }
    TotalAmountRcvdInput.value = formatToIndianNumberSystem(totalPymntRCVD.toFixed(2));    
}

/////////////Outstanding balance calculate/////////////////
function TotOutstndBal() { 
    var invraise = parseFloat(InvAmtRaisedInput.value.replace(/,/g, '')) || 0;
    var TotalAmountRcvd = parseFloat(TotalAmountRcvdInput.value.replace(/,/g, '')) || 0;

    var outstandingBalance = (invraise - TotalAmountRcvd).toFixed(2);

    TotOutstndBalInput.value = formatToIndianNumberSystem(parseFloat(outstandingBalance));
}

function handleInputChanges() {
    totinvamt();
    TotalAmountRcvdByClient();
    TotOutstndBal();
}

stg1InvAmtinput.addEventListener("input", handleInputChanges);
stg2InvAmtinput.addEventListener("input", handleInputChanges);
stg3InvAmtinput.addEventListener("input", handleInputChanges);
stg4InvAmtinput.addEventListener("input", handleInputChanges);
stg5InvAmtinput.addEventListener("input", handleInputChanges);

stg1pymntRcvdinput.addEventListener("input", handleInputChanges);
stg2pymntRcvdinput.addEventListener("input", handleInputChanges);
stg3pymntRcvdinput.addEventListener("input", handleInputChanges);
stg4pymntRcvdinput.addEventListener("input", handleInputChanges);
stg5pymntRcvdinput.addEventListener("input", handleInputChanges);

// Add event listener for stg1InvAmtinput on input
stg1InvAmtinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for stg2InvAmtinput on input
stg2InvAmtinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for stg3InvAmtinput on input
stg3InvAmtinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for stg4InvAmtinput on input
stg4InvAmtinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for stg5InvAmtinput on input
stg5InvAmtinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for stg1pymntRcvdinput on input
stg1pymntRcvdinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for stg2pymntRcvdinput on input
stg2pymntRcvdinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for stg3pymntRcvdinput on input
stg3pymntRcvdinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for stg4pymntRcvdinput on input
stg4pymntRcvdinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});

// Add event listener for stg5pymntRcvdinput on input
stg5pymntRcvdinput.addEventListener("input", function() {
    // Format the value when user inputs a value
    this.value = formatToIndianNumberSystem(parseFloat(this.value.replace(/,/g, '')) || 0);
    // Handle any additional calculations or processing here if needed
    handleInputChanges();
});





















