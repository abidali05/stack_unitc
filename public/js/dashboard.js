document.addEventListener('DOMContentLoaded', function () {
    loadEmails('inbox');

    document.querySelectorAll('#emailCategoryDropdown .dropdown-item').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            const type = this.dataset.type;
            const label = this.textContent.trim();

            const dropdownBtn = document.getElementById('emailCategoryDropdownBtn');
            dropdownBtn.innerHTML = this.innerHTML;

            document.querySelectorAll('#emailCategoryDropdown .dropdown-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            loadEmails(type);
        });
    });

    function loadEmails(type) {
        fetch(`emails/filter?type=${type}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('emailTableBody').innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching emails:', error);
        });
    }
});

function openFile(filePath) {
    const extension = filePath.split('.').pop().toLowerCase();

    if (extension === 'pdf') {
        window.open(filePath, '_blank');
    } else if (extension === 'txt') {
        window.open(filePath, '_blank');
    } else if (extension === 'xls' || extension === 'xlsx') {
        window.open(filePath, '_blank');
    } else if (extension === 'jpeg' || extension === 'jpg' || extension === 'png') {
        window.open(filePath, '_blank');
    } else if (extension === 'doc' || extension === 'docx') {
        window.open(filePath, '_blank');
    } else if (extension === 'ppt' || extension === 'pptx') {
        window.open(filePath, '_blank');
    } else {
        alert('File type not supported for viewing in the browser.');
    }
}

function renameFile(fileId) {
    let newName = prompt("Enter new file name:");
    if (newName) {
        if (!newName.trim()) {
            alert("File name cannot be empty.");
            return;
        }

        fetch(`files/rename/${fileId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ new_name: newName }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "Success!",
                        text: "File renamed successfully.",
                        icon: "success",
                    }).then(() => {
                        location.reload();
                    })
                } else {
                    Swal.fire({
                        title: "Error",
                        text: data.message || "An error occurred while renaming the file.",
                        icon: "error",
                    })
                }
            }).catch(error => {
                console.error("Error renaming file:", error);
                Swal.fire({
                    title: "Error",
                    text: "An error occurred while renaming the file.",
                    icon: "error",
                });
            });

    }
}

function downloadFile(filePath, type) {
    if (type === 'folder') {
        downloadFolderWithJSZip(filePath);
    } else {
        const link = document.createElement('a');
        link.href = filePath;
        link.download = filePath.split('/').pop();
        link.click();
    }
}

async function downloadFolderWithJSZip(folderPath) {
    try {
        const response = await fetch(`/download-folder/${encodeURIComponent(folderPath)}`);
        const data = await response.json();

        if (!data.files || data.files.length === 0) {
            alert("No files found in the folder.");
            return;
        }

        const zip = new JSZip();
        const folderName = folderPath.split('/').pop();

        // Fetch & Add each file to ZIP
        const filePromises = data.files.map(async (fileUrl) => {
            const fileResponse = await fetch(fileUrl);
            const blob = await fileResponse.blob();
            const fileName = fileUrl.split('/').pop();
            zip.file(fileName, blob);
        });

        await Promise.all(filePromises);

        // Generate ZIP & Trigger Download
        const zipBlob = await zip.generateAsync({ type: "blob" });
        const zipUrl = URL.createObjectURL(zipBlob);
        const a = document.createElement("a");
        a.href = zipUrl;
        a.download = folderName + ".zip";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(zipUrl);
    } catch (error) {
        console.error("Error downloading folder:", error);
        alert("Failed to download folder.");
    }
}


document.addEventListener('click', function (event) {
    if (event.target.closest('.delete-file')) {
        const button = event.target.closest('.delete-file');
        const fileId = button.dataset.id;
        deleteFile(fileId);
    }
});


function deleteFile(fileId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/file-sync/${fileId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ file_id: fileId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Deleted!',
                            'Deleted Successfully.',
                            'success'
                        ).then(() => {
                            document.querySelector(`#file-${fileId}`).remove();
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an issue deleting the file.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was a network error.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }
    });
}

function openShareModal(fileId, filePath) {
    document.getElementById('fileId').value = fileId;

    Promise.all([
        fetch('/users').then(response => response.json()),
        fetch('/teams').then(response => response.json())
    ])
        .then(([users, teams]) => {
            const userDropdown = document.getElementById('users');
            const teamDropdown = document.getElementById('teams');
            userDropdown.innerHTML = '';
            teamDropdown.innerHTML = '';

            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.name;
                userDropdown.appendChild(option);
            });

            teams.forEach(team => {
                const option = document.createElement('option');
                option.value = team.id;
                option.textContent = team.team_name;
                teamDropdown.appendChild(option);
            });
            const modal = document.getElementById('shareModal');
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        })
        .catch(error => console.log('Error fetching users:', error));
}

// document.getElementById('shareFileForm').addEventListener('submit', function (event) {
//     event.preventDefault();

//     const formData = new FormData(this);

//     fetch('/share-file', {
//         method: 'POST',
//         body: formData,
//         headers: {
//             'X-CSRF-TOKEN': csrfToken,
//         },
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 const modal = bootstrap.Modal.getInstance(document.getElementById('shareModal'));
//                 modal.hide();

