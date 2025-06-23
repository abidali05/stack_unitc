@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    @include('pages.main', ['emails' => $emails])
    <div id="calendar"
        style="position: relative; z-index: 0; top: 175px; left: 57px; width: 95%;margin-bottom: 15% !important;">
    </div>
    <div class="modal fade" id="calendar-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border: none;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12 ">
                                <form id="event-form" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="text" name="event_title" class="form-control"
                                                id="exampleFormControlInput1" placeholder="Event Title">
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group my-2">
                                                <span class="input-group-text">Event Date:</span>
                                                <input type="date" name="event_date" class="form-control datepicker">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-between border rounded p-2">
                                                <label class="fw-bold me-1">From:</label>
                                                <input type="time" name="event_start_time" id="event_start_time"
                                                    class="form-control border-0 w-40 time-picker" value="00:00">
                                                <div class="clock-container" id="start-clock"></div>

                                                <label class="fw-bold mx-2">To:</label>
                                                <input type="time" name="event_end_time" id="event_end_time"
                                                    class="form-control border-0 w-40 time-picker" value="00:00">
                                                <div class="clock-container" id="end-clock"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-check">
                                                <input name="all_day" class="form-check-input" type="checkbox"
                                                    id="allDayCheckbox">
                                                <label class="form-check-label" for="allDayCheckbox">
                                                    <strong> All Day</strong>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <ul class="nav-tabs">
                                                <li><a href="#" id="details-tab"
                                                        class="tab-link">Details</a>
                                                </li>
                                                <li><a href="#" id="attendees-tab" class="tab-link">Attendees</a>
                                                </li>
                                                <li><a href="#" id="reminders-tab" class="tab-link">Reminders</a>
                                                </li>
                                                <li><a href="#" id="repeat-tab" class="tab-link">Repeat</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="row mt-2 tab-content divheeight" id="details-content">
                                        <div class="col-12">
                                            <div class="location-input">
                                                <i class="fa fa-map-marker-alt"></i>
                                                <input type="text" name="event_location" placeholder="Add Location">
                                            </div>
                                            <div class="location-input mt-3">
                                                <i class="fa fa-pencil-alt"></i>
                                                <input type="text" name="event_description"
                                                    placeholder="Add description">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-select-container">
                                                <i class="fa fa-eye"></i>
                                                <select class="ms-3 px-2" name="event_shared">
                                                    <option value="When Shared" selected>When Shared</option>
                                                    <option value="Public">Public</option>
                                                    {{-- <option value="Busy">Busy</option> --}}
                                                    <option value="Private">Private</option>
                                                </select>
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 tab-content divheeight" id="attendees-content">
                                        <div class="col-12">
                                            <div class="">
                                                <select id="attendees" name="users[]" class="form-control select2"
                                                    multiple>
                                                    <!-- Users will be loaded here via AJAX -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center pt-5">
                                            <img src="{{ asset('svg/invite-user.svg') }}" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="row mt-2 tab-content divheeight" id="reminders-content">
                                        <div class="col-12">
                                            <div class="custom-select-container">
                                                <label for="eventSelect"><strong>Reminder</strong></label>
                                                <select class="ps-2 form-control" id="eventSelect" style="margin-left:10px" name="reminder_value">
                                                    <option value="0">At the event's start</option>
                                                    <option value="5">5 minutes before the event</option>
                                                    <option value="10">10 minutes before the event</option>
                                                    <option value="30">30 minutes before the event</option>
                                                    <option value="60">1 hour before the event</option>
                                                    <option value="120">2 hours before the event</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Notification Type Selection -->
                                        <div class="col-12 mt-2">
                                            <strong>How should we notify you?</strong>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="systemNotification"
                                                    name="notification_type[]" value="system" checked>
                                                <label class="form-check-label" for="systemNotification">System
                                                    Notification</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="emailNotification"
                                                    name="notification_type[]" value="email">
                                                <label class="form-check-label" for="emailNotification">Email
                                                    Notification</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2 tab-content divheeight" id="repeat-content">
                                        <div class="col-12">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-3">
                                                    <p class="m-0" style="font-size: 12px; font-weight: 600;">Repeat
                                                        Every</p>
                                                </div>
                                                <div class="col-2 p-0">
                                                    <input type="number" name="recurrence_count"
                                                        class="form-control w-100" min="1" value="1">
                                                </div>
                                                <div class="col-3">
                                                    <select name="recurrence_type" class="form-control ms-2">
                                                        <option value="daily">Days</option>
                                                        <option value="weekly">Weeks</option>
                                                        <option value="monthly">Months</option>
                                                        <option value="yearly">Years</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Recurrence Mode Selection -->
                                            <div class="col-12">
                                                <p>Ends</p>

                                                <!-- Never Option -->
                                                <div class="form-check">
                                                    <input type="radio" name="recurrence_mode" id="recurrenceNever"
                                                        value="never" checked  style="margin-right: 12px;">
                                                    <label for="recurrenceNever">Never</label>
                                                </div>

                                                <!-- On a Specific Date Option -->
                                                <div class="form-check d-flex align-items-center">
                                                    <input type="radio" name="recurrence_mode" id="recurrenceOn"
                                                        value="on" style="margin-right: 16px;">
                                                    <label for="recurrenceOn" class="me-2" style="margin-right: 22px !important;">On</label>
                                                    <input type="date" name="recurrence_end_date" id="datepicker"
                                                        class="form-control ms-2 w-50" placeholder="MM/DD/YYYY" disabled>
                                                </div>

                                                <!-- After X Occurrences Option -->
                                                <div class="form-check d-flex align-items-center mt-2">
                                                    <input type="radio" name="recurrence_mode" id="recurrenceAfter"
                                                        value="after" style="margin-right: 18px;">
                                                    <label for="recurrenceAfter" class="me-2">After</label>
                                                    <input type="number" name="recurrence_count" id="occurrencesInput"
                                                        class="form-control ms-2 w-25" value="6" min="1"
                                                        disabled>
                                                    <span class="ms-2 text-muted">Occurrences</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pt-3  px-5">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary"
                                                style="width: 100%;background:#0C5097">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="successMessage" class="alert alert-success d-none">Event created successfully!</div>
@endsection
@push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/full-calendar.js') }}"></script>
    <script src="{{ asset('js/calendar.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        const storeEventRoute = "{{ route('dashboard.events.store') }}";
    </script>
@endpush
