@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/file_sync.css') }}">

    @include('pages.main', ['emails' => $emails])

    <div class="container" style="position: absolute; top: 165px; left: 60px; width: 95%;">
        <div class="row">
            <div class="col-12 col-md-12">

                <div class="row rounded mb-3"
                    style="display:flex; justify-content:space-between ;align-items-center; background-color:#F4F4F4;">
                    <div class="col-md-6">
                        <p class="filess pt-2 p-0 m-0">File Sync</p>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <form id="upload-form-top" enctype="multipart/form-data">
                            @csrf
                            <div class="dropdown py-2">
                                <button class="buttones dropdown-toggle d-flex align-items-center"
                                    style="padding: 5px 10px;font-size: 14px;" type="button" id="uploadDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-upload me-2"></i> Upload
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="uploadDropdown">
                                    <li><a class="dropdown-item" href="#" data-upload-type="file">Upload
                                            File</a></li>
                                    <li><a class="dropdown-item" href="#" data-upload-type="folder">Upload
                                            Folder</a></li>
                                </ul>
                            </div>

                            <!-- File Upload Section -->
                            <div id="file-upload" style="display: none;">
                                <input type="file" name="file" id="file" style="display: none;">
                            </div>

                            <!-- Folder Upload Section -->
                            <div id="folder-upload" style="display: none;">
                                <input type="file" id="files" name="files[]" webkitdirectory directory multiple
                                    style="display: none;">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 rounded" style="background-color: #0C5097; color:white">
                        <div class="row">
                            <a href="#" class="text-decoration-none text-dark">
                                <div class="col-12 p-2 border-bottom d-flex align-items-center p-0 m-0">
                                    <i class="fas fa-file-medical" style="color:white;"></i>
                                    <p class="ms-1 p-0 m-0"><a
                                            style="text-decoration: none; color: inherit; padding-left: 10px;"
                                            class="filter-type" href="#" data-type="all">All</a></p>
                                </div>
                            </a>
                            <a href="#" class="text-decoration-none text-dark">
                                <div class="col-12 p-2 border-bottom d-flex align-items-center p-0 m-0">
                                    <i class="fas fa-share-alt " style="color:white;"></i>
                                    <p class="ms-1 p-0 m-0"><a
                                            style="text-decoration: none; color: inherit; padding-left: 10px;"
                                            class="filter-type" href="#" data-type="shared">Shared</a></p>
                                </div>
                            </a>
                            <div class="col-12 position-relative">
                                <p class="mb-0 p-2 border-bottom" id="dropdownToggle" data-bs-toggle="dropdown"
                                    aria-expanded="false" style="cursor: pointer;">
                                    <i class="fas fa-filter" style="margin-left: -10px; margin-right: 8px;"></i> Filter type
                                </p>
                                <ul class="dropdown-menu" aria-labelledby="dropdownToggle"
                                    style="background-color: #F2F2F2; border: none;">
                                    <li><a class="dropdown-item filter-type" href="#" style="font-size:13px"
                                            data-type="pdf">PDF</a></li>
                                    <li><a class="dropdown-item filter-type" href="#" style="font-size:13px"
                                            data-type="word">Word</a></li>
                                    <li><a class="dropdown-item filter-type" href="#" style="font-size:13px"
                                            data-type="ppt">PowerPoint</a></li>
                                    <li><a class="dropdown-item filter-type" href="#" style="font-size:13px"
                                            data-type="xlsx">XLSX</a></li>
                                    <li><a class="dropdown-item filter-type" href="#" style="font-size:13px"
                                            data-type="zip">Zip</a></li>
                                    <li><a class="dropdown-item filter-type" href="#" style="font-size:13px"
                                            data-type="folder">Folder</a>
                                    </li>
                                    <li><a class="dropdown-item filter-type" href="#" style="font-size:13px"
                                            data-type="image">Others</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 px-2" style="column-gap: 10px">

                        {{-- Welcome Section --}}
                        <div class="row mb-4" id="welcome-section">
                            <div class="col-md-6 p-5" style="background-color:#F4F4F4; border-radius:0px 10px 10px 0px;">
                                <p class="twentyfourblack">Welcome to Filesync</p>
                                <p class="eighteenblack">File sync ensures all your devices have the latest files,
                                    promoting seamless collaboration and preventing version discrepancies.</p>
                                <form id="upload-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="dropdown">
                                        <button class="buttones dropdown-toggle d-flex align-items-center" type="button"
                                            id="uploadDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-upload me-2"></i> Upload
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="uploadDropdown">
                                            <li><a class="dropdown-item" href="#" data-upload-type="file">Upload
                                                    File</a></li>
                                            <li><a class="dropdown-item" href="#" data-upload-type="folder">Upload
                                                    Folder</a></li>
                                        </ul>
                                    </div>
                                    <input type="file" name="file" id="file" style="display: none;">
                                </form>
                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('images/filesync.png') }}" class="img-fluid" alt="...">
                            </div>
                        </div>

                        {{-- Uploaded Files Section --}}
                        <div class="row" id="filtered-content" style="column-gap: 10px"></div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">Share File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="shareFileForm">
                        <input type="hidden" id="fileId" name="file_id">
                        <label for="users">Select Users:</label>
                        <select id="users" name="user_ids[]" class="form-control" multiple>
                        </select>
                        <label for="teams">Select Teams:</label>
                        <select id="teams" name="team_ids[]" class="form-control" multiple>
                        </select>
                        <button type="submit" class="btn btn-primary" style="margin-top:5px">Share</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="folderModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="folderModalLabel">Folder Contents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="folderModalBody">
                    <!-- Files will be listed here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Rename Modal -->
    <div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renameModalLabel">Rename File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="renameForm">
                        <input type="hidden" id="renameFileId">
                        <div class="mb-3">
                            <label for="renameInput" class="form-label">Enter new file name (without extension)</label>
                            <input type="text" class="form-control" id="renameInput" required>
                            <div id="renameError" class="text-danger"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="renameConfirm">Rename</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this file? This action cannot be undone.</p>
                    <input type="hidden" id="deleteFileId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const uploadUrl = "{{ route('file-sync.store') }}";
        const downloadUrl = "/file-sync/download/"; // expects file id
        const renameUrl = "/files/rename/"; // expects file id
        const deleteUrl = "/file-sync/"; // expects file id for RESTful delete
        const shareUrl = "/share-file";
        const getUsersUrl = "/users";
        const getTeamsUrl = "/teams";
    </script>
    <script>
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
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

        document.getElementById('file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                uploadFile(file, 'file');
            }
        });

        document.getElementById('files').addEventListener('change', function(event) {
            const files = event.target.files;
            if (files.length > 0) {
                const firstFilePath = files[0].webkitRelativePath;
                const folderName = firstFilePath.split("/")[0];

                const formData = new FormData();
                formData.append('upload_type', 'folder');
                formData.append('folder_name', folderName);

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

                        // Hide the welcome section after successful upload
                        const welcomeSection = document.getElementById('welcome-section');
                        if (welcomeSection) welcomeSection.style.display = 'none';

                        if (data.file) {
                            const file = data.file;
                            const fileCard = `
<div class="col-md-2 col-sm-3 col-4 mb-3">
    <div class="file-card border rounded p-2 shadow-sm h-100 d-flex flex-column align-items-center justify-content-between"
        data-path="${file.path}"
        data-type="${file.type}"
        id="file-${file.id}"
        ondblclick="handleDoubleClick('${file.path}', '${file.type}')"
        style="background-color: #fff; position: relative;">

        <img src="${file.image_path}" class="img-fluid mb-2"
            alt="${file.name}"
            style="width: 100%; height: 100px; object-fit: cover; border-radius: 10px;">

        <p class="text-center text-truncate mb-1" title="${file.name}" style="font-size: 13px; width: 100%;">
            ${file.name}
        </p>
        <div class="dropdown position-absolute" style="top: 5px; right: 10px;">
            <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                <svg width="14" height="4" viewBox="0 0 20 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="2" cy="2" r="2" fill="black"></circle>
                    <circle cx="10" cy="2" r="2" fill="black"></circle>
                    <circle cx="18" cy="2" r="2" fill="black"></circle>
                </svg>
            </div>
            <div class="dropdown-menu">
                <button class="dropdown-item file" data-path="${file.path}" data-type="${file.type}">
                    <i class="fas fa-folder-open me-1"></i> ${file.type === 'folder' ? 'Open Folder' : 'Open'}
                </button>
                <button class="dropdown-item" onclick="renameFile('${file.id}')">
                    <i class="fas fa-edit me-1"></i> Rename
                </button>
                <button class="dropdown-item" onclick="downloadFile('${file.path}', '${file.type}')">
                    <i class="fas fa-download me-1"></i> Download
                </button>
                <button class="dropdown-item" onclick="openShareModal('${file.id}', '${file.path}')">
                    <i class="fas fa-share me-1"></i> Share
                </button>
                <button class="dropdown-item delete-file" data-id="${file.id}">
                    <i class="fas fa-trash-alt me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>`;

                            const filteredContent = document.getElementById('filtered-content');
                            filteredContent.insertAdjacentHTML('beforeend', fileCard);

                            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(element => {
                                new bootstrap.Dropdown(element);
                            });
                        }
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

        document.querySelectorAll('.filter-type').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                document.querySelector('#upload-form-top').classList.remove('d-none');
                const filterType = this.getAttribute('data-type');

                fetch('/filter', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            type: filterType
                        })
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
                                    <button class="dropdown-item file" data-path="${file.path}" data-type="${file.type}"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-folder-open" style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>${file.type === 'folder' ? 'Double-click the folder' : 'Open'}</span>
                                    </button>
                                    <button class="dropdown-item" onclick="renameFile('${file.id}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-edit" style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Rename</span>
                                    </button>
                                    <button class="dropdown-item" onclick="downloadFile('${file.path}', '${file.type}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-download" style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Download</span>
                                    </button>
                                    <button class="dropdown-item" onclick="openShareModal('${file.id}', '${file.path}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-share" style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Share</span>
                                    </button>
                                    <button class="dropdown-item delete-file" data-id="${file.id}"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-trash-alt" style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                        });

                        filteredContent.innerHTML = content;

                        document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(element => {
                            new bootstrap.Dropdown(element);
                        });

                        document.querySelectorAll(".file").forEach(button => {
                            const fileType = button.getAttribute("data-type");
                            if (fileType === "folder") {
                                button.removeAttribute("onclick");
                            } else {
                                button.setAttribute("onclick",
                                    `openFile('${button.getAttribute("data-path")}')`);
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
                                    <button class="dropdown-item" onclick="openFile('${file.path}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-folder-open" style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Open</span>
                                    </button>
                                    <button class="dropdown-item" onclick="renameFile('${file.id}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-edit" style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Rename</span>
                                    </button>
                                    <button class="dropdown-item" onclick="downloadFile('${file.path}', '${file.type}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-download" style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Download</span>
                                    </button>
                                    <button class="dropdown-item" onclick="openShareModal('${file.id}')"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-share" style="font-size: 12px; margin-right: 5px;"></i>
                                        <span>Share</span>
                                    </button>
                                    <button class="dropdown-item delete-file" data-id="${file.id}"
                                        style="cursor: pointer; font-size:12px; padding: 5px; display: flex; align-items: center;">
                                        <i class="fas fa-trash-alt" style="font-size: 12px; margin-right: 5px;"></i>
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

        function downloadFile(filePath, fileType) {
            let fileId = null;
            document.querySelectorAll('.file-card').forEach(card => {
                if (card.getAttribute('data-path') === filePath) {
                    fileId = card.id.replace('file-', '');
                }
            });
            if (!fileId) {
                Swal.fire('Error', 'File ID not found for download.', 'error');
                return;
            }

            window.location.href = downloadUrl + fileId;
            document.getElementById('pageLoader').style.display = 'none';
        }

        function renameFile(fileId) {
            console.log('Renaming file with ID:', fileId); // Debug

            // Set the file ID and clear previous input
            document.getElementById('renameFileId').value = fileId;
            document.getElementById('renameInput').value = ''; // Clear previous input
            document.getElementById('renameError').textContent = ''; // Clear error message

            // Show the rename modal
            const renameModal = new bootstrap.Modal(document.getElementById('renameModal'));
            renameModal.show();

            // Handle rename confirmation
            document.getElementById('renameConfirm').onclick = function() {
                const newName = document.getElementById('renameInput').value.trim();
                if (!newName) {
                    document.getElementById('renameError').textContent = 'Name cannot be empty';
                    return;
                }

                fetch(renameUrl + fileId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            new_name: newName
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            renameModal.hide();
                            alert('Renamed! ' + data.message); // Simple alert as feedback
                            // Update the file name in the UI
                            const fileCard = document.getElementById(`file-${fileId}`);
                            if (fileCard) {
                                fileCard.querySelector('p').textContent = newName;
                            }
                        } else {
                            document.getElementById('renameError').textContent = data.message || 'Rename failed';
                        }
                    })
                    .catch(error => {
                        document.getElementById('renameError').textContent = 'Failed to rename file';
                        console.error('Rename error:', error);
                    });
            };
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-file')) {
                const fileId = e.target.getAttribute('data-id');
                console.log('Delete triggered for file ID:', fileId); // Debug

                // Set the file ID and show the delete modal
                document.getElementById('deleteFileId').value = fileId;
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();

                // Handle delete confirmation
                document.getElementById('confirmDelete').onclick = function() {
                    fetch(`${deleteUrl}${fileId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                deleteModal.hide();
                                alert('Deleted! ' + data.message); // Simple alert as feedback
                                // Remove the file card from the UI
                                const card = document.getElementById('file-' + fileId);
                                if (card) card.remove();
                            } else {
                                alert('Error: ' + (data.message || 'Failed to delete file'));
                            }
                        })
                        .catch(error => {
                            alert('Error: Failed to delete file');
                            console.error('Delete error:', error);
                        });
                };
            }
        });

        function openShareModal(fileId, filePath) {
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('shareModal'));
            document.getElementById('fileId').value = fileId;
            // Fetch users and teams
            fetch(getUsersUrl)
                .then(res => res.json())
                .then(users => {
                    const usersSelect = document.getElementById('users');
                    usersSelect.innerHTML = '';
                    users.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.id;
                        option.textContent = user.name + ' (' + user.email + ')';
                        usersSelect.appendChild(option);
                    });
                });
            fetch(getTeamsUrl)
                .then(res => res.json())
                .then(teams => {
                    const teamsSelect = document.getElementById('teams');
                    teamsSelect.innerHTML = '';
                    teams.forEach(team => {
                        const option = document.createElement('option');
                        option.value = team.id;
                        option.textContent = team.team_name;
                        teamsSelect.appendChild(option);
                    });
                });
            modal.show();
        }

        document.getElementById('shareFileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(shareUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Shared!', data.message, 'success');
                        bootstrap.Modal.getInstance(document.getElementById('shareModal')).hide();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                });
        });
    </script>
    <!--<script src="{{ asset('js/dashboard.js') }}"></script>-->
@endpush
