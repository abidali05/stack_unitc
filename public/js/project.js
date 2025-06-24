//Save Project
$('#project-form').on('submit', function (e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);
    let url = $(this).attr('data-route');

    // Reset error messages
    $('#store-error-messages').addClass('d-none').html('');

    // Disable button and show loading state
    $('#store-project-btn').prop('disabled', true).text('Saving...');

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Project Created',
                    text: response.message,
                }).then(() => {
                    form.reset();
                    var modalElement = document.getElementById('projectModal');
                    var modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.message,
                });
            }
        },
        error: function (xhr) {
            $('#store-project-btn').prop('disabled', false).text('Save Project');

            if (xhr.status === 422) { // Validation error
                let errors = xhr.responseJSON.errors;
                let errorHtml = '<ul>';
                $.each(errors, function (key, value) {
                    errorHtml += '<li>' + value[0] + '</li>'; // Display first error message per field
                });
                errorHtml += '</ul>';
                $('#store-error-messages').removeClass('d-none').html(errorHtml);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'There was an error submitting the form. Please try again.',
                });
            }
        },
        complete: function () {
            // Ensure the button state is reset
            $('#store-project-btn').prop('disabled', false).text('Save Project');
        }
    });
});

//Chart/Graph
fetch(graphRoute)
    .then(response => response.json())
    .then(chartData => {
        // Initialize the chart
        new Chart(document.getElementById('project-bar-chart'), {
            type: 'bar',
            data: {
                labels: chartData.map(project => project.project_name), // Project names
                datasets: [
                    {
                        label: 'In Progress',
                        data: chartData.map(project => project.inprogress), // Correct key here
                        backgroundColor: 'rgb(57, 129, 249)',
                        borderColor: 'rgb(57, 129, 249)',
                        borderWidth: 1
                    },
                    {
                        label: 'On Hold',
                        data: chartData.map(project => project.hold), // On hold counts
                        backgroundColor: 'rgb(71, 188, 231)',
                        borderColor: 'rgb(71, 188, 231)',
                        borderWidth: 1
                    },
                    {
                        label: 'Overdue',
                        data: chartData.map(project => project.overdue), // Overdue counts
                        backgroundColor: 'rgb(106, 206, 243)',
                        borderColor: 'rgb(106, 206, 243)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top' // Position of the legend
                    }
                },
                scales: {
                    x: {
                        stacked: true // Enable stacking for the x-axis
                    },
                    y: {
                        stacked: true, // Enable stacking for the y-axis
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Error fetching chart data:', error);
    });

//Datatables
$(document).ready(function () {
    var table = $('#projects-table').DataTable({
        paging: true,
        searching: true,
        ordering: false,
        info: false,
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const min = $('#min-date').val();
        const max = $('#max-date').val();

        const row = table.row(dataIndex).node();
        const startDateStr = $(row).find('.hidden-start-date').val();
        const parsedDate = new Date(startDateStr);

        const minDate = min ? new Date(min) : null;
        const maxDate = max ? new Date(max) : null;

        if (
            (!minDate || parsedDate >= minDate) &&
            (!maxDate || parsedDate <= maxDate)
        ) {
            return true;
        }
        return false;
    });


    $('#min-date, #max-date').on('change', function () {
        table.draw();
    });

    $('#clear-date-filter').on('click', function () {
        $('#min-date').val('');
        $('#max-date').val('');
        table.draw();
    });

    $('#all').on('click', function () {
        $('#projects-table .project-row').show();
        table.draw();
    });

    $('#upcoming').on('click', function () {
        let currentDate = new Date();
        let oneWeekLater = new Date();
        oneWeekLater.setDate(currentDate.getDate() + 7);

        $('#projects-table .project-row').each(function () {
            let deadlineText = $(this).find('.project-deadline').text().trim();

            let deadline = new Date(currentDate); // Start from today

            // Check if the deadlineText contains "months" or "days"
            if (/(\d+)\s*months?/.test(deadlineText) || /(\d+)\s*days?/.test(deadlineText)) {
                let monthsMatch = deadlineText.match(/(\d+)\s*months?/);
                let daysMatch = deadlineText.match(/(\d+)\s*days?/);

                if (monthsMatch) {
                    let monthsToAdd = parseInt(monthsMatch[1], 10);
                    deadline.setMonth(deadline.getMonth() + monthsToAdd);
                }

                if (daysMatch) {
                    let daysToAdd = parseInt(daysMatch[1], 10);
                    deadline.setDate(deadline.getDate() + daysToAdd);
                }
            }
            if (deadline >= currentDate && deadline <= oneWeekLater) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        table.draw();
    });

    $('#overdue').on('click', function () {
        $('#projects-table .project-row').each(function () {
            var deadlineText = $(this).find('.hidden-deadline').val()?.trim();

            var deadline = new Date(deadlineText.split(' ')[0] + "T00:00:00"); // Ensures consistent parsing
            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0); // Ignore time for accurate comparison

            if (deadline < currentDate) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        table.draw();
    });

    $('#projectFilter').on('change', function () {
        const selectedProjectId = $(this).val();
        const allRows = $('#projects-table .project-row');

        if (selectedProjectId === 'all') {
            allRows.show();
        } else {
            allRows.each(function () {
                const rowProjectId = $(this).find('.project-name').data('id').toString();
                if (rowProjectId === selectedProjectId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        table.draw(); // Redraw the DataTable
    });


    $(document).on('click', '.edit-btn', function () {
        const projectId = $(this).data('id');
        const route = projectEditRoute.replace(':id', projectId);
        // console.log(route)
        $.ajax({
            url: route,
            type: 'GET',
            success: function (data) {

                const deadline = data.deadline.split('T')[0];
                const start_date = data.start_date.split('T')[0];

                $('#edit_project_name').val(data.project_name);
                $('#edit_user_id').val(data.user_id);
                $('#edit_task').val(data.task);
                $('#edit_deadline').val(deadline);
                $('#edit_start_date').val(start_date);
                $('#edit_status').val(data.status);
                $('#edit_category').val(data.category);

                $('#update-project-form').attr('action', `/project/${projectId}`);
                $('#update-project-form').attr('data-id', projectId);
            },
            error: function (xhr) {
                console.error('Error fetching project data:', xhr);
            },
        });
    });

    $('#update-project-form').on('submit', function (e) {

        e.preventDefault();

        const form = this;
        const projectId = $(this).attr('data-id');
        const url = `/project/${projectId}`;
        let formData = new FormData(form);
        formData.append('_method', 'PUT');

        function getStatusClass(status) {
            switch (status) {
                case 'todo': return 'bg-primary';
                case 'inprogress': return 'bg-danger';
                case 'hold': return 'bg-dark';
                case 'completed': return 'bg-success';
                case 'reopen': return 'bg-warning';
                default: return '';
            }
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }


        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            beforeSend: function () {
                $('#update-error-messages').addClass('d-none').html('');
                $('#update-project-btn').prop('disabled', true).text('Updating...');
            },
            success: function (response) {
                $('#update-error-messages').addClass('d-none').html('');
                Swal.fire({
                    icon: 'success',
                    title: 'Project Updated',
                    text: response.message,
                }).then(() => {
                    form.reset();
                    $('#update-project-btn').prop('disabled', false).text('Update');
                    var modalElement = document.getElementById('editProjectModal');
                    var modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();
                    const row = $(`.edit-btn[data-id="${projectId}"]`).closest('tr');

                    row.find('.project-name').text(response.project.project_name);
                    row.find('td:eq(1)').text(response.project.user_name);
                    row.find('td:eq(2)').text(response.project.task);
                    row.find('td:eq(3)').text(response.project.start_date_formatted);
                    row.find('td:eq(4)').text(response.project.end_date_formatted || '—');
                    row.find('.project-deadline').html(`
                        ${response.project.expected_days}
                        <input type="hidden" class="hidden-deadline" value="${response.project.deadline}">
                    `);
                    row.find('td:eq(6)').text(response.project.days_used);
                    row.find('td:eq(7) span')
                        .attr('class', getStatusClass(response.project.status))
                        .text(capitalizeFirstLetter(response.project.status));
                    row.find('td:eq(8)').text(response.project.category);
                });
            },
            error: function (xhr) {
                $('#update-project-btn').prop('disabled', false).text('Update');
                if (xhr.status === 422) { // Validation error
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#update-error-messages').removeClass('d-none').html(errorHtml);
                } else {
                    alert('Something went wrong. Please try again.');
                }
            }
        });
    });

    $(document).on('click', '.view-btn', function () {
        const projectId = $(this).data('id');
        const route = projectShowRoute.replace(':id', projectId);

        $.ajax({
            url: route,
            type: 'GET',
            success: function (data) {
                console.log(data);
                // Set modal fields with fetched data
                $('#view-project-name').text(data.project_name);
                $('#view-project-user').text(data.user_name);
                $('#view-project-task').text(data.task);
                $('#view-project-deadline').text(data.deadline);
                $('#view-project-status').text(data.status);
                $('#view-project-views span').text(data.view_count);  // Updating view count

                // Set project category
                $('#view-project-category').text(data.category); // Assuming 'category' is included in the response

                // Set project dates (Start Date, Deadline, End Date)
                $('#view-project-start-date').text(data.start_date);
                $('#view-project-deadline').text(data.deadline);
                $('#view-project-end-date').text(data.end_date || "Not yet completed");

                // Check if there's a document and display link
                if (data.document) {
                    $('#view-project-document').html('<a href="' + data.document + '" target="_blank" title="Click to view the attached document">View Document</a>');
                } else {
                    $('#view-project-document').html('No document attached');
                }
            },
            error: function (xhr) {
                console.error('Error fetching project data:', xhr);
            },
        });
    });


    $(document).on('click', '.delete-btn', function () {
        const projectId = $(this).data('id');
        const route = projectShowRoute.replace(':id', projectId);;

        Swal.fire({
            title: 'Are you sure?',
            text: 'This project will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: route,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    success: function (response) {
                        Swal.fire('Deleted!', 'The project has been deleted.', 'success');
                        location.reload();
                    },
                    error: function () {
                        Swal.fire('Error!', 'An error occurred while deleting the project.', 'error');
                    },
                });
            }
        });
    });

    // datatable buttons
    const buttons = document.querySelectorAll('.filter-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            buttons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.background = 'white';
                btn.style.color = 'black';
                btn.style.border = 'none';
            });

            this.classList.add('active');
            this.style.background = '#0C5097';
            this.style.color = 'white';
            this.style.border = 'none';
        });
    });
});

document.getElementById('category').addEventListener('change', function () {
    var customCategoryField = document.getElementById('custom-category');
    if (this.value === 'custom') {
        customCategoryField.style.display = 'block';
    } else {
        customCategoryField.style.display = 'none';
    }
});

document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener("click", function (event) {
        let projectElement = event.target.closest(".project-name");
        if (!projectElement) return;

        let projectId = projectElement.getAttribute("data-id");
        let modalTarget = projectElement.getAttribute("data-bs-target");
        let modal = document.querySelector(modalTarget);

        fetch(`/projects/${projectId}`)
            .then(response => response.json())
            .then(data => {
                let projectIdEl = modal.querySelector(".projectId");
                let projectTitleEl = modal.querySelector(".projectTitle");
                let projectPostedDateEl = modal.querySelector(".projectPostedDate");
                let assignedToEl = modal.querySelector(".assignedTo");
                let assignedByEl = modal.querySelector(".assignedBy");
                let startDateEl = modal.querySelector(".startDate");
                let endDateEl = modal.querySelector(".endDate");
                let expectedDaysEl = modal.querySelector(".expectedDays");
                let daysUsedEl = modal.querySelector(".daysUsed");
                let projectStatusEl = modal.querySelector(".projectStatus");
                let projectDescriptionEl = modal.querySelector(".projectDescription");
                let statusBodyEl = modal.querySelector(".statusHistoryBody");

                setTimeout(() => {
                    let statusBadge = modal.querySelector(".project-details .badge");

                    if (statusBadge) {
                        statusBadge.textContent = data.status;
                        statusBadge.className = `badge bg-${data.status_color}`;
                    }
                }, 300);

                projectDescriptionEl.innerHTML = `<p>${data.task || "No description available"}</p>`;

                projectIdEl.textContent = `#${data.id}`;
                projectTitleEl.textContent = data.title;
                projectPostedDateEl.textContent = `Posted on: ${data.posted_date}`;
                assignedToEl.textContent = data.assigned_to;
                assignedByEl.textContent = data.assigned_by;
                startDateEl.textContent = data.start_date;
                endDateEl.textContent = data.end_date;
                expectedDaysEl.textContent = data.expected_days;
                daysUsedEl.textContent = data.days_used;

                if (statusBodyEl) {
                    statusBodyEl.innerHTML = "";
                    data.status_history.forEach(status => {
                        statusBodyEl.innerHTML += `
                            <tr>
                                <td><span class="badge bg-${status.color}">${status.status}</span></td>
                                <td>${status.category || "N/A"}</td>
                                <td>${status.date}</td>
                                <td>${status.updated_by}</td>
                            </tr>`;
                    });
                }
            })
            .catch(error => console.error("❌ Error fetching project data:", error));
    });

    document.querySelectorAll(".fa-paperclip").forEach(icon => {
        icon.addEventListener("click", function () {
            let taskId = this.getAttribute("data-task-id");

            if (taskId) {
                fetch(`/get-project-files/${taskId}`)
                    .then(response => response.json())
                    .then(data => {
                        let modalBody = document.querySelector("#CreateProjectTaskFileUpload .modal-body");
                        modalBody.innerHTML = "";
                        if (data.files.length > 0) {
                            data.files.forEach(file => {
                                let preview = '';
                                const fileUrl = file.document;
                                const fileName = fileUrl.split('/').pop();
                                const extension = fileUrl.split('.').pop().toLowerCase();

                                switch (extension) {
                                    case 'jpg':
                                    case 'jpeg':
                                    case 'png':
                                    case 'gif':
                                    case 'webp':
                                        preview = `<img src="/${fileUrl}" alt="${fileName}" class="img-fluid mb-2" style="max-height: 300px; width:100%; object-fit:cover">`;
                                        break;
                                    case 'pdf':
                                        preview = `<embed src="/${fileUrl}" type="application/pdf" width="100%" height="300px" class="mb-2"/>`;
                                        break;
                                    case 'mp4':
                                    case 'webm':
                                    case 'ogg':
                                        preview = `<video controls width="100%" class="mb-2"><source src="/${fileUrl}" type="video/${extension}">Your browser does not support the video tag.</video>`;
                                        break;
                                    default:
                                        preview = `<a href="/${fileUrl}" class="btn btn-primary mb-2" download>Download ${fileName}</a>`;
                                }

                                modalBody.innerHTML += `<div class="file-item">${preview}</div>`;
                            });

                        } else {
                            modalBody.innerHTML = "<p>No files uploaded for this task.</p>";
                        }
                    })
                    .catch(error => console.error("Error fetching task files:", error));
            }
        });
    });

    function showContent(contentId) {
        let content1 = document.getElementById('content1');
        let content2 = document.getElementById('content2');
        let filterSection = document.querySelector('#filter');
        let dropdownSection = document.querySelector('#dropdown');

        if (contentId === 'content1') {
            content1.classList.add("show");
            content2.classList.remove("show");
            if (filterSection) filterSection.classList.remove("d-none");
            if (dropdownSection) dropdownSection.classList.add("d-none");

            // Fetch updated projects when switching to content1
            fetchUpdatedProjects();
        } else {
            content2.classList.add("show");
            content1.classList.remove("show");
            if (filterSection) filterSection.classList.add("d-none");
            if (dropdownSection) dropdownSection.classList.remove("d-none");
        }
    }

    // Attach function to global scope
    window.showContent = showContent;

});

