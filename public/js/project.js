// Global function definitions
window.addTaskRow = function () {
    taskRowCount++;
    $.ajax({
        url: '/get/users',
        method: 'GET',
        success: function (users) {
            let userOptions = '<select class="form-control form-control-sm" name="tasks[' + taskRowCount + '][assigned_to]"><option value="">Assign To</option>';
            users.forEach(user => {
                userOptions += `<option value="${user.id}">${user.name}</option>`;
            });
            userOptions += '</select>';

            $('#tasks-section').append(`
                <div class="task-row row g-0 align-items-end mt-2">
                    <div class="col-md-3 pe-1">
                        <input type="text" class="form-control form-control-sm" name="tasks[${taskRowCount}][title]" placeholder="Task Title" required>
                    </div>
                    <div class="col-md-3 px-1">
                        <input type="text" class="form-control form-control-sm" name="tasks[${taskRowCount}][description]" placeholder="Task Description">
                    </div>
                    <div class="col-md-2 px-1">
                        ${userOptions}
                    </div>
                    <div class="col-md-2 px-1">
                        <select class="form-control form-control-sm" name="tasks[${taskRowCount}][priority]">
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="col-md-1 px-1">
                        <input type="date" class="form-control form-control-sm" name="tasks[${taskRowCount}][due_date]">
                    </div>
                    <div class="col-md-1 ps-1 d-flex align-items-center">
                        <button type="button" class="btn btn-danger btn-sm remove-task" onclick="removeTaskRow(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `);
        },
        error: function (xhr) {
            console.error('Error fetching users:', xhr);
        }
    });
};

window.removeTaskRow = function (button) {
    $(button).closest('.task-row').remove();
};

window.showContent = function (contentId) {
    let content1 = $('#content1');
    let content2 = $('#content2');
    let filterSection = $('#filter');
    let dropdownSection = $('#dropdown');

    if (contentId === 'content1') {
        content1.addClass('show');
        content2.removeClass('show');
        filterSection.removeClass('d-none');
        dropdownSection.addClass('d-none');
        $('#projectFilter').val(selectedProjectId).trigger('change');
        fetchUpdatedTasks();
    } else {
        content2.addClass('show');
        content1.removeClass('show');
        filterSection.addClass('d-none');
        dropdownSection.removeClass('d-none');
        $('#projectDropdown').val(selectedProjectId).trigger('change');
        filterTasks(selectedProjectId);
    }
};

