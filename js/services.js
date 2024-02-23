const selectAllCheckboxes = document.getElementById("selectAll");
const checkboxes = document.querySelectorAll(".select-options input[type='checkbox']");
const selectedServicesInput = document.getElementById("selectedServices");
const servicesContainer = document.getElementById("servicesContainer");
const selectDropdown = document.querySelector(".select-dropdown");

// Add event listener to "Select All" checkbox
selectAllCheckboxes.addEventListener("change", function () {
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateSelectedServices();
});

// Add event listeners to individual checkboxes
checkboxes.forEach(checkbox => {
    checkbox.addEventListener("change", function () {
        updateSelectedServices();
        checkSelectAll();
    });
});

// Add click event listener to the dropdown icon and input field
servicesContainer.addEventListener("click", function () {
    toggleDropdown();
});

// Add click event listener to close dropdown when clicking outside
document.addEventListener("click", function (event) {
    if (!servicesContainer.contains(event.target) && !selectDropdown.contains(event.target)) {
        closeDropdown();
    }
});

// Function to toggle the display of the select-dropdown
function toggleDropdown() {
    if (selectDropdown.style.opacity === "1") {
        closeDropdown();
    } else {
        openDropdown();
    }
}

// Function to open the select-dropdown
function openDropdown() {
    selectDropdown.style.opacity = "1";
    selectDropdown.style.transform = "scaleY(1)";
}

// Function to close the select-dropdown
function closeDropdown() {
    selectDropdown.style.opacity = "0";
    selectDropdown.style.transform = "scaleY(0)";
}

// Function to update the selected services input field
function updateSelectedServices() {
    const selectedServices = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);

    selectedServicesInput.value = selectedServices.join(", ");

    checkboxes.forEach(checkbox => {
        const priceInput = document.getElementById(`${checkbox.value.toLowerCase()}Price`);
        if (priceInput) {
            priceInput.style.display = checkbox.checked ? 'block' : 'none';
        }
    });
}

// Function to check/uncheck "Select All" based on individual checkboxes
function checkSelectAll() {
    const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
    selectAllCheckboxes.checked = allChecked;
}