document.addEventListener("DOMContentLoaded", function () {
    let lists = document.querySelectorAll(".project-list");
    let route = updateTaskUrl;


    lists.forEach(list => {
        new Sortable(list, {
            group: "tasks",
            animation: 150,
            onEnd: function (evt) {
                let taskId = evt.item.getAttribute("data-id");
                let newStatus = evt.to.getAttribute("data-status");

                fetch(route, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({ task_id: taskId, status: newStatus })
                }).then(response => response.json())
                    .then(data => {
                        document.querySelector("#completedProjectsCount").textContent = data.completedProjects;
                        document.querySelector("#inProgressProjectsCount").textContent = data.inProgressProjects;
                        document.querySelector("#overdueProjectsCount").textContent = data.overdueProjects;
                        document.querySelector("#holdProjectsCount").textContent = data.holdProjects;
                    })
                    .catch(error => console.error("Error:", error));
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".collapse-task-trigger").forEach(trigger => {
        let targetId = trigger.getAttribute("data-bs-target");
        let collapseElement = document.querySelector(targetId);

        // Initialize icon state based on collapse visibility
        if (collapseElement.classList.contains("show")) {
            trigger.classList.remove("fa-chevron-down");
            trigger.classList.add("fa-chevron-up");
        } else {
            trigger.classList.remove("fa-chevron-up");
            trigger.classList.add("fa-chevron-down");
        }

        // Listen for Bootstrap collapse events
        collapseElement.addEventListener("shown.bs.collapse", function () {
            trigger.classList.remove("fa-chevron-down");
            trigger.classList.add("fa-chevron-up");
        });

        collapseElement.addEventListener("hidden.bs.collapse", function () {
            trigger.classList.remove("fa-chevron-up");
            trigger.classList.add("fa-chevron-down");
        });
    });
});

function fetchUpdatedProjects() {
    let route = fetchProjects;
    fetch(route)
        .then(response => response.json())
        .then(data => {
            updateProjectsTable(data.projects);
        })
        .catch(error => console.error('Error fetching updated projects:', error));
}

function updateProjectsTable(projects) {
    let tbody = document.querySelector("#projects-table tbody");
    tbody.innerHTML = ''; // Clear old data

    if (projects.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">No Projects</td></tr>';
        return;
    }

    projects.forEach(project => {
        let statusClass = project.status === 'todo' ? 'bg-primary' :
            project.status === 'inprogress' ? 'bg-danger' :
                project.status === 'hold' ? 'bg-dark' :
                    project.status === 'completed' ? 'bg-success' :
                        project.status === 'reopen' ? 'bg-warning' : '';

        let row = `
            <tr class="project-row" style="background: #F2F2F2;">
                <td style="font-size: 12px; cursor: pointer;" class="project-name"
                    data-id="${project.id}" data-bs-toggle="modal"
                    data-bs-target="#statusHistoryModal">
                    ${project.project_name}
                </td>
                <td style="font-size: 12px;">${project.user.name}</td>
                <td style="font-size: 12px;">${project.task}</td>
                <td style="font-size: 12px;">${formatDate(project.start_date)}</td>
                <td style="font-size: 12px;">${formatDate(project.end_date)}</td>
                <td style="font-size: 12px;" class="project-deadline">
                    ${project.expected_days ?? ''}</td>
                <td style="font-size: 12px;">${project.days_used ?? ''}</td>
                <td class="text-center">
                    <span class="${statusClass}"
                          style="font-size:12px; border-radius: 5px; width: 100px; display: inline-block; padding: 0.25rem; font-weight: 400; color:white">
                          ${project.status.charAt(0).toUpperCase() + project.status.slice(1)}
                    </span>
                </td>
                <td style="font-size: 12px;">${project.category}</td>
                <td>
                    <a href="#" class="edit-btn" style="text-decoration: none" data-id="${project.id}" data-bs-toggle="modal"
                       data-bs-target="#editProjectModal">
                        <i class="fas fa-edit" style="font-size: 16px; color: #ffc107;"></i>
                    </a>
                    <a href="#" class="view-btn" style="text-decoration: none" data-id="${project.id}" data-bs-toggle="modal"
                       data-bs-target="#viewProjectModal">
                        <i class="fas fa-eye" style="font-size: 16px; color: #0C5097;"></i>
                    </a>
                    <a href="#" class="delete-btn" style="text-decoration: none" data-id="${project.id}">
                        <i class="fas fa-trash-alt" style="font-size: 16px; color: #dc3545;"></i>
                    </a>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function formatDate(dateString) {
    if (!dateString) return '—';

    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    }).format(date);
}


document.addEventListener("DOMContentLoaded", function () {
    const dropdown = document.getElementById("projectDropdown");
    const tasks = document.querySelectorAll(".project-list-item");

    function filterTasks(selectedProject) {
        tasks.forEach(task => {
            const projectName = task.querySelector(".selected-project").textContent.toLowerCase();
            if (selectedProject === "" || projectName.includes(selectedProject)) {
                task.style.display = "block"; // Show task
            } else {
                task.style.display = "none"; // Hide task
            }
        });
    }

    // Set the first project as default and trigger filtering
    if (dropdown.options.length > 0) {
        dropdown.selectedIndex = 0; // Select first project after "Select a Project"
        filterTasks(dropdown.value.toLowerCase()); // Filter tasks based on the first project
    }

    // Listen for dropdown changes
    dropdown.addEventListener("change", function () {
        filterTasks(this.value.toLowerCase());
    });
});

