$(document).ready(function () {
    $(".datepicker").flatpickr({ dateFormat: "Y-m-d" });
    $(".timepicker").flatpickr({ enableTime: true, noCalendar: true, dateFormat: "H:i" });
});

document.addEventListener("DOMContentLoaded", function () {
    const recurrenceRadios = document.querySelectorAll('input[name="recurrence_mode"]');
    const datePicker = document.getElementById("datepicker");
    const occurrencesInput = document.getElementById("occurrencesInput");

    function toggleRecurrenceFields() {
        if (document.getElementById("recurrenceOn").checked) {
            datePicker.disabled = false;
            occurrencesInput.disabled = true;
        } else if (document.getElementById("recurrenceAfter").checked) {
            datePicker.disabled = true;
            occurrencesInput.disabled = false;
        } else {
            datePicker.disabled = true;
            occurrencesInput.disabled = true;
        }
    }

    recurrenceRadios.forEach((radio) => {
        radio.addEventListener("change", toggleRecurrenceFields);
    });

    toggleRecurrenceFields(); // Initialize on page load
});



$(document).ready(function () {
    $("#allDayCheckbox").on("change", function () {
        if ($(this).is(":checked")) {
            $(".time-picker").prop("disabled", true);
        } else {
            $(".time-picker").prop("disabled", false);
        }
    });
});

document.getElementById("occurrencesInput").addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numbers
});
document.querySelectorAll(".nav-tabs a").forEach(tab => {
    tab.addEventListener("click", function (event) {
        event.preventDefault();
        document.querySelectorAll(".nav-tabs a").forEach(el => el.classList.remove("active"));
        this.classList.add("active");
    });
});

$(document).ready(function () {
    // Hide all tab content except the first one
    $(".tab-content").hide();
    $("#details-content").show(); // Show the first tab content

    $(".tab-link").click(function (e) {
        e.preventDefault();

        // Remove active class from all tabs and add to clicked tab
        $(".tab-link").removeClass("active");
        $(this).addClass("active");

        // Hide all tab contents
        $(".tab-content").hide();

        // Get the ID of the clicked tab and show the corresponding content
        let tabId = $(this).attr("id").replace("-tab", "-content");
        $("#" + tabId).fadeIn();
    });
});



