@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/email.css') }}">

    @include('pages.main', ['emails' => $emails])

    <div class="container" id="email-content" style="position: absolute; top: 190px; left: 85px;">
        <div class="row">
                   <div class="col-lg-1 col-md-1 "  style="background-color:#F4F4F4 ;border-radius:10px 0px 0px 10px"">
                <div style="display: flex; flex-direction: column; padding-left: 5px; gap: 7px;">
              
                    <div class="mt-3">
                        <a href="{{ route('email.index', 'inbox') }}"
                            class="{{ request()->is('email/inbox') ? 'active' : '' }} link-item">
                            <p>Inbox</p>
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('email.index', 'unread') }}"
                            class="{{ request()->is('email/unread') ? 'active' : '' }} link-item">
                            <p>Unread</p>
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('email.index', 'starred') }}"
                            class="{{ request()->is('email/starred') ? 'active' : '' }} link-item">
                            <p>Starred</p>
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('email.index', 'sent') }}"
                            class="{{ request()->is('email/sent') ? 'active' : '' }} link-item">
                            <p>Sent</p>
                        </a>
                    </div>
                    <a href="{{ route('email.index', 'draft') }}"
                        class="{{ request()->is('email/draft') ? 'active' : '' }} link-item">
                        <p>Draft</p>
                    </a>
                    <!-- <div>
                                                        <p>Junk</p>
                                                    </div>
                                                    <div>
                                                        <p>Outbox</p>
                                                    </div> -->
                    <a href="{{ route('email.index', 'trash') }}"
                        class="{{ request()->is('email/trash') ? 'active' : '' }} link-item">
                        <p>Trash</p>
                    </a>
                       <div class="folder static-folder" onclick="toggleFolders()"
                    style="
                            position: relative;
                            padding: 5px;
                            border: 1px solid #ddd;
                            border-radius: 5px;
                            background-color: #e7e9eb;
                            margin-bottom: 10px;
                            cursor: pointer;">
                    <span style="font-size: 12px; font-weight: bold;">Folders</span>
                    <span style="position: absolute; right: 3px;    top: 10px; font-size: 12px; cursor: pointer;">&#9660;</span>
                </div>

                <div id="foldersContainer" class="folders-container" style="display: none;">
                    @foreach ($folders as $folder)
                        <div class="folder-container" style="margin-bottom: 5px" data-id="{{ $folder->id }}">
                            <div class="folder" draggable="true" ondragover="event.preventDefault()"
                                ondrop="handleFolderDrop(event, {{ $folder->id }})"
                                onclick="loadFolderEmails({{ $folder->id }})"
                                style="
                                    position: relative;
                                    padding: 5px;
                                    border: 1px solid #ddd;
                                    border-radius: 5px;
                                    background-color: #f8f9fa;
                                    cursor: pointer;">
                                <span style="font-size: 12px">{{ $folder->name }}</span>
                                <span
                                    style="position:absolute; top:12px; right:5px; color: red; cursor: pointer; font-size:8px"
                                    title="Delete folder"
                                    onclick="deleteFolder({{ $folder->id }}, this.closest('.folder')); event.stopPropagation();">
                                    &#10006;
                                </span>
                            </div>
                            <!-- Emails will load below this folder -->
                            <ul class="emails-container" style="margin-left: 20px; padding-left: 10px; display:none;"></ul>
                        </div>
                    @endforeach
                </div>

                <div id="backdrop-outlook"
                    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
                </div>

                <div id="emailModal" class="modal"
                    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1100; backdrop-filter: blur(5px);">
                    <div class="modal-content"
                        style="
                        background-color: white;
                        border-radius: 12px;
                        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
                        width: 90%;
                        max-width: 600px;
                        margin: 5% auto;
                        position: relative;
                        padding: 2rem;
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                    ">
                        <span id="closeModal"
                            style="
                            position: absolute;
                            top: 1.5rem;
                            right: 1.5rem;
                            font-size: 1.5rem;
                            color: #666;
                            cursor: pointer;
                            width: 32px;
                            height: 32px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border-radius: 50%;
                            transition: background-color 0.2s;
                            &:hover {
                                background-color: #f5f5f5;
                            }
                        ">&times;</span>

                        <h2 id="emailSubject"
                            style="
                            margin: 0 0 1.5rem 0;
                            color: #1a1a1a;
                            font-size: 1.5rem;
                            font-weight: 600;
                            padding-right: 2rem;
                        ">
                            Email Subject</h2>

                        <div
                            style="
                            padding: 1rem;
                            background-color: #f8f9fa;
                            border-radius: 8px;
                            margin-bottom: 1.5rem;
                        ">
                            <p
                                style="
                                margin: 0 0 0.5rem 0;
                                color: #666;
                                font-size: 0.9rem;
                            ">
                                <strong>From:</strong> <span id="emailSender" style="color: #2c5282;">Sender Email</span>
                            </p>
                        </div>

                        <div
                            style="
                            background-color: white;
                            border: 1px solid #e2e8f0;
                            border-radius: 8px;
                            padding: 1.5rem;
                        ">
                            <p
                                style="
                                margin: 0;
                                line-height: 1.6;
                                color: #4a5568;
                            ">
                                <span id="emailBody">Email Body</span></p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
         
     
            <div class="col-lg-5 col-md-5" style="    background-color:#F4F4F4 !important;    box-shadow: var(--bs-box-shadow-sm) !important;border-radius:0px 10px 10px 0px">
                <div style="display: flex; align-items: center; flex-direction: column; " class="mt-3">
        
                    <!-- Create Folder Button -->
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFolderModal"
    style="width: 100%; margin-bottom: 10px; color:#0C5097 !important; border:1px solid #0C5097 !important ; background:white !important">
    Create Folder
