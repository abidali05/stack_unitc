@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/notes.css') }}">

    @include('pages.main', ['emails' => $emails])

    <div class="container-fluid" id="notes-content" style="position: absolute; top: 170px; left: 60px; width: 95%;">
        <p style="color: #0C5097;font-size: 20px;font-weight: 700;">Notes</p>
        <div class="row">
            <div class="col-lg-3 col-md-3 ">
                <div id="note-add-id" class="add-notes-btn rounded" data-bs-toggle="modal" data-bs-target="#addNotesModal">
                    <div>
                        <svg width="20" height="28" viewBox="0 0 27 28" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M17.3867 0.345215H10.7057V10.3667H0.207031V17.0477H10.7057V27.0692H17.3867V17.0477H26.931V10.3667H17.3867V0.345215Z"
                                fill="black" />
                        </svg>
                    </div>
                    <div style="font-size: 12px; font-weight:bold">
                        Create New Note
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-3 justify-content-between align-items-center rounded" style="background-color:#F4F4F4">
            <div class="col-lg-4 month-div p-0">
               <p class="ms-2" style="color: #0C5097;font-size: 20px;font-weight: 700;">Filter</p>
           
            </div>
                  <div class="col-lg-2 month-div d-flex p-0 ">
         
                <input id="calendar" type="text" class="form-control my-3" placeholder="Select Date" />  
                <div style="display: flex; justify-content: center; position: relative;right: 30px;top:17px">
                    <svg width="20" height="36" viewBox="0 0 31 36" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M23.648 1.28991V3.97292C28.2917 4.40289 30.5447 7.1719 30.8887 11.2824C30.9403 11.764 30.5275 12.1939 30.0287 12.1939H0.928383C0.446816 12.1939 0.0340453 11.7812 0.0684429 11.2824C0.412419 7.1719 2.66546 4.40289 7.30914 3.97292V1.28991C7.30914 0.584759 7.8939 0 8.59905 0C9.3042 0 9.88896 0.584759 9.88896 1.28991V3.86973H21.0682V1.28991C21.0682 0.584759 21.6529 0 22.3581 0C23.0632 0 23.648 0.584759 23.648 1.28991ZM1.71988 14.7739H29.238C30.1839 14.7739 30.9578 15.5478 30.9578 16.4937V27.0882C30.9578 32.2478 28.378 35.6876 22.3584 35.6876H8.5994C2.57982 35.6876 0 32.2478 0 27.0882V16.4937C0 15.5478 0.773946 14.7739 1.71988 14.7739ZM10.5945 29.2419C10.6231 29.217 10.6518 29.1922 10.6805 29.1693C10.99 28.8425 11.1792 28.3953 11.1792 27.9481C11.1792 27.501 10.99 27.0538 10.6805 26.727L10.4225 26.5206C10.3193 26.4519 10.2161 26.4003 10.1129 26.3659C10.0097 26.3143 9.90651 26.2799 9.80331 26.2627C9.45934 26.1939 9.11536 26.2283 8.80578 26.3659C8.5822 26.4519 8.41021 26.5722 8.23822 26.727C7.92864 27.0538 7.73946 27.501 7.73946 27.9481C7.73946 28.3953 7.92864 28.8425 8.23822 29.1693C8.41021 29.324 8.5822 29.4444 8.80578 29.5304C9.01217 29.6164 9.23575 29.668 9.45934 29.668C9.56617 29.668 9.65947 29.6545 9.76325 29.6394C9.77642 29.6375 9.78976 29.6356 9.80331 29.6336C9.90651 29.6164 10.0097 29.582 10.1129 29.5304C10.2161 29.496 10.3193 29.4444 10.4225 29.3756C10.4798 29.3412 10.5371 29.2916 10.5945 29.2419ZM9.45934 23.6484C9.90651 23.6484 10.3537 23.4593 10.6805 23.1497C10.99 22.8229 11.1792 22.3757 11.1792 21.9286C11.1792 21.4814 10.99 21.0342 10.6805 20.7075C10.5257 20.5527 10.3365 20.4323 10.1129 20.3463C9.47654 20.0711 8.71979 20.2259 8.23822 20.7075C7.92864 21.0342 7.73946 21.4814 7.73946 21.9286C7.73946 22.3757 7.92864 22.8229 8.23822 23.1497C8.565 23.4593 9.01217 23.6484 9.45934 23.6484ZM15.4789 29.668C15.9261 29.668 16.3733 29.4788 16.7 29.1693C17.0096 28.8425 17.1988 28.3953 17.1988 27.9481C17.1988 27.501 17.0096 27.0538 16.7 26.727C16.0637 26.0907 14.8942 26.0907 14.2578 26.727C13.9482 27.0538 13.759 27.501 13.759 27.9481C13.759 28.3953 13.9482 28.8425 14.2578 29.1693C14.5846 29.4788 15.0317 29.668 15.4789 29.668ZM16.442 23.3561L16.7 23.1497C17.0096 22.8229 17.1988 22.3757 17.1988 21.9286C17.1988 21.4814 17.0096 21.0342 16.7 20.7075C16.2185 20.2259 15.4617 20.0711 14.8254 20.3463C14.6018 20.4323 14.4126 20.5527 14.2578 20.7075C13.9482 21.0342 13.759 21.4814 13.759 21.9286C13.759 22.3757 13.9482 22.8229 14.2578 23.1497C14.5846 23.4593 15.0317 23.6484 15.4789 23.6484C15.5858 23.6484 15.6791 23.6349 15.7829 23.6198C15.796 23.6179 15.8093 23.616 15.8229 23.614C15.9261 23.5968 16.0293 23.5625 16.1325 23.5109C16.2357 23.4765 16.3389 23.4249 16.442 23.3561ZM21.4985 29.668C21.9457 29.668 22.3928 29.4788 22.7196 29.1693C23.0292 28.8425 23.2184 28.3953 23.2184 27.9481C23.2184 27.501 23.0292 27.0538 22.7196 26.727C22.0833 26.0907 20.9137 26.0907 20.2774 26.727C19.9678 27.0538 19.7786 27.501 19.7786 27.9481C19.7786 28.3953 19.9678 28.8425 20.2774 29.1693C20.6042 29.4788 21.0513 29.668 21.4985 29.668ZM22.4616 23.3561L22.7196 23.1497C23.0292 22.8229 23.2184 22.3757 23.2184 21.9286C23.2184 21.4814 23.0292 21.0342 22.7196 20.7075L22.4616 20.5011C22.3584 20.4323 22.2552 20.3807 22.152 20.3463C22.0489 20.2947 21.9457 20.2603 21.8425 20.2431C21.4985 20.1743 21.1545 20.2087 20.8449 20.3463C20.6214 20.4323 20.4494 20.5527 20.2774 20.7075C19.9678 21.0342 19.7786 21.4814 19.7786 21.9286C19.7786 22.3757 19.9678 22.8229 20.2774 23.1497C20.6042 23.4593 21.0513 23.6484 21.4985 23.6484C21.6017 23.6484 21.7221 23.6312 21.8425 23.614C21.9457 23.5968 22.0489 23.5625 22.152 23.5109C22.2552 23.4765 22.3584 23.4249 22.4616 23.3561Z"
                            fill="#0C5097" />
                    </svg>
                </div>
          
            </div>
          
        </div>
        <div class="row my-3" style="row-gap: 8px" id="notesContainer">
            @forelse ($notes as $note)
                <div class="col-lg-3 col-md-3 position-relative" >
                    <div class="notes-container rounded" style="background-color:#F4F4F4 ;color:black">
                        <div style="display: flex; width: 100%;">
                            <div>
                                <img class="img-fluid"
                                    src="{{ $note->image ? asset($note->image) : asset('images/default-notes.png') }}"
                                    style="width: 60px; height: 60px; border-radius: 100px;">
                            </div>
                            <div style="padding-top: 10px; padding-left: 5px;">
                                <p style="font-size: 16px;font-weight:600;color: black; margin-bottom: 0px;">
                                    By: {{ $note->user->name }}
                                </p>
                            </div>
                        </div>
                        <div style="width: 100%;" class="editor-data1">{!! Str::limit($note->description, 50) !!}</div>
                        <div style="width: 100%;">
                            <p style="float: right; margin-bottom: 0px; font-weight: 500; font-size: 10px;">
                                {{ $note->created_at->format('d-M-y h:i A') }}
                            </p>
                        </div>
                        <div class="overlay">
                            <div class="icon-container">
                                <a href="#" class="view-icon" title="View" data-bs-toggle="modal"
                                    data-bs-target="#viewModal" data-id="{{ $note->id }}"
                                    data-title="{{ $note->title }}" data-description="{{ $note->description }}">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="javascript:void(0)" class="edit-icon" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editModal" data-id="{{ $note->id }}"
                                    data-title="{{ $note->title }}" data-description="{{ $note->description }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="javascript:void(0)" class="delete-icon" title="Delete"
                                    data-id="{{ $note->id }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No notes available. Start adding your notes!</p>
            @endforelse
        </div>
    </div>

    <!-- Add Notes Modal -->
    <div class="modal fade" id="addNotesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Notes</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('note.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 position-relative">
                            <input type="file" name="image" class="form-control d-none" id="fileInput"
                                accept="image/*">
                            <div id="imagePreview" class="rounded-circle mt-3">
                                <label for="fileInput"
                                    class="btn rounded-circle d-flex justify-content-center align-items-center img-label">
                                    <i class="fas fa-pen"></i>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ old('title') }}">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" id="editor">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Notes Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">View Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="noteTitle"></h4>
                    <p id="noteDescription"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Notes Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('note.update',['note' =>  '__id__']) }}" method="POST" enctype="multipart/form-data" id="editNoteForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="note_id" id="noteId">
                        <div class="mb-3">
                            <label for="noteTitleInput" class="form-label">Title</label>
                            <input type="text" class="form-control" id="noteTitleInput" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="noteDescriptionInput" class="form-label">Description</label>
                            <textarea class="form-control" id="noteDescriptionInput" name="description" required>{{ old('description') }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="updateNoteButton">Update Note</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/notes.js') }}"></script>
@endpush