//                 Swal.fire({
//                     title: 'Success!',
//                     text: 'File shared successfully.',
//                     icon: 'success',
//                     confirmButtonText: 'OK',
//                 }).then(() => {
//                     location.reload();
//                 });
//             } else {
//                 alert('Error sharing file. Please try again.');
//             }
//         })
//         .catch(error => console.error('Error sharing file:', error));
// });

const shareFileForm = document.getElementById('shareFileForm');

if (shareFileForm) {
    shareFileForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('/share-file', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('shareModal'));
                    modal.hide();

                    Swal.fire({
                        title: 'Success!',
                        text: 'File shared successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    alert('Error sharing file. Please try again.');
                }
            })
            .catch(error => console.error('Error sharing file:', error));
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const maximizeIcon = document.getElementById('maximize-icon');
    const minimizeIcon = document.getElementById('minimize-icon');
    const emailTable = document.getElementById('email-table');
    const emailTable2 = document.querySelector('.email-table');
    const feed = document.getElementById('feed');
    const dashTable = document.querySelector('.dash-table');
    const belowDivs = document.getElementById('below-divs');
    const toggleIcon = document.getElementById('toggle-icon');

    // Add transition effect to elements
    emailTable.style.transition = 'height 0.5s ease, margin-bottom 0.5s ease';
    emailTable2.style.transition = 'height 0.5s ease';
    feed.style.transition = 'height 0.5s ease';
    dashTable.style.transition = 'right 0.5s ease, bottom 0.5s ease';

    // Store initial styles
    const initialStyles = {
        emailTableHeight: emailTable.style.height,
        emailTable2Height: emailTable2.style.height,
        feedHeight: feed.style.height,
        marginBottom: emailTable.style.marginBottom,
        dashTablePosition: dashTable.style.position,
        dashTableRight: dashTable.style.right,
        dashTableBottom: dashTable.style.bottom,
        belowDivsDisplay: belowDivs.style.display,
    };

    // Initialize icons visibility
    maximizeIcon.style.display = 'block';
    minimizeIcon.style.display = 'none';

    toggleIcon.addEventListener('click', function () {
        const isMaximized = maximizeIcon.style.display === 'none';

        if (!isMaximized) {
            // Maximize the email table
            maximizeIcon.style.display = 'none';
            minimizeIcon.style.display = 'block';

            emailTable.style.height = '335px';
            emailTable2.style.height = '335px';
            feed.style.height = '200px';
            emailTable.style.marginBottom = '40px';

            dashTable.style.position = 'absolute';
            dashTable.style.right = '-8px';
            dashTable.style.bottom = '-269px';

            belowDivs.style.display = 'none';
        } else {
            // Minimize and revert to the original styles
            maximizeIcon.style.display = 'block';
            minimizeIcon.style.display = 'none';

            emailTable.style.height = initialStyles.emailTableHeight;
            emailTable2.style.height = initialStyles.emailTable2Height;
            feed.style.height = initialStyles.feedHeight;
            emailTable.style.marginBottom = initialStyles.marginBottom;

            dashTable.style.position = initialStyles.dashTablePosition;
            dashTable.style.right = initialStyles.dashTableRight;
            dashTable.style.bottom = initialStyles.dashTableBottom;

            belowDivs.style.display = initialStyles.belowDivsDisplay;
        }
    });
});

// for later use

// document.addEventListener("DOMContentLoaded", function () {
//     const maximizeIcon = document.getElementById('maximize-icon-feed');
//     const minimizeIcon = document.getElementById('minimize-icon-feed');
//     const feed = document.getElementById('feed');
//     const feed2 = document.querySelector('.feed');

//     const dashTable = document.querySelector('.dash-table');
//     const belowDivs = document.getElementById('below-divs');
//     const toggleIcon = document.getElementById('toggle-icon-feed');
//     const emailTable = document.getElementById('email-table');
//     // const fileSyncDiv = document.querySelector('.file-sync');
//     // const calendarDiv = document.querySelector('.calendar');

//     // Store initial styles
//     const initialStyles = {
//         emailTableHeight: emailTable.style.height,
//         feedHeight: feed.style.height,
//         feed2Height: feed2.style.height,
//         feed2MaxHeight: feed2.style.maxHeight,
//         dashTablePosition: dashTable.style.position,
//         dashTableDisplay: dashTable.style.display,
//         belowDivsDisplay: belowDivs.style.display,
//         belowDivsPosition: belowDivs.style.position,
//         belowDivsTop: belowDivs.style.top,
//         // fileSyncDisplay: fileSyncDiv.style.display,
//         // calendarDisplay: calendarDiv.style.display,
//     };

//     // Initialize icons visibility
//     maximizeIcon.style.display = 'block';
//     minimizeIcon.style.display = 'none';

//     toggleIcon.addEventListener('click', function () {
//         const isMaximized = maximizeIcon.style.display === 'none';

