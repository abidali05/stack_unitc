
function hideDiv() {
    var toggleDiv = document.getElementById('toggleDiv');
    var sendContent = document.getElementById('sendContent');

    toggleDiv.style.display = 'none';
    sendContent.style.display = 'block';
}

ClassicEditor
    .create(document.querySelector('#editor'))
    .then(editor => {
        window.editorInstance = editor;
    })
    .catch(error => {
        console.log(error);
    });


document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.star-email').forEach(button => {
        button.addEventListener('click', function () {
            const emailId = this.dataset.id;
            const isStarred = this.dataset.starred === 'true';
            toggleStarEmail(emailId, isStarred);
        });
    });

    document.querySelectorAll('.email-item').forEach(emailDiv => {
        emailDiv.addEventListener('click', function (event) {
            if (event.target.classList.contains('star-email') ||
                event.target.classList.contains('delete-email') || emailDiv.classList.contains('draft')) return;
            const emailId = this.dataset.id;
            markAsReadAndFetch(emailId);
        });
    });

    document.querySelectorAll('.delete-email').forEach(button => {
        button.addEventListener('click', function () {
            const emailId = this.dataset.id;
            deleteEmail(emailId);
        });
    });
});

function toggleStarEmail(emailId, isStarred) {
    fetch(`/emails/star/${emailId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email_id: emailId, is_starred: !isStarred })
    }).then(response => response.json()).then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: `Email ${isStarred ? 'unstarred' : 'starred'} successfully.`,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => location.reload());
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'There was an issue updating the email star status.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

function markAsReadAndFetch(emailId) {
    console.log('4');
    fetch(`/emails/mark-read/${emailId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email_id: emailId })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const emailItem = document.querySelector(`.email-item[data-id='${emailId}']`);
                if (emailItem) emailItem.classList.add('read-email');

                var toggleDiv = document.getElementById('toggleDiv');
                var sendContent = document.getElementById('sendContent');

                // sendContent.style.display = 'none';
                // toggleDiv.style.display = 'block';

                if (toggleDiv && sendContent) {
                    toggleDiv.innerHTML = `
                        <div id="email-details" style="width: auto; padding: 20px; border-radius: 10px; background: #F2F2F2;">

                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #dcdcdc; padding-bottom: 10px; margin-bottom: 15px;">
                                <h2 style="margin: 0; font-size: 20px; text-transform: capitalize; font-weight: bold; color: #333;">
                                    ${data.email.subject}
                                </h2>
                                <p style="margin: 0; font-size: 12px; color: #707070;">
                                    ${data.email.date}
                                </p>
                            </div>

                            <div style="margin-bottom: 20px;">
                                <p style="margin: 0; font-weight: bold; font-size: 14px; color: #333;">
                                    ${data.email.sender['name']}
                                </p>
                                <p style="margin: 2px 0; font-size: 12px; color: #707070;">
                                    ${data.email.sender['email']}
                                </p>
                            </div>

                            <div style="font-size: 14px; line-height: 1.6; color: #444;">
                                ${data.email.content}
                            </div>
                        </div>
                    `;

                    sendContent.style.display = 'none';
                    toggleDiv.style.display = 'block';
                }
            } else {
                Swal.fire('Error!', 'Failed to mark email as read.', 'error');
            }
        })
        .catch(error => console.log('Error:', error));
}

// Draft Functionality
let draftTimer = false;
let emailValid = false;

function saveAsDraft() {
    const formData = new FormData(document.getElementById('emailForm'));
    const emailBodyContent = window.editorInstance.getData();
    formData.append('body', emailBodyContent);

    fetch('/emails/toggle-draft', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("draft_id").value = data.draft_id;
                if (data.is_draft && !emailValid) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'info',
                        title: 'Saved as draft (invalid email)',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            } else {
                Swal.fire('Error!', 'Failed to update draft status.', 'error');
            }
        })
        .catch(error => console.log('Error:', error));
}
["input", "change"].forEach(event => {
    document.getElementById('emailForm').addEventListener(event, function () {
        if (draftTimer) clearTimeout(draftTimer);
        draftTimer = setTimeout(() => {
            saveAsDraft();
        }, 3000);
    });
});

// Fetching Draft value and show in form
document.addEventListener("DOMContentLoaded", function () {
    const emailItems = document.querySelectorAll('.email-item');
    emailItems.forEach(item => {
        item.addEventListener('click', function () {
            const draftId = item.getAttribute('data-id');

            hideDiv();

            const emailTo = item.getAttribute('data-to');
            const emailSubject = item.getAttribute('data-subject');
            const emailBody = item.getAttribute('data-body');

            document.getElementById('email').value = emailTo;
            document.getElementById('subject').value = emailSubject;

            if (window.editorInstance) {
                window.editorInstance.setData(emailBody);
            }

            document.getElementById('draft_id').value = draftId;
        });
    });
});

