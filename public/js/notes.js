
//Image div
const fileInput = document.getElementById('fileInput');
const imagePreview = document.getElementById('imagePreview');

fileInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (event) {
            imagePreview.style.backgroundImage = `url(${event.target.result})`;
            imagePreview.style.border = 'none';
        };

        reader.readAsDataURL(file);
    }
});
///////

// Delete Button
document.addEventListener('click', function (e) {
    if (e.target.closest('.delete-icon')) {
        const noteId = e.target.closest('.delete-icon').getAttribute('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/note/${noteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', data.message, 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Something went wrong!', 'error');
                    });
            }
        });
    }
});
/////

// View Notes modal
document.addEventListener('click', function (e) {
    if (e.target.closest('.view-icon')) {
        const noteTitle = e.target.closest('.view-icon').getAttribute('data-title');
        const noteDescription = e.target.closest('.view-icon').getAttribute('data-description');

        document.getElementById('noteTitle').textContent = noteTitle;
        document.getElementById('noteDescription').innerHTML = noteDescription;
    }
});
//////

//Edit Notes Modal
document.addEventListener('click', function (e) {
    if (e.target.closest('.edit-icon')) {
        const editIcon = e.target.closest('.edit-icon');
        const noteId = editIcon.getAttribute('data-id');
        const noteTitle = editIcon.getAttribute('data-title');
        const noteDescription = editIcon.getAttribute('data-description');

        document.getElementById('noteId').value = noteId;
        document.getElementById('noteTitleInput').value = noteTitle;
        document.getElementById('noteDescriptionInput').value = noteDescription;

        const form = document.getElementById('editNoteForm');
        form.action = `/note/${noteId}`;
    }
});
///////

//filter
document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#calendar", {
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            const date = dateStr;
            filterNotesByDate(date);
        }
    });
});

function filterNotesByDate(date) {
    fetch(`/filter-notes?date=${date}`)
        .then(response => response.json())
        .then(data => {
            updateNotesContainer(data.notes);
        })
        .catch(error => console.error('Error filtering notes:', error));
}

function updateNotesContainer(notes) {
    const notesContainer = document.getElementById('notesContainer');
    notesContainer.innerHTML = '';

    if (notes.length === 0) {
        notesContainer.innerHTML = '<p class="text-center">No notes available for this month!</p>';
    } else {
        notes.forEach(note => {
            notesContainer.innerHTML += `
                <div class="col-lg-3 col-md-3 position-relative">
                    <div class="notes-container">
                        <div style="display: flex; width: 100%;">
                            <div>
                                <img class="img-fluid" src="${note.image || 'images/default-notes.png'}"
                                    style="width: 60px; height: 60px; border-radius: 100px;" alt="Note Image">
                            </div>
                            <div style="padding-top: 10px; padding-left: 5px;">
                                <p style="font-size: 12px;color: #707070; margin-bottom: 0px;">
                                    By: ${note.user.name}
                                </p>
                            </div>
                        </div>
                        <div class="editor-data1" style="width:100%">${note.description.substring(0, 50)}</div>
                        <div style="width: 100%;">
                            <p style="float: right; margin-bottom: 0px; font-weight: 500; font-size: 10px;">
                                ${new Date(note.created_at).toLocaleString('en-GB', {
                                    weekday: 'short',
                                    year: '2-digit',
                                    month: 'short',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}
                            </p>
                        </div>
                        <div class="overlay">
                            <div class="icon-container">
                                <a href="#" class="view-icon" title="View" data-bs-toggle="modal"
                                    data-bs-target="#viewModal"
                                    data-id="${note.id}"
                                    data-title="${note.title}"
                                    data-description="${note.description}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="edit-icon" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    data-id="${note.id}"
                                    data-title="${note.title}"
                                    data-description="${note.description}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)" class="delete-icon" title="Delete"
                                    data-id="${note.id}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    }
}