//         if (!isMaximized) {
//             // Maximize the feed and hide below divs (file-sync, calendar)
//             maximizeIcon.style.display = 'none';
//             minimizeIcon.style.display = 'block';

//             emailTable.style.height = '200px';
//             feed.style.height = '382px';
//             feed2.style.height = '342px';
//             feed2.style.maxHeight = 'none';

//             belowDivs.style.position = 'absolute';
//             belowDivs.style.top = '199px';

//             dashTable.style.top = '-190px';

//             dashTable.style.display = 'none';

//             // Hide the calendar and file-sync divs when maximized
//             // fileSyncDiv.style.display = 'none';
//             // calendarDiv.style.display = 'none';
//         } else {
//             // Minimize the feed and show below divs
//             maximizeIcon.style.display = 'block';
//             minimizeIcon.style.display = 'none';

//             emailTable.style.height = initialStyles.emailTableHeight;
//             feed.style.height = initialStyles.feedHeight;
//             feed2.style.height = initialStyles.feed2Height;
//             feed2.style.maxHeight = initialStyles.feed2MaxHeight;

//             dashTable.style.position = initialStyles.dashTablePosition;
//             dashTable.style.display = initialStyles.dashTableDisplay;

//             belowDivs.style.display = initialStyles.belowDivsDisplay;
//             belowDivs.style.position = initialStyles.belowDivsPosition;
//             belowDivs.style.top = initialStyles.belowDivsTop;

//             // Show the file-sync and calendar divs again
//             // fileSyncDiv.style.display = initialStyles.fileSyncDisplay;
//             // calendarDiv.style.display = initialStyles.calendarDisplay;
//         }
//     });
// });

$(document).ready(function () {
    $('input[name="notification_type[]"]').on('change', function () {
        if (!$('input[name="notification_type[]"]:checked').length) {
            $('#systemNotification').prop('checked', true); // Default to system notification
        }
    });
});

$(document).ready(function () {
    let attendeesSelect = $('#attendees');

    $.ajax({
        url: "/users", // Ensure this route returns JSON
        type: "GET",
        dataType: "json",
        success: function (users) {
            attendeesSelect.empty(); // Clear existing options

            if (users.length === 0) {
                attendeesSelect.append('<option disabled>No users found</option>');
            } else {
                $.each(users, function (index, user) {
                    attendeesSelect.append(`<option value="${user.id}">${user.name} (${user.email})</option>`);
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error loading users:", xhr.responseText);
        }
    });
});


$(document).ready(function () {
    $('#event-form').submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        formData.set('all_day', $('#allDayCheckbox').is(':checked') ? 1 : 0);

        $.ajax({
            url: storeEventRoute,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                if (response.message) {
                    $('#successMessage').removeClass('d-none').text(response.message);
                    $('#event-form')[0].reset();
                    Swal.fire(
                        'Created!',
                        'Event Created Successfully.',
                        'success'
                    );
                }
            },
        });
    });

    $('#allDayCheckbox').change(function () {
        let isChecked = $(this).is(':checked');
        $('input[name="event_start_time"], input[name="event_end_time"]').prop('disabled', isChecked);
    });

    $('input[name="recurrence_end"]').change(function () {
        $('#recurrenceDate').prop('disabled', $(this).val() !== 'on');
        $('#recurrenceOccurrences').prop('disabled', $(this).val() !== 'after');
    });
});

const deleteItem = document.getElementById('deleteItem');
if (deleteItem) {
    document.getElementById('deleteItem').addEventListener('click', function (event) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            document.getElementById('deleteForm').submit();
            //location.reload();
        })
    });
}

document.addEventListener("DOMContentLoaded", function () {
    function updateClock(clockElement, time) {
        let [hours, minutes] = time.split(":").map(Number);
        hours = hours % 12;

        clockElement.innerHTML = generateClockSVG(hours, minutes);
    }

    function generateClockSVG(hours, minutes) {
        let hourAngle = (hours * 30) + (minutes / 2);
        let minuteAngle = minutes * 6;

        return `
            <svg width="40" height="40" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" stroke="#000" stroke-width="5" fill="none"/>
                <line x1="50" y1="50" x2="${50 + 20 * Math.cos((hourAngle - 90) * Math.PI / 180)}"
                      y2="${50 + 20 * Math.sin((hourAngle - 90) * Math.PI / 180)}"
                      stroke="black" stroke-width="4"/>
                <line x1="50" y1="50" x2="${50 + 30 * Math.cos((minuteAngle - 90) * Math.PI / 180)}"
                      y2="${50 + 30 * Math.sin((minuteAngle - 90) * Math.PI / 180)}"
                      stroke="black" stroke-width="2"/>
                <circle cx="50" cy="50" r="3" fill="black"/>
            </svg>
        `;
    }

    function handleTimeChange(inputId, clockId) {
        let input = document.getElementById(inputId);
        let clockElement = document.getElementById(clockId);

        input.addEventListener("input", function () {
            updateClock(clockElement, this.value);
        });

        updateClock(clockElement, input.value);
    }

    handleTimeChange("event_start_time", "start-clock");
    handleTimeChange("event_end_time", "end-clock");
});


