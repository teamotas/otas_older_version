<?php
// function formatMultipleDates($multipleDatesString) {
//     $cleaned_dates = stripslashes($multipleDatesString);
//     $cleaned_dates = trim($cleaned_dates, '"');
//     $dates = explode(', ', $cleaned_dates);
//     $formattedDates = [];

//     foreach ($dates as $date) {
//         // Parse the date into a DateTime object
//         $dateTime = DateTime::createFromFormat('d-m-Y', $date);

//         // Check if parsing was successful and the date is valid
//         if ($dateTime !== false && $dateTime->format('d-m-Y') === $date) {
//             // Format the date as "d M Y" (e.g., "26 Oct 2023")
//             $formattedDates[] = $dateTime->format('d M Y');
//         }
//     }

//     // Return the formatted dates as a comma-separated string
//     return implode(", ", $formattedDates);
// }

function formatMultipleDates($multipleDatesString) {
    $cleaned_dates = stripslashes($multipleDatesString);
    $cleaned_dates = trim($cleaned_dates, '"');
    $dates = explode(', ', $cleaned_dates);
    $formattedDates = [];

    foreach ($dates as $date) {
        // Parse the date into a DateTime object
        $dateTime = DateTime::createFromFormat('d-m-Y', $date);

        // Check if parsing was successful and the date is valid
        if ($dateTime !== false && $dateTime->format('d-m-Y') === $date) {
            // Format the date as "d.m.Y" (e.g., "18.01.2024")
            $formattedDates[] = $dateTime->format('d.m.Y');
        }
    }

    // Return the formatted dates as a comma-separated string
    return implode(", ", $formattedDates);
}


function setFormattedDateCellValue($sheet, $cell, $dateValue) {
    if ($dateValue !== '0000-00-00') {
        $formattedDate = date('d.m.Y', strtotime($dateValue));
    } else {
        $formattedDate = '';
    }
    $sheet->setCellValue($cell, $formattedDate);
}

function formatDate($date) {
    if (empty($date) || $date === "0000-00-00") {
        return "Not Declared"; 
    }

    $months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

    $dateObj = date_create($date);

    $year = date_format($dateObj, 'Y');
    $monthIndex = date_format($dateObj, 'n') - 1;
    $monthAbbreviation = $months[$monthIndex];
    $day = date_format($dateObj, 'd');

    $formattedDate = $day . ' ' . $monthAbbreviation . ' ' . $year;

    return $formattedDate;
}

function formatDualDate($startDate, $endDate, $format = 'd-m-Y') {
    if ($startDate !== '0000-00-00' || $endDate !== '0000-00-00') {
        $formattedStartDate = ($startDate !== '0000-00-00') ? date($format, strtotime($startDate)) : '';
        $formattedEndDate = ($endDate !== '0000-00-00') ? date($format, strtotime($endDate)) : '';

        if ($formattedStartDate && $formattedEndDate) {
            return $formattedStartDate . "/" . $formattedEndDate;
        } elseif ($formattedStartDate) {
            return $formattedStartDate . "/";
        } elseif ($formattedEndDate) {
            return "/" . $formattedEndDate;
        } else {
            return '';
        }
    } else {
        return '';
    }
}

// Usage:
// echo formatDualDate($res['ObjMngLiveDate'], $res['ObjMngEndDate']);

// function getFormattedDate($date) {
//     if ($date !== '0000-00-00') {
//         $cleaned_dates = stripslashes($date);
//         $cleaned_dates = trim($cleaned_dates, '"');
//         $dates = explode(', ', $cleaned_dates);
//         if (!empty($dates)) {
//             $MULTIPLE_dates = implode(", ", $dates);
//             return $MULTIPLE_dates;
//         } else {
//             return '';
//         }
//     } else {
//         return '';
//     }
// }
function formatNumberIndianStyle($number) {
    if ($number === null) {
        return '';
    }
    // Determine the original data type of the input number
    $originalType = is_float($number) ? 'float' : 'int';

    // Convert the number to a string
    $numberStr = strval($number);

    // Reverse the string for easier grouping every 2 digits from the right
    $reversedNumberStr = strrev($numberStr);

    // Use regex to insert a comma every 2 digits from the right, starting from the 3rd digit
    $formattedNumber = preg_replace("/(\d{2})(?=\d)(?<=\d{3})/", "$1,", $reversedNumberStr);

    // Reverse it back to the original order
    $formattedNumber = strrev($formattedNumber);

    return $formattedNumber;
}


    
?>