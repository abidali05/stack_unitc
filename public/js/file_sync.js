document.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', function (event) {
        const uploadType = event.target.getAttribute('data-upload-type');
        if (uploadType === 'file') {
            document.getElementById('file-upload').style.display = 'block';
            document.getElementById('folder-upload').style.display = 'none';
            document.getElementById('file').click();
        } else if (uploadType === 'folder') {
            document.getElementById('file-upload').style.display = 'none';
            document.getElementById('folder-upload').style.display = 'block';
            document.getElementById('files').click();
        }
    });
});

document.getElementById('file').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        uploadFile(file, 'file');
    }
});

document.getElementById('files').addEventListener('change', function (event) {
    const files = event.target.files;
    if (files.length > 0) {
        const firstFilePath = files[0].webkitRelativePath; // Get full path of first file
        const folderName = firstFilePath.split("/")[0]; // Extract folder name

        const formData = new FormData();
        formData.append('upload_type', 'folder');
        formData.append('folder_name', folderName); // ✅ Send folder name

        Array.from(files).forEach(file => {
            formData.append('files[]', file);
        });

        uploadFolder(formData);
    }
});

function uploadFile(file, type) {
    const formData = new FormData();
    formData.append('upload_type', type);
    formData.append('file', file);

    sendRequest(formData);
}

function uploadFolder(formData) {
    sendRequest(formData);
}

function sendRequest(formData) {
    fetch(uploadUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Data uploaded successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an issue uploading the data.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'There was an issue uploading the file/folder.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
}

//filter files
document.querySelectorAll('.filter-type').forEach(item => {
    item.addEventListener('click', function (event) {
        event.preventDefault();
        document.querySelector('#upload-form-top').classList.remove('d-none');
        const filterType = this.getAttribute('data-type');
        
        
        fetch('/filter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ type: filterType })
        })
            .then(response => response.json())
            .then(data => {
                const filteredContent = document.getElementById('filtered-content');

                if (data.message) {
                    filteredContent.innerHTML = `<p>${data.message}</p>`;
                    return;
                }

                const files = Array.isArray(data) ? data : Object.values(data);

                if (files.length === 0) {
                    filteredContent.innerHTML = '<p>No files found.</p>';
                    return;
                }

                let content = '';
                files.forEach(file => {
                    content += `
                    <div class="col-md-2 mb-2">
                        <div class="file-card p-2 border position-relative file-item"
                            data-path="${file.path}"
                            data-type="${file.type}"
                            id="file-${file.id}"
                            ondblclick="handleDoubleClick('${file.path}', '${file.type}')">
                            <img src="${file.image_path}" class="img-fluid" alt="${file.name}"
                                style="width:60px; height:60px; object-fit:cover; border-radius: 10px">
                            <p class="mt-1 mb-0" style="font-size:12px">${file.name}</p>

                            <div class="dropdown position-absolute" style="top:5px; right:10px;">
                                <div class="dropdown-toggle" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg width="14" height="4" viewBox="0 0 20 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="2" cy="2" r="2" fill="black"></circle>
                                        <circle cx="10" cy="2" r="2" fill="black"></circle>
                                        <circle cx="18" cy="2" r="2" fill="black"></circle>
                                    </svg>
                                </div>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item file"
                                        data-path="${file.path}"
                                        data-type="${file.type}"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-folder-open"
                                            style="font-size: 12px; margin-right: 5px;"></i>
                                            <span>${file.type === 'folder' ? 'Double-click the folder' : 'Open'}</span>
                                    </button>
                                    <button class="dropdown-item" onclick="renameFile('${file.id}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-edit"
                                            style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Rename</span>
                                    </button>
                                    <button class="dropdown-item"
                                        onclick="downloadFile('${file.path}','${file.type}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-download"
                                            style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Download</span>
                                    </button>
                                    <button class="dropdown-item"
                                        onclick="openShareModal('${file.id}', '${file.path}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-share"
                                            style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Share</span>
                                    </button>
                                    <button class="dropdown-item delete-file" data-id="${file.id}"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-trash-alt"
                                            style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                });

                filteredContent.innerHTML = content;

                // Reinitialize Bootstrap dropdowns
                document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(element => {
                    new bootstrap.Dropdown(element);
                });

                // Remove "onclick" for folders after filtering
                document.querySelectorAll(".file").forEach(button => {
                    const fileType = button.getAttribute("data-type");
                    if (fileType === "folder") {
                        button.removeAttribute("onclick");
                    } else {
                        button.setAttribute("onclick", `openFile('${button.getAttribute("data-path")}')`);
                    }
                });

            })
            .catch(error => console.error('Error:', error));
    });
});

function handleDoubleClick(folderPath, type) {
    if (type !== 'folder') return;

    fetch(`/get-folder-content/${encodeURIComponent(folderPath)}`)
        .then(response => response.json())
        .then(data => {
            const modalBody = document.getElementById('folderModalBody');
            let content = '';

            if (data.length === 0) {
                content = '<p>No files found in this folder.</p>';
            } else {
                data.forEach(file => {
                    content += `
                    <div class="col-md-2 mb-2">
                        <div class="file-card p-2 border position-relative" id="file-${file.id}">
                            <!-- File Thumbnail -->
                            <img src="${file.image_path}" class="img-fluid" alt="${file.name}"
                                style="width:60px; height:60px; object-fit:cover; border-radius: 10px">
                            <p class="mt-1 mb-0" style="font-size:12px">${file.name}</p>

                            <div class="dropdown position-absolute" style="top:5px; right:10px;">
                                <div class="dropdown-toggle" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg width="14" height="4" viewBox="0 0 20 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="2" cy="2" r="2" fill="black"></circle>
                                        <circle cx="10" cy="2" r="2" fill="black"></circle>
                                        <circle cx="18" cy="2" r="2" fill="black"></circle>
                                    </svg>
                                </div>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item"
                                        onclick="openFile('${file.path}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-folder-open"
                                            style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Open</span>
                                    </button>
                                    <button class="dropdown-item" onclick="renameFile('${file.id}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-edit"
                                            style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Rename</span>
                                    </button>
                                    <button class="dropdown-item"
                                        onclick="downloadFile('${file.path}','${file.type}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-download"
                                            style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Download</span>
                                    </button>
                                    <button class="dropdown-item"
                                        onclick="openShareModal('${file.id}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-share"
                                            style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Share</span>
                                    </button>
                                    <button class="dropdown-item delete-file" data-id="${file.id}"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-trash-alt"
                                            style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                });
            }

            modalBody.innerHTML = `<div class="row">${content}</div>`;

            const folderModal = new bootstrap.Modal(document.getElementById('folderModal'));
            folderModal.show();
        })
        .catch(error => console.error('Error loading folder contents:', error));
}