</button>

<!-- Create Folder Modal -->
<div class="modal fade" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="border:none">
        <h5 class="modal-title" id="createFolderModalLabel">Create New Folder</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="border:none">
        <input type="text" id="folderNameInput" class="form-control" placeholder="Enter folder name">
      </div>
      <div class="modal-footer" style="border:none">
        <button type="button" class="btn btn-secondary" style="color:#0C5097 !important; border:1px solid #0C5097 !important ; background:white !important" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" style="color:white !important; border:1px solid #0C5097 !important ; background-color:#0C5097 !important" onclick="submitCreateFolder()">Save</button>
      </div>
    </div>
  </div>
</div>

                    <div class="clickable-div" id="clickDiv" onclick="hideDiv()">
                        <p>New Email</p>
                    </div>
                    @forelse ($emails as $email)
                        <div style="width: 100%;">
                            <div style="justify-content: space-between; display: flex;">
                                <div></div>
                                <div class="dropdown">
                                    <div class="dropdown-toggle" style="cursor: pointer;">
                                        <svg width="10" height="4" viewBox="0 0 16 4" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4 2C4 3.10449 3.10449 4 2 4C0.895508 4 0 3.10449 0 2C0 0.895508 0.895508 0 2 0C3.10449 0 4 0.895508 4 2Z"
                                                fill="#1E1E1E" />
                                            <path
                                                d="M10 2C10 3.10449 9.10449 4 8 4C6.89551 4 6 3.10449 6 2C6 0.895508 6.89551 0 8 0C9.10449 0 10 0.895508 10 2Z"
                                                fill="#1E1E1E" />
                                            <path
                                                d="M14 4C15.1045 4 16 3.10449 16 2C16 0.895508 15.1045 0 14 0C12.8955 0 12 0.895508 12 2C12 3.10449 12.8955 4 14 4Z"
                                                fill="#1E1E1E" />
                                        </svg>
                                    </div>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item star-email"
                                            data-id="{{ $email->id }}"
                                            data-starred ="{{ $email->is_starred ? 'true' : 'false' }}"
                                            >{{ $email->is_starred ? 'Unstar' : 'Star' }}</button>
                                        <button class="dropdown-item delete-email"
                                            data-id="{{ $email->id }}">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <div class="email-item {{ $email->is_read ? 'read-email' : '' }} {{ $email->is_draft ? 'draft' : '' }}"
                                data-id="{{ $email->id }}" data-to="{{ $email->receiver?->email ?? 'Unknown' }}"
                                data-subject="{{ $email->subject }}" data-body="{{ $email->description }}"
                                data-draft="{{ $email->is_draft ? 'true' : 'false' }}" draggable="true"
                                ondragstart="handleDragStart(event,{{ $email->id }})">
                                <div
                                    style="
                                justify-content: space-between;
                                display: flex;margin-bottom: -15px; padding:5px">
                                    <div>
                                        <p style="font-size: 12px; font-weight: 500;">{{ $email->receiver->email ?? 'Unknown' }}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 12px; font-weight: 500;">
                                            {{ $email->created_at->format('d M H:i') }}</p>
                                    </div>
                                </div>
                                <div
                                    style="
                                justify-content: space-between;
                                display: flex; padding-left:5px; padding-right:5px;">
                                    <div>
                                        <p style="font-size: 14px;font-weight: 500; margin-bottom: 0px;">
                                            {{ \Str::limit($email->subject, 50) }}</p>
                                    </div>
                                    <div>
                                        <svg width="15" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M17.5249 0.359092C18.9104 0.422904 20.2154 1.03467 21.1592 2.06248C22.1029 3.09028 22.61 4.45207 22.571 5.85467C22.532 7.25729 21.9501 8.58848 20.9503 9.56141C19.9505 10.5343 18.6131 11.071 17.2263 11.0559L17.209 11.0556L13.566 10.9519C12.8078 10.9305 12.0632 10.7444 11.3824 10.4062C10.7017 10.068 10.1009 9.58564 9.62066 8.99188C9.14043 8.39812 8.79201 7.7068 8.59906 6.96477C8.4061 6.22274 8.37313 5.44734 8.50242 4.69117C8.59602 4.14376 9.11048 3.77646 9.65152 3.8708C10.1925 3.96513 10.5553 4.48537 10.4617 5.03278C10.381 5.50463 10.4016 5.98859 10.522 6.45181C10.6425 6.91502 10.86 7.34666 11.1598 7.7174C11.4597 8.08815 11.8349 8.3893 12.2598 8.60044C12.6848 8.81158 13.1497 8.92776 13.6229 8.94114L17.257 9.04453C18.1196 9.05177 18.9507 8.71709 19.5724 8.11211C20.196 7.50525 20.5591 6.67478 20.5834 5.79944C20.6078 4.92406 20.2913 4.07386 19.702 3.43207C19.1142 2.79194 18.3021 2.4104 17.4399 2.36891L15.3651 2.30375C14.8163 2.28651 14.3855 1.82245 14.4029 1.26724C14.4203 0.712022 14.8792 0.275903 15.428 0.293137L17.5105 0.358535L17.5249 0.359092ZM11.1907 0.650064C11.8714 0.988253 12.4722 1.47059 12.9524 2.06435C13.4327 2.65811 13.7811 3.34944 13.9741 4.09146C14.167 4.83349 14.2 5.60889 14.0707 6.36506C13.9771 6.91247 13.4626 7.27977 12.9216 7.18543C12.3806 7.0911 12.0178 6.57086 12.1114 6.02345C12.1921 5.5516 12.1716 5.06764 12.0511 4.60443C11.9306 4.1412 11.7131 3.70957 11.4133 3.33883C11.1134 2.96808 10.7383 2.66693 10.3133 2.45579C9.88828 2.24464 9.42342 2.12847 8.95025 2.11509L5.31611 2.01169C4.45351 2.00446 3.62242 2.33914 3.00075 2.94412C2.37715 3.55098 2.01399 4.38146 1.98966 5.2568C1.96533 6.13217 2.28181 6.98236 2.87111 7.62416C3.45859 8.26397 4.27017 8.64544 5.13186 8.68726L7.19926 8.74608C7.7481 8.76169 8.18022 9.22448 8.16442 9.77974C8.14863 10.335 7.6909 10.7725 7.14206 10.7569L5.06546 10.6978L5.04819 10.6971C3.66274 10.6333 2.35767 10.0216 1.41392 8.99375C0.470177 7.96595 -0.0368946 6.60416 0.00209271 5.20156C0.0410802 3.79894 0.623045 2.46775 1.62281 1.49482C2.62258 0.521887 3.95997 -0.0147552 5.34683 0.00030878L5.3641 0.000648312L9.00709 0.104297C9.7652 0.125754 10.51 0.311902 11.1907 0.650064Z"
                                                fill="#1E1E1E" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="width: 95%; margin-top:15px">
                            <hr style="margin: -10px !important;">
                        </div>
                    @empty
                        <div style="margin-top:10px">
                            <p style="font-weight:bold; color:#0C5097">No Emails</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div id="toggleDiv"
                    style="display:none; width: auto;
                    height: auto;
                    border-radius: 16px;
                    background: #F2F2F2;
                    padding: 20px;
                    ">
                    <div class="toggle-div">
                        <div></div>
                        <div
                            style="
                            align-items: baseline;
                            display: flex;
                            gap: 5px;
                        ">
                            <div>
                                <p style="color: #707070; font-size: 11px;">1-50 of 13911</p>
                            </div>
                            <div>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="14" height="14" rx="1" transform="matrix(-1 0 0 1 14 0)"
                                        fill="#79747E" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.88356 3.11313C9.03881 3.26398 9.03881 3.50855 8.88356 3.65939L5.95981 6.5L8.88356 9.34061C9.03882 9.49145 9.03882 9.73602 8.88356 9.88687C8.7283 10.0377 8.47657 10.0377 8.32131 9.88687L5.11644 6.77313C4.96118 6.62228 4.96118 6.37772 5.11644 6.22687L8.32131 3.11313C8.47657 2.96229 8.7283 2.96229 8.88356 3.11313Z"
                                        fill="white" />
                                </svg>
                            </div>
                            <div>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="14" height="14" rx="1" fill="#79747E" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.11644 3.11313C4.96119 3.26398 4.96119 3.50855 5.11644 3.65939L8.04019 6.5L5.11644 9.34061C4.96118 9.49145 4.96118 9.73602 5.11644 9.88687C5.2717 10.0377 5.52343 10.0377 5.67869 9.88687L8.88356 6.77313C9.03882 6.62228 9.03882 6.37772 8.88356 6.22687L5.67869 3.11313C5.52343 2.96229 5.2717 2.96229 5.11644 3.11313Z"
                                        fill="white" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sendContent"
                    style="display:block; width: auto;
                    height: auto;
                    border-radius: 16px;
                    background: #F2F2F2;
                    padding: 20px;
                    ">
                    <form action="{{ route('email.store') }}" method="POST" id="emailForm"
                        class="p-4 border rounded shadow-sm bg-light">
                        @csrf

                        <input type="hidden" name="draft_id" id="draft_id" value="">

                        <div class="mb-2">
                            <label for="email" class="form-label">To</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Enter Email" required>
                        </div>
                        <div class="mb-2">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control"
                                placeholder="Enter Subject">
                        </div>
                        <div class="mb-2">
                            <label for="body" class="form-label">Body</label>
                            <textarea name="body" id="editor" class="form-control" rows="5"></textarea>
                        </div>
                        <button id="sendBtn" type="submit" class="btn btn-primary w-100" style="background: #0c5097">Send
                            Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        const folderStoreRoute = "{{ route('folders.store') }}";
    </script>
    <script>
        const folderDeleteRoute = "{{ route('folders.destroy', ['id' => ':id']) }}";
    </script>
    <script src="{{ asset('js/email.js') }}"></script>
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

@endpush