// Utility function to capitalize the first letter of a string
function ucFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function filterTasks(projectId) {
    $.ajax({
        url: fetchTasksRoute,
        method: 'GET',
        data: { project_id: projectId },
        success: function (data) {
            $('.project-list').empty();
            const statuses = ['todo', 'in_progress', 'onhold', 'done'];
            statuses.forEach(status => {
                const tasks = data.filter(task => task.status === status);
                const list = $(`.project-list[data-status="${status}"]`);
                tasks.forEach(task => {
                    list.append(`
                        <li class="project-list-item mb-3" data-id="${task.id}" data-project-id="${task.project_id || ''}"
                            style="background-color: #f9f9f9; border-radius: 5px; padding: 10px; border: 1px solid #ddd;">
                            <div class="list-item-header d-flex justify-content-between align-items-center">
                                <div class="task-assign-to">
                                    <span class="project-name v-align-middle name-${status} capitalize selected-project"
                                        style="cursor: pointer; font-weight: bold;"
                                        data-id="${task.id}" data-bs-toggle="modal" data-bs-target="#statusHistoryModal">
                                        ${task.title}
                                    </span>
                                </div>
                                <div class="collapse-task">
                                    <span class="d-inline-block tooltip-customize" data-bs-toggle="tooltip" title="Toggle Task Details">
                                        <i class="fas fa-chevron-down fw-bold collapse-task-trigger"
                                            data-bs-toggle="collapse" data-bs-target="#taskCollapse${task.id}"
                                            aria-expanded="false" aria-controls="taskCollapse${task.id}" data-toggle-icon></i>
                                    </span>
                                </div>
                            </div>
                            <div class="task-meta mt-2 mb-2" style="font-size: 12px; color: #666;">
                                <i class="far fa-calendar-alt me-1"></i>
                                ${task.project?.start_date && task.due_date ?
                            `${new Date(task.project.start_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} - ` +
                            `${new Date(task.due_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} ` +
                            `(${task.expected_days || 'N/A'} days)` :
                            task.due_date ? `Due: ${new Date(task.due_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}` :
                                `Start: ${task.project?.start_date ? new Date(task.project.start_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'N/A'}`
                        }
                            </div>
                            <div class="collapse project-list-collapse p-2" id="taskCollapse${task.id}">
                                <div class="list-content" style="color: #333; font-size: 14px;">
                                    <div><strong>Task:</strong> ${task.title}</div>
                                    <div><strong>Project:</strong> ${task.project_name || 'Unknown'}</div>
                                    <div><strong>Assigned To:</strong> ${task.assignee?.name || 'Unassigned'}</div>
                                    <div><strong>Priority:</strong>
                                        <span class="badge"
                                            style="background-color: ${task.priority === 'high' ? '#dc3545' : task.priority === 'medium' ? '#ffc107' : '#28a745'};">
                                            ${ucFirst(task.priority)}
                                        </span>
                                    </div>
                                </div>
                                <div class="list-footer d-flex align-items-center justify-content-between mt-2">
                                    <div></div>
                                    <div>
                                        <small class="text-muted">Created by: ${task.project?.creator?.name || 'Unknown'}</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `);
                });
            });
        },
        error: function (xhr) {
            console.error('Error fetching tasks:', xhr);
        }
    });
}

function formatDate(dateStr) {
    if (!dateStr) return '—';
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    }).replace(/,/, ''); // e.g., "08 Jul 2025"
}

function fetchUpdatedTasks() {
    $.ajax({
        url: fetchTasksRoute,
        method: 'GET',
        data: { project_id: selectedProjectId },
        success: function (data) {
            updateProjectsTable(data);
            if (typeof table !== 'undefined' && table.draw) {
                table.draw();
            } else {
                console.warn('Table is not initialized or draw method is unavailable');
            }
        },
        error: function (xhr) {
            console.error('Error fetching updated tasks:', xhr);
        }
    });
}

function updateProjectsTable(tasks) {
    let tbody = $('#projects-table tbody');
    tbody.empty();
    if (tasks.length === 0) {
        tbody.html('<tr><td colspan="8" class="text-center">No Tasks</td></tr>');
        return;
    }
    tasks.forEach(task => {
        let statusClass = task.status === 'todo' ? 'bg-primary' :
            task.status === 'in_progress' ? 'bg-info' : 'bg-success';
        let row = `
            <tr class="project-row" style="background: #F2F2F2;">
                <td style="font-size: 12px; cursor: pointer;" class="project-name"
                    data-id="${task.id}" data-bs-toggle="modal" data-bs-target="#statusHistoryModal">
                    ${task.title}
                </td>
                <td style="font-size: 12px;">${task.assignee?.name || 'Unassigned'}</td>
                <td style="font-size: 12px;">${task.description || '—'}</td>
                <td style="font-size: 12px;">
                    ${task.project?.start_date ? formatDate(task.project.start_date) : '—'}
                    <input type="hidden" class="hidden-start-date" value="${task.project?.start_date || ''}">
                </td>
                <td style="font-size: 12px;">
                    ${task.due_date ? formatDate(task.due_date) : '—'}
                    <input type="hidden" class="hidden-due-date" value="${task.due_date || ''}">
                </td>
                <td style="font-size: 12px;" class="project-deadline">
                    ${task.expected_days ?? '—'}
                    <input type="hidden" class="hidden-deadline" value="${task.due_date || ''}">
                </td>
                <td style="font-size: 12px;">${task.days_used ?? '—'}</td>
                <td class="text-center">
                    <span class="badge ${statusClass}"
                          style="font-size:12px; border-radius: 5px; width: 100px; display: inline-block; padding: 0.25rem; font-weight: 400; color:white">
                          ${ucFirst(task.status.replace('_', ' '))}
                    </span>
                </td>
                <td>
                    <a href="#" class="edit-btn" style="text-decoration: none" data-id="${task.id}" data-bs-toggle="modal"
                       data-bs-target="#editProjectModal">
                        <i class="fas fa-edit" style="font-size: 16px; color: #ffc107;"></i>
                    </a>
                    <a href="#" class="view-btn" style="text-decoration: none" data-id="${task.id}" data-bs-toggle="modal"
                       data-bs-target="#viewProjectModal">
                        <i class="fas fa-eye" style="font-size: 16px; color: #0C5097;"></i>
                    </a>
                    <a href="#" class="delete-btn" style="text-decoration: none" data-id="${task.id}">
                        <i class="fas fa-trash-alt" style="font-size: 16px; color: #dc3545;"></i>
                    </a>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

function updateChart() {
    $.ajax({
        url: graphRoute,
        method: 'GET',
        success: function (data) {
            let chart = Chart.getChart('project-bar-chart');
            chart.data.datasets[0].data = [
                data.completedTasks,
                data.inProgressTasks,
                data.todoTasks,
                data.overdueTasks
            ];
            chart.update();
        },
        error: function (xhr) {
            console.error('Error updating chart:', xhr);
        }
    });
}

// Routes from Blade view
const graphRoute = window.AppRoutes.graph;
const taskShowRoute = window.AppRoutes.taskShow;
const taskEditRoute = window.AppRoutes.taskEdit;
const taskStoreRoute = window.AppRoutes.taskStore;
const taskUpdateRoute = window.AppRoutes.taskUpdate;
const taskDeleteRoute = window.AppRoutes.taskDelete;
const taskUpdateStatusRoute = window.AppRoutes.taskUpdateStatus;
const commentStoreRoute = window.AppRoutes.commentStore;
const fetchTasksRoute = window.AppRoutes.fetchTasks;

let selectedProjectId = 'all';
let taskRowCount = 0;
let table; // Declare table globally

$(document).ready(function () {
    // Initialize DataTable
    table = $('#projects-table').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: false,
        info: false,
        processing: true,
        columnDefs: [
            { targets: [3, 4, 5, 6], searchable: false },
            { targets: 7, orderable: false }
        ]
    });

    // Date filter for DataTable
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        let min = $('#min-date').val();
        let max = $('#max-date').val();
        let startDate = $('.hidden-start-date').eq(dataIndex).val();
        let dueDate = $('.hidden-due-date').eq(dataIndex).val();
        let startDateParsed = startDate ? new Date(startDate) : null;
        let dueDateParsed = dueDate ? new Date(dueDate) : null;

        // Date filter logic
        let dateFilterPass = true;
        if (min && !max && startDateParsed && startDateParsed >= new Date(min)) {
            dateFilterPass = true;
        } else if (!min && max && dueDateParsed && dueDateParsed <= new Date(max)) {
            dateFilterPass = true;
        } else if (min && max && startDateParsed && dueDateParsed &&
            startDateParsed >= new Date(min) && dueDateParsed <= new Date(max)) {
            dateFilterPass = true;
        } else if (!min && !max) {
            dateFilterPass = true;
        } else {
            dateFilterPass = false;
        }

        // Project ID filter logic
        let projectId = table.row(dataIndex).node().getAttribute('data-project-id');
        let projectFilterPass = selectedProjectId === 'all' || projectId === selectedProjectId;

        return dateFilterPass && projectFilterPass;
    });

    $('#min-date, #max-date').on('change', function () {
        table.draw();
    });

    // Clear filters
    $('#clear-date-filter').on('click', function () {
        $('#min-date').val('');
        $('#max-date').val('');
        selectedProjectId = 'all';
        $('#projectFilter').val('all').trigger('change');
        table.draw();
    });

    // Upcoming deadlines filter
    $('#upcoming').on('click', function () {
        let today = new Date();
        let nextWeek = new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000);
        $('#min-date').val(today.toISOString().split('T')[0]);
        $('#max-date').val(nextWeek.toISOString().split('T')[0]);
        table.draw();
    });

    // Overdue tasks filter
    $('#overdue').on('click', function () {
        let today = new Date();
        $('#min-date').val('');
        $('#max-date').val(today.toISOString().split('T')[0]);
        table.column(7).search('^(?!done$).*$', true, false).draw();
    });

    // Filter buttons styling
    $('.filter-btn').on('click', function () {
        $('.filter-btn').removeClass('active').css({ background: 'white', color: 'black', border: 'none' });
        $(this).addClass('active').css({ background: '#0C5097', color: 'white', border: 'none' });
    });

    $('#projectFilter').select2({
        placeholder: "Select a project",
        allowClear: true,
        width: '150px',
        dropdownParent: $('#project-filter-wrapper'),
        templateResult: function (data) {
            if (!data.id) return data.text;
            return $('<span style="color: #000;">' + data.text + '</span>');
        },
        templateSelection: function (data) {
            return data.text || "All";
        }
    }).on('change', function () {
        selectedProjectId = $(this).val() || 'all'; // Ensure 'all' if no value is selected
        $('#projectDropdown').val(selectedProjectId).trigger('change');
        table.draw(); // Trigger DataTable redraw with the new filter
        filterTasks(selectedProjectId); // Update Kanban board
    });

    // Save Project/Task
    $('#project-form').on('submit', function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);
        let url = $(this).attr('data-route');

        $('#store-error-messages').addClass('d-none').html('');
        $('#store-project-btn').prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Project Created',
                        text: response.message,
                    }).then(() => {
                        form.reset();
                        $('#projectModal').modal('hide');

                        table.draw();
                        setTimeout(() => {
                            window.location.reload(); // Reload page after a short delay
                        }, 500); // Delay to allow Swal to close
                        updateChart();
                        filterTasks(selectedProjectId);
                    });
                }
            },
            error: function (xhr) {
                $('#store-project-btn').prop('disabled', false).text('Save Project');
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += `<li>${value[0]}</li>`;
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
                $('#store-project-btn').prop('disabled', false).text('Save Project');
            }
        });
    });

    // Populate Edit Modal
    $(document).on('click', '.edit-btn', function () {
        let taskId = $(this).data('id');
        $.ajax({
            url: taskEditRoute.replace(':id', taskId),
            type: 'GET',
            success: function (data) {
                $('#edit_task_id').val(data.id);
                $('#edit_project_id').val(data.project_id);
                $('#edit_title').val(data.title);
                $('#edit_description').val(data.description);
                $('#edit_assigned_to').val(data.assigned_to);
                $('#edit_due_date').val(data.due_date);
                $('#edit_status').val(data.status);
                $('#edit_priority').val(data.priority);
                $('#update-project-form').attr('action', taskUpdateRoute.replace(':id', taskId));
            },
            error: function (xhr) {
                console.error('Error fetching task data:', xhr);
            }
        });
    });

    // Update Task
    $('#update-project-form').on('submit', function (e) {
        e.preventDefault();
        let form = this;
        let url = $(this).attr('action');
        let formData = new FormData(form);
        formData.append('_method', 'PUT');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            beforeSend: function () {
                $('#update-error-messages').addClass('d-none').html('');
                $('#update-project-btn').prop('disabled', true).text('Updating...');
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Task Updated',
                    text: response.message,
                }).then(() => {
                    $('#editProjectModal').modal('hide');
                    table.draw();
                    setTimeout(() => {
                        window.location.reload(); // Reload page after a short delay
                    }, 500); // Delay to allow Swal to close
                    updateChart();
                    filterTasks(selectedProjectId);
                });
            },
            error: function (xhr) {
                $('#update-project-btn').prop('disabled', false).text('Update');
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += `<li>${value[0]}</li>`;
                    });
                    errorHtml += '</ul>';
                    $('#update-error-messages').removeClass('d-none').html(errorHtml);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'There was an error updating the task. Please try again.',
                    });
                }
            }
        });
    });

    // Delete Task
    $(document).on('click', '.delete-btn', function () {
        let taskId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This task will be permanently deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: taskDeleteRoute.replace(':id', taskId),
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    success: function (response) {
                        Swal.fire('Deleted!', response.message, 'success');
                        table.draw();
                        setTimeout(() => {
                            window.location.reload(); // Reload page after a short delay
                        }, 500); // Delay to allow Swal to close
                        updateChart();
                        filterTasks(selectedProjectId);
                    },
                    error: function () {
                        Swal.fire('Error!', 'An error occurred while deleting the task.', 'error');
                    }
                });
            }
        });
    });

    // Populate View Modal
    $(document).on('click', '.view-btn', function () {
        let taskId = $(this).data('id');
        $.ajax({
            url: taskShowRoute.replace(':id', taskId),
            type: 'GET',
            success: function (data) {
                $('#view-task-title').text(data.title);
                $('#view-task-status').text(ucFirst(data.status.replace('_', ' '))).removeClass('bg-primary bg-info bg-success').addClass(
                    data.status === 'todo' ? 'bg-primary' :
                        data.status === 'in_progress' ? 'bg-info' : 'bg-success'
                );
                $('#view-task-priority').html(`<i class="fas fa-exclamation-circle me-1"></i> ${ucFirst(data.priority)}`).removeClass('bg-danger bg-warning bg-success').addClass(
                    data.priority === 'high' ? 'bg-danger' :
                        data.priority === 'medium' ? 'bg-warning' : 'bg-success'
                );
                $('#view-task-project').text(data.project.name);
                $('#view-task-assigned-to').text(data.assignee?.name ?? 'Unassigned');
                $('#view-task-start-date').text(data.project.start_date ? new Date(data.project.start_date).toLocaleDateString() : '—');
                $('#view-task-due-date').text(data.due_date ? new Date(data.due_date).toLocaleDateString() : '—');
                $('#view-task-completed-at').text(data.completed_at ? new Date(data.completed_at).toLocaleDateString() : '—');
                $('#view-task-description').text(data.description || 'No description available.');
                let progress = data.status === 'done' ? 100 : data.status === 'in_progress' ? 50 : 0;
                $('#view-task-progress').css('width', `${progress}%`).attr('aria-valuenow', progress);
            },
            error: function (xhr) {
                console.error('Error fetching task data:', xhr);
            }
        });
    });

    // Populate Status History Modal
    $(document).on('click', '.project-name', function () {
        let taskId = $(this).data('id');
        $.ajax({
            url: taskShowRoute.replace(':id', taskId),
            type: 'GET',
            success: function (data) {
                $('.projectId').text(`#${data.id}`);
                $('.projectTitle').text(data.title);
                $('#priority').text(ucFirst(data.priority)).removeClass('bg-danger bg-warning bg-success').addClass(
                    data.priority === 'high' ? 'bg-danger' :
                        data.priority === 'medium' ? 'bg-warning' : 'bg-success'
                );
                $('.projectPostedDate').text(`Posted on: ${data.created_at ? new Date(data.created_at).toLocaleDateString() : '—'}`);
                $('.createdBy').text(data.project.creator?.name ?? '—');
                $('.assignedTo').text(data.assignee?.name ?? '—');
                $('.startDate').text(data.project.start_date ? new Date(data.project.start_date).toLocaleDateString() : '—');
                $('.dueDate').text(data.due_date ? new Date(data.due_date).toLocaleDateString() : '—');
                $('.expectedDays').text(data.expected_days ?? '—');
                $('.daysUsed').text(data.days_used ?? '—');
                $('.projectStatus').text(ucFirst(data.status.replace('_', ' '))).removeClass('bg-primary bg-info bg-success').addClass(
                    data.status === 'todo' ? 'bg-primary' :
                        data.status === 'in_progress' ? 'bg-info' : 'bg-success'
                );
                $('.priority')
                    .text(ucFirst(data.priority.replace('_', ' ')))
                    .removeClass('bg-primary bg-info bg-success bg-danger') // remove all potential priority classes
                    .addClass(
                        data.priority === 'low' ? 'bg-success' :
                            data.priority === 'medium' ? 'bg-warning' : // better than bg-primary for visibility
                                data.priority === 'high' ? 'bg-danger' : ''
                    );
                $('.projectDescription').text(data.description || 'No description available.');
                $('.statusHistoryBody').empty();
                data.status_history.forEach(history => {
                    $('.statusHistoryBody').append(`
                    <tr>
                        <td><span class="badge ${history.status === 'todo' ? 'bg-primary' : history.status === 'in_progress' ? 'bg-info' : 'bg-success'}">${history.status}</span></td>
                        <td>${ucFirst(history.priority)}</td>
                        <td>${new Date(history.date).toLocaleString()}</td>
                        <td>${history.updated_by}</td>
                    </tr>
                `);
                });
                $('#commentsContainer').empty();
                data.comments.sort((a, b) => new Date(a.created_at) - new Date(b.created_at)).forEach(comment => {
                    $('#commentsContainer').append(`
                    <div class="comment mb-3">
                        <div class="d-flex gap-2">
                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <strong>${comment.user}</strong>
                                    <small class="text-muted">${new Date(comment.created_at).toLocaleString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        timeZone: 'Asia/Karachi'
                    })}</small>
                                </div>
                                <p class="mb-0">${comment.comment}</p>
                            </div>
                        </div>
                    </div>
                `);
                });

                // Handle tab switch to adjust layout
                $('[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                    const tabPane = $(e.target).attr('data-bs-target');
                    // $('.tab-pane').removeClass('show active');
                    $(tabPane).addClass('show active');
                    $(tabPane).css('height', 'auto'); // Reset height to auto
                    $('#statusHistory, #commentsContainer').scrollTop(0); // Reset scroll
                    // Force reflow
                    $('.tab-content').height(); // Trigger reflow
                    $('.tab-content').css('height', 'auto');
                });
            },
            error: function (xhr) {
                console.error('Error fetching task data:', xhr);
            }
        });
    });

    // Store Comment
    $('#commentsContainer').on('click', '.btn-primary', function () {
        let input = $(this).prev('input');
        let commentText = input.val().trim();
        let taskId = $('.projectId').text().replace('#', '');
        if (commentText) {
            $.ajax({
                url: commentStoreRoute.replace(':id', taskId),
                type: 'POST',
                data: { comment: commentText, _token: csrfToken },
                success: function (response) {
                    $('#commentsContainer').append(`
                        <div class="comment mb-3">
                            <div class="d-flex gap-2">
                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong>${response.comment.user}</strong>
                                        <small class="text-muted">${new Date(response.comment.created_at).toLocaleString()}</small>
                                    </div>
                                    <p class="mb-0">${response.comment.comment}</p>
                                </div>
                            </div>
                        </div>
                    `);
                    input.val('');
                    $('#commentsContainer').scrollTop($('#commentsContainer')[0].scrollHeight);
                },
                error: function (xhr) {
                    console.error('Error saving comment:', xhr);
                }
            });
        }
    });

    $('#commentsContainer').on('keypress', '.comment-input input', function (e) {
        if (e.key === 'Enter') {
            $(this).next('button').click();
        }
    });

    // Chart.js Bar Chart
    fetch(graphRoute)
        .then(response => response.json())
        .then(data => {
            new Chart(document.getElementById('project-bar-chart'), {
                type: 'bar',
                data: {
                    labels: ['Completed', 'In Progress', 'Todo', 'Overdue'],
                    datasets: [{
                        label: 'Tasks',
                        data: [data.completedTasks, data.inProgressTasks, data.todoTasks, data.overdueTasks],
                        backgroundColor: ['#5aac44', '#00b8d9', '#5e6c84', '#F12117'],
                        borderColor: ['#5aac44', '#00b8d9', '#5e6c84', '#F12117'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Task Status Overview'
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching chart data:', error));

    // Sortable for Kanban Board
    $('.project-list').each(function () {
        new Sortable(this, {
            group: 'tasks',
            animation: 150,
            onEnd: function (evt) {
                let taskId = evt.item.getAttribute('data-id');
                let newStatus = evt.to.getAttribute('data-status');
                $.ajax({
                    url: taskUpdateStatusRoute.replace(':id', taskId),
                    method: 'PATCH',
                    data: { status: newStatus, _token: csrfToken },
                    success: function () {
                        table.draw();
                        setTimeout(() => {
                            window.location.reload(); // Reload page after a short delay
                        }, 500); // Delay to allow Swal to close
                        updateChart();
                        filterTasks(selectedProjectId);
                    },
                    error: function (xhr) {
                        console.error('Error updating task status:', xhr);
                    }
                });
            }
        });
    });

    // Collapse Task Trigger
    $('.collapse-task-trigger').each(function () {
        let targetId = $(this).attr('data-bs-target');
        let collapseElement = $(targetId);
        if (collapseElement.hasClass('show')) {
            $(this).removeClass('fa-chevron-down').addClass('fa-chevron-up');
        } else {
            $(this).removeClass('fa-chevron-up').addClass('fa-chevron-down');
        }
        collapseElement.on('shown.bs.collapse', () => {
            $(this).removeClass('fa-chevron-down').addClass('fa-chevron-up');
        });
        collapseElement.on('hidden.bs.collapse', () => {
            $(this).removeClass('fa-chevron-up').addClass('fa-chevron-down');
        });
    });

    // Project Dropdown Filter
    $('#projectDropdown').on('change', function () {
        selectedProjectId = $(this).val();
        $('#projectFilter').val(selectedProjectId).trigger('change');
        filterTasks(selectedProjectId);
    });

    // File Preview (Placeholder - requires backend implementation)
    $('.fa-paperclip').on('click', function () {
        let taskId = $(this).attr('data-task-id');
        if (taskId) {
            $.ajax({
                url: `/get-project-files/${taskId}`,
                method: 'GET',
                success: function (data) {
                    let modalBody = $('#CreateProjectTaskFileUpload .modal-body');
                    modalBody.empty();
                    if (data.files && data.files.length > 0) {
                        data.files.forEach(file => {
                            let preview = '';
                            const fileUrl = file.document;
                            const fileName = fileUrl.split('/').pop();
                            const extension = fileName.split('.').pop().toLowerCase();
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
                            modalBody.append(`<div class="file-item">${preview}</div>`);
                        });
                    } else {
                        modalBody.html('<p>No files uploaded for this task.</p>');
                    }
                },
                error: function (xhr) {
                    console.error('Error fetching task files:', xhr);
                }
            });
        }
    });

    // Utility Functions
    function ucFirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function formatDate(dateString) {
        if (!dateString) return '—';
        return new Intl.DateTimeFormat('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        }).format(new Date(dateString));
    }

    $(document).on('click', '.submit-comment', function () {
        const input = $(this).closest('.input-group').find('.comment-input-field');
        const commentText = input.val().trim();
        const taskId = $('.projectId').text().replace('#', '');

        if (!commentText) {
            alert('Please enter a comment.');
            return;
        }

        $.ajax({
            url: commentStoreRoute.replace(':id', taskId),
            type: 'POST',
            data: { comment: commentText, _token: window.AppRoutes.csrfToken },
            success: function (response) {
                if (response.status === 'success') {
                    const commentData = response.comment;
                    const commentElement = `
                    <div class="comment mb-3">
                        <div class="d-flex gap-2">
                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <strong>${commentData.user}</strong>
                                    <small class="text-muted">${new Date(commentData.created_at).toLocaleString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        timeZone: 'Asia/Karachi'
                    })}</small>
                                </div>
                                <p class="mb-0">${commentData.comment}</p>
                            </div>
                        </div>
                    </div>
                `;
                    $('#commentsContainer').append(commentElement); // Changed to append
                    input.val(''); // Clear input
                    $('#commentsContainer').scrollTop($('#commentsContainer')[0].scrollHeight); // Scroll to bottom
                }
            },
            error: function (xhr) {
                console.error('Error saving comment:', xhr.responseJSON);
                alert('Failed to add comment. Please try again.');
            }
        });
    });

    // Handle Enter key press
    $(document).on('keypress', '.comment-input-field', function (e) {
        if (e.key === 'Enter') {
            $(this).closest('.input-group').find('.submit-comment').click();
        }
    });
});