function deleteEmail(emailId) {
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
            fetch(`/emails/delete/${emailId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email_id: emailId })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    Swal.fire(
                        'Deleted!',
                        'Your email has been deleted.',
                        'success'
                    ).then(() => location.reload());
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue deleting the email.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
}

<script>
function submitCreateFolder() {
    const folderName = document.getElementById('folderNameInput').value.trim();

    if (!folderName) {
        alert("Folder name cannot be empty!");
        return;
    }

    fetch(folderStoreRoute, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: folderName }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const folderContainer = document.getElementById('foldersContainer');
            const newFolder = document.createElement('div');
            newFolder.className = 'folder';
            newFolder.setAttribute('data-id', data.folder.id);
            newFolder.setAttribute('draggable', 'true');
            newFolder.setAttribute('ondragover', 'event.preventDefault()');
            newFolder.setAttribute('ondrop', `handleFolderDrop(event, ${data.folder.id})`);
            newFolder.style = `
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #f8f9fa;
                cursor: pointer;
            `;

            const folderNameSpan = document.createElement('span');
            folderNameSpan.textContent = data.folder.name;

            const deleteIcon = document.createElement('span');
            deleteIcon.innerHTML = '&#10006;';
            deleteIcon.style = `
                color: red;
                margin-left: 10px;
                cursor: pointer;
            `;
            deleteIcon.title = 'Delete folder';
            deleteIcon.addEventListener('click', (event) => {
                event.stopPropagation();
                deleteFolder(data.folder.id, newFolder);
            });

            newFolder.appendChild(folderNameSpan);
            newFolder.appendChild(deleteIcon);
            folderContainer.appendChild(newFolder);

            // Close modal and clear input
            const modal = bootstrap.Modal.getInstance(document.getElementById('createFolderModal'));
            modal.hide();
            document.getElementById('folderNameInput').value = '';

            location.reload();
        } else {
            alert('An error occurred while creating the folder.');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

let draggedEmailId = null;

function handleDragStart(event, emailId) {
    draggedEmailId = emailId;
    event.dataTransfer.setData('text/plain', emailId);
    event.dataTransfer.effectAllowed = 'move';
}

function handleFolderDrop(event, folderId) {
    event.preventDefault();
    const emailId = draggedEmailId;

    if (emailId) {
        console.log(`Dropping email ${emailId} into folder ${folderId}`);

        fetch(`/emails/${emailId}/move`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ folder_id: folderId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Email moved successfully.');
                    location.reload();
                } else {
                    alert('Failed to move email.');
                }
            })
            .catch(error => {
                console.error('Error moving email:', error);
            });
    }
}

function loadFolderEmails(folderId) {
    const folderContainer = document.querySelector(`.folder-container[data-id="${folderId}"]`);
    const emailsContainer = folderContainer.querySelector('.emails-container');

    // Toggle visibility
    if (emailsContainer.style.display === 'block') {
        emailsContainer.style.display = 'none';
        emailsContainer.innerHTML = ''; // Optional: Clear contents
        return;
    }

    // Hide other open folders
    const allEmailContainers = document.querySelectorAll('.emails-container');
    allEmailContainers.forEach(container => {
        container.style.display = 'none';
        container.innerHTML = ''; // Optional: Clear contents
    });

    // Fetch and display emails for the selected folder
    fetch(`/emails/folder/${folderId}`)
        .then(response => response.json())
        .then(data => {
            emailsContainer.style.display = 'block';
            if (data.emails.length > 0) {
                data.emails.forEach(email => {
                    const emailItem = document.createElement('li');
                    emailItem.textContent = email.subject;
                    emailItem.style = `
                        margin-left: -30px;
                        width: max-content;
                        cursor: pointer;
                        list-style: none;
                        font-size: 12px;
                        margin-bottom: 5px;
                    `;
                    emailItem.onclick = () => openEmailModal(email.id);
                    emailsContainer.appendChild(emailItem);
                });
            } else {
                emailsContainer.innerHTML = '<li style="font-size: 12px; list-style: none; margin-bottom:0px; margin-left:-30px">No emails</li>';
            }
        })
        .catch(error => {
            console.error('Error fetching folder emails:', error);
            alert('Failed to load folder records.');
        });
}

// Open modal and fetch email details
function openEmailModal(emailId) {
    fetch(`/emails/${emailId}`)
        .then(response => response.json())
        .then(email => {
            // console.log(email);
            document.getElementById('emailSender').textContent = email.sender.email;
            document.getElementById('emailSubject').textContent = email.subject;
            document.getElementById('emailBody').innerHTML = email.description;

            const modal = document.getElementById('emailModal');
            modal.style.display = 'block';
            document.getElementById('backdrop-outlook').style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching email details:', error);
            alert('Failed to load email details.');
        });
}

// Close modal
document.getElementById('closeModal').onclick = () => {
    document.getElementById('emailModal').style.display = 'none';
    document.getElementById('backdrop-outlook').style.display = 'none';

};

// Close modal when clicking outside the content
window.onclick = function (event) {
    const modal = document.getElementById('emailModal');
    if (event.target === modal) {
        modal.style.display = 'none';
        document.getElementById('backdrop-outlook').style.display = 'none';
    }
};

function deleteFolder(folderId, folderElement) {
    if (!confirm("Are you sure you want to delete this folder?")) return;

    const url = folderDeleteRoute.replace(':id', folderId);

    // Send AJAX request to delete the folder
    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove folder from the DOM
                folderElement.remove();
                location.reload();
            } else {
                alert('An error occurred while deleting the folder.');
            }
        })
        .catch(error => console.error('Error:', error));
}

function toggleFolders() {
    const foldersContainer = document.getElementById('foldersContainer');
    foldersContainer.style.display =
    foldersContainer.style.display === 'none' ? 'block' : 'none';
}


const sendButton = document.getElementById('sendBtn');

document.getElementById('email').addEventListener('input', function () {
    const email = this.value.trim();

    // Optional: only validate after user has typed something
    if (!email || !email.includes('@')) {
        emailValid = false;
        sendButton.disabled = true;
        return;
    }

    // Call backend to check if email exists
    fetch(`/check-email?email=${encodeURIComponent(email)}`)
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                emailValid = true;
                sendButton.disabled = false;
            } else {
                emailValid = false;
                sendButton.disabled = true;

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: 'This email is not registered!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                });
            }
        });
});
