 stg1name
 stg2name
 stg3name
 stg4name
 stg5name

 document.addEventListener("DOMContentLoaded", function () {
    var stages = ["Advance", "Application Go live", "Admit Card", "CBT", "CBT with Submission of Merit List", "Medical/ Verification", "After Submission of CBT Result", "On final submission of offline records"];

    var dropdowns = document.querySelectorAll(".custom-dropdown");

    dropdowns.forEach(function (dropdown, index) {
        var selectedItems = dropdown.querySelector(".selected-items");
        var dropdownContent = dropdown.querySelector(".dropdown-content");

        // Create options for each dropdown
        for (var i = 0; i < stages.length; i++) {
            var option = document.createElement("label");
            option.innerHTML = `<input type="checkbox" id="stage${index + 1}_d_${i + 1}"  value="${stages[i]}" name="dropdown${index + 1}_option[]">&nbsp; ${stages[i]}`;
            dropdownContent.appendChild(option);

            // Check the checkbox if the value is present in the stored names
            if (window[`stg${index + 1}name`].split(', ').includes(stages[i])) {
                option.querySelector('input').checked = true;
            }
        }

        // Toggle dropdown on click
        selectedItems.addEventListener("click", function () {
            dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
            updateSelectedItems(); // Update selected items when dropdown is toggled
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (!dropdown.contains(event.target)) {
                dropdownContent.style.display = "none";
                updateSelectedItems(); // Update selected items when clicking outside
            }
        });

        // Handle checkbox changes using event delegation
        dropdownContent.addEventListener("change", function (event) {
            if (event.target.type === "checkbox") {
                updateSelectedItems();
            }
        });

        function updateSelectedItems() {
            var selectedOptions = Array.from(dropdownContent.querySelectorAll("input:checked")).map(function (checkbox) {
                return checkbox.value;
            });

            if (selectedOptions.length > 0) {
                selectedItems.textContent = selectedOptions.join(", ");
                document.getElementById("stageval" + `${index + 1}`).value = selectedItems.textContent;
            } else {
                selectedItems.textContent = "Select Stage";
            }
        }
    });
});























// document.addEventListener("DOMContentLoaded", function () {
//     var stages = ["Advance", "Application Go live", "Admit Card", "CBT", "CBT with Submission of Merit List", "Medical/ Verification", "After Submission of Cbt Result", "On final submission of offline records"];

//     var dropdowns = document.querySelectorAll(".custom-dropdown");

//     dropdowns.forEach(function (dropdown, index) {
//         var selectedItems = dropdown.querySelector(".selected-items");
//         var dropdownContent = dropdown.querySelector(".dropdown-content");

//         // Create options for each dropdown
//         for (var i = 0; i < stages.length; i++) {
//             var option = document.createElement("label");
//             option.innerHTML = `<input type="checkbox" id="stage${index+1}_d_${i+1}"  value="${stages[i]}" name="dropdown${index + 1}_option[]">&nbsp; ${stages[i]}`;
//             dropdownContent.appendChild(option);
//         }

//         // Toggle dropdown on click
//         selectedItems.addEventListener("click", function () {
//             dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
//             updateSelectedItems(); // Update selected items when dropdown is toggled
//         });

//         // Close dropdown when clicking outside
//         document.addEventListener("click", function (event) {
//             if (!dropdown.contains(event.target)) {
//                 dropdownContent.style.display = "none";
//                 updateSelectedItems(); // Update selected items when clicking outside
//             }
//         });

//         // Handle checkbox changes using event delegation
//         dropdownContent.addEventListener("change", function (event) {
//             if (event.target.type === "checkbox") {
//                 updateSelectedItems();
//             }
//         });

//         function updateSelectedItems() {
//             var selectedOptions = Array.from(dropdownContent.querySelectorAll("input:checked")).map(function (checkbox) {
//                 return checkbox.value;
//             });

//             if (selectedOptions.length > 0) {
                
//                 selectedItems.textContent = selectedOptions.join(", ");
//                 document.getElementById("stageval"+`${index+1}`).value=selectedItems.textContent;
//             } else {
//                 selectedItems.textContent = "Select Stage";
//             }
            
//         }
//     });
// });
