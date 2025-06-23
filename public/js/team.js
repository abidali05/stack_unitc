// Delete Button
document.addEventListener('click', function (e) {
    if (e.target.closest('.delete-icon')) {
        const teamId = e.target.closest('.delete-icon').getAttribute('data-id');

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
                fetch(`/team/${teamId}`, {
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

// Detail Team modal
document.addEventListener('click', function (e) {
    if (e.target.closest('.view-icon')) {
        const teamTitle = e.target.closest('.view-icon').getAttribute('data-title');
        const teamDescription = e.target.closest('.view-icon').getAttribute('data-description');
        const teamUsers = e.target.closest('.view-icon').getAttribute('data-users');

        document.getElementById('teamTitle').textContent = teamTitle;
        document.getElementById('teamDescription').innerHTML = teamDescription;
        document.getElementById('teamUsers').textContent = teamUsers;
    }
});

//Edit Team modal
document.addEventListener('click', function (e) {
    if (e.target.closest('.edit-icon')) {
        const teamId = e.target.closest('.edit-icon').getAttribute('data-id');
        const teamTitle = e.target.closest('.edit-icon').getAttribute('data-team_name');
        const teamDescription = e.target.closest('.edit-icon').getAttribute('data-team_description');
        const assignedUsers = JSON.parse(e.target.closest('.edit-icon').getAttribute('data-users'));
        const allUsers = JSON.parse(e.target.closest('.edit-icon').getAttribute('data-all-users'));

        document.getElementById('teamId').value = teamId;
        document.getElementById('teamTitleInput').value = teamTitle;
        document.getElementById('teamDescriptionInput').value = teamDescription;

        const formAction = document.getElementById('editTeamForm').getAttribute('action').replace('__id__', teamId);
        document.getElementById('editTeamForm').setAttribute('action', formAction);

        const usersSelect = document.getElementById('teamUsersInput');
        usersSelect.innerHTML = '';

        allUsers.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name;

            if (assignedUsers.includes(user.id)) {
                option.selected = true;
            }

            usersSelect.appendChild(option);
        });
    }
});

