@extends('layouts.master')
@section('content')
    @include('pages.main', ['emails' => $emails])
    <div class="container" id="meeting-content" style="display: block; position: absolute;top: 180px; left: 120px;">
        <div style="display: flex; justify-content: space-between;align-items: center;">
            <div style="display: flex; align-items: end; gap: 10px;">
                <div>
                    <p style="color: #0C5097;font-size: 20px;font-weight: 700;">Meeting</p>
                </div>
                {{-- <div>
                    <p style="font-size: 10px; font-weight: 600;">Meetings</p>
                </div>
                <div>
                    <p style="font-size: 10px;color: #565454;">Resolutions</p>
                </div>
                <div>
                    <p style="font-size: 10px;color: #565454;">Noticeboard</p>
                </div> --}}
            </div>
            <div>
                <!-- Button to trigger modal -->
                <button type="button" data-bs-toggle="modal" data-bs-target="#scheduleMeetingModal"
                    style="border: none; width: 150px; height: 35px; padding: 5px 10px; gap: 20px; border-radius: 5px; background: #0C5097; color: white;">
                    Schedule Meeting
                </button>

                <!-- Modal -->
                <div class="modal fade" id="scheduleMeetingModal" tabindex="-1" aria-labelledby="scheduleMeetingModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('zoom.meetings.store') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scheduleMeetingModalLabel">Schedule Zoom Meeting</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="users" class="form-label">Assign to Users</label>
                                        <select name="user_ids[]" multiple class="form-control" required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                    ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="topic" class="form-label">Topic</label>
                                        <input type="text" class="form-control" name="topic" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="start_time" class="form-label">Start Time</label>
                                        <input type="datetime-local" class="form-control" name="start_time" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="duration" class="form-label">Duration (minutes)</label>
                                        <input type="number" class="form-control" name="duration" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="agenda" class="form-label">Agenda</label>
                                        <textarea class="form-control" name="agenda" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr style="font-size: 13px;">
                        <th style="padding: 0px;">Title</th>
                        <th style="padding: 0px;"></th>
                        <th style="padding: 0px;">Host</th>
                        <th style="padding: 0px;">Date/Time</th>
                        <th style="padding: 0px;">Type</th>
                        <th style="padding: 0px;"></th>
                        <th style="padding: 0px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meetings as $meeting)
                        @php
                        $status = match ($meeting['status']) {
                            'waiting' => 'Upcoming',
                            'started' => 'Ongoing',
                            'ended' => 'Finished',
                            'cancelled' => 'Cancelled',
                            default => 'Unknown',
                        };

                        $btnColor = $status === 'Ongoing' ? '#000000' : '#0C5097';
                        $opacity = $status === 'Cancelled' || $status === 'Finished' ? '0.3' : '1';
                        $disabledRow = $status === 'Cancelled' ? 'pointer-events: none; background-color: #f2f2f2;' : '';
                            $hostName = auth()->user()->name; // or from DB if stored with meeting
                            $meetingId = $meeting['id'];
                            $joinUrl = "https://zoom.us/wc/{$meetingId}/join?prefer=1";
                            $assignedUserIds = $assignedUserIdsByMeeting[$meeting['id']] ?? [];
                            $assignedUsers = $users->whereIn('id', $assignedUserIds);
                        @endphp

                        <tr style="opacity: {{ $opacity }}; {{ $disabledRow }}">
                            <td style="padding: 3px;font-size: 13px;">
                                {{ \Illuminate\Support\Str::limit($meeting['topic'], 40) }}
                            </td>
                            @php
                            $meetingStartTime = \Carbon\Carbon::parse($meeting['start_time'])->timezone(config('app.timezone', 'Asia/Karachi'));
                            $meetingEndTime = $meetingStartTime->copy()->addMinutes($meeting['duration'] ?? 60);
                            $currentTime = \Carbon\Carbon::now(config('app.timezone', 'Asia/Karachi'));
                            $isButtonEnabled = $currentTime->between($meetingStartTime->subMinutes(30), $meetingEndTime);
                        @endphp


                        <td>
                            @if ($status !== 'Cancelled' && $status !== 'Finished')
                                <a href="{{ $joinUrl }}" target="_blank" rel="noopener noreferrer"
                                    @if (!$isButtonEnabled) style="pointer-events: none; opacity: 0.5;" @endif>
                                    <i class="fas fa-video" style="font-size: 20px; color: green;"></i>
                                </a>
                            @endif
                        </td>


                            <td style="padding: 3px;font-size: 13px;">{{ $hostName }}</td>
                            <td style="padding: 3px;font-size: 13px;">
                                {{ \Carbon\Carbon::parse($meeting['start_time'])->timezone('Asia/Karachi')->format('d-M-y h:i A') }}
                            </td>
                            <td style="padding: 3px;font-size: 13px;">{{ $status }}</td>
                            <td style="padding: 3px;">
                                <button
                                    style="border: none; height: 35px; font-size: 14px; padding: 5px 10px; border-radius: 5px; background: black; color: white;"
                                    data-bs-toggle="modal" data-bs-target="#viewMeetingDetailModal{{ $meetingId }}">
                                    View Detail
                                </button>
                            </td>

                            <div class="modal fade" id="viewMeetingDetailModal{{ $meetingId }}" tabindex="-1"
                                aria-labelledby="viewMeetingDetailModalLabel{{ $meetingId }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewMeetingDetailModalLabel{{ $meetingId }}">
                                                Meeting Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <h5>Topic: {{ $meeting['topic'] }}</h5>
                                            <p><strong>Start Time:</strong>
                                                {{ \Carbon\Carbon::parse($meeting['start_time'])->timezone('Asia/Karachi')->format('d-M-y h:i A') }}
                                            </p>
                                            <p><strong>Status:</strong> {{ $status }}</p>
                                            <p><strong>Duration:</strong> {{ $meeting['duration'] }} minutes</p>
                                            <p><strong>Agenda:</strong> {{ $meeting['agenda'] ?? 'No agenda provided.' }}
                                            </p>

                                            <h6>Assigned Users:</h6>
                                            <ul>
                                                @forelse ($assignedUsers as $user)
                                                    <li>{{ $user->name }} ({{ $user->email }})</li>
                                                @empty
                                                    <li>No users assigned</li>
                                                @endforelse
                                            </ul>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Button -->
                            <td style="padding: 3px; font-size: 13px;">
                                @if ($status !== 'Cancelled' && $status !== 'Finished')
                                    <button type="button" style="text-decoration: none;" class="btn btn-link p-0"
                                            data-bs-toggle="modal" data-bs-target="#editMeetingModal{{ $meetingId }}">
                                        Edit
                                    </button>
                                @endif
                            </td>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editMeetingModal{{ $meetingId }}" tabindex="-1"
                                aria-labelledby="editMeetingModalLabel{{ $meetingId }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('meetings.update', $meetingId) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editMeetingModalLabel{{ $meetingId }}">
                                                    Edit
                                                    Meeting</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                @php
                                                    $assignedUserIds = $assignedUserIds ?? [];
                                                @endphp

                                                <div class="mb-3">
                                                    <label for="user_ids{{ $meetingId }}" class="form-label">Assign to
                                                        Users</label>
                                                    <select name="user_ids[]" id="user_ids{{ $meetingId }}"
                                                        class="form-control" multiple required>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ in_array($user->id, $assignedUserIds) ? 'selected' : '' }}>
                                                                {{ $user->name }} ({{ $user->email }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="topic{{ $meetingId }}"
                                                        class="form-label">Topic</label>
                                                    <input type="text" class="form-control" name="topic"
                                                        id="topic{{ $meetingId }}" value="{{ $meeting['topic'] }}"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="start_time{{ $meetingId }}" class="form-label">Start
                                                        Time</label>
                                                    <input type="datetime-local" class="form-control" name="start_time"
                                                        id="start_time{{ $meetingId }}"
                                                        value="{{ \Carbon\Carbon::parse($meeting['start_time'])->timezone('Asia/Karachi')->format('Y-m-d\TH:i') }}"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="duration{{ $meetingId }}" class="form-label">Duration
                                                        (minutes)
                                                    </label>
                                                    <input type="number" class="form-control" name="duration"
                                                        id="duration{{ $meetingId }}"
                                                        value="{{ $meeting['duration'] }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="agenda{{ $meetingId }}"
                                                        class="form-label">Agenda</label>
                                                    <textarea class="form-control" name="agenda" id="agenda{{ $meetingId }}" rows="3">{{ $meeting['agenda'] ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update Meeting</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                    {{-- <tr>
                        <td style="padding: 2px;font-size: 13px;">Discussion on upcoming budget and its im...</td>
                        <td style="padding: 2px;font-size: 13px;">
                            <svg width="25" height="23" viewBox="0 0 35 23" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3 0C1.34315 0 0 1.34314 0 3V19.8906C0 21.5474 1.34315 22.8906 3 22.8906H21.1194C22.7763 22.8906 24.1194 21.5474 24.1194 19.8906V13.338L32.6941 19.1888C33.0003 19.3977 33.397 19.4201 33.7248 19.2469C34.0526 19.0737 34.2577 18.7334 34.2577 18.3627V4.52785C34.2577 4.15712 34.0526 3.81682 33.7248 3.64365C33.397 3.47048 33.0003 3.49287 32.6941 3.70182L24.1194 9.55254V3C24.1194 1.34314 22.7763 0 21.1194 0H3ZM2 3C2 2.44771 2.44771 2 3 2H21.1194C21.6717 2 22.1194 2.44772 22.1194 3V19.8906C22.1194 20.4428 21.6717 20.8906 21.1194 20.8906H3C2.44772 20.8906 2 20.4428 2 19.8906V3ZM32.2577 16.4698L24.8939 11.4453L32.2577 6.42078V16.4698Z"
                                    fill="black" />
                            </svg>
                        </td>
                        <td style="padding: 2px;font-size: 13px;">Yaqoob</td>
                        <td style="padding: 2px;font-size: 13px;">27-Dec-21 11:30 AM</td>
                        <td style="padding: 2px;font-size: 13px;">Upcoming</td>
                        <td style="padding: 2px;font-size: 13px;"><button
                                style="border: none;
                        height: 35px;
                        font-size: 14px;
                        padding: 5px 10px 5px 10px;
                        border-radius: 5px;
                        background: #0C5097;
                        color: white;
                        ">Add
                                Detail</button></td>
                        <td style="padding: 2px;font-size: 13px;">Edit</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;font-size: 13px;">Discussion on upcoming budget and its im...</td>
                        <td style="padding: 3px;font-size: 13px;">
                            <svg width="25" height="23" viewBox="0 0 35 23" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3 0C1.34315 0 0 1.34314 0 3V19.8906C0 21.5474 1.34315 22.8906 3 22.8906H21.1194C22.7763 22.8906 24.1194 21.5474 24.1194 19.8906V13.338L32.6941 19.1888C33.0003 19.3977 33.397 19.4201 33.7248 19.2469C34.0526 19.0737 34.2577 18.7334 34.2577 18.3627V4.52785C34.2577 4.15712 34.0526 3.81682 33.7248 3.64365C33.397 3.47048 33.0003 3.49287 32.6941 3.70182L24.1194 9.55254V3C24.1194 1.34314 22.7763 0 21.1194 0H3ZM2 3C2 2.44771 2.44771 2 3 2H21.1194C21.6717 2 22.1194 2.44772 22.1194 3V19.8906C22.1194 20.4428 21.6717 20.8906 21.1194 20.8906H3C2.44772 20.8906 2 20.4428 2 19.8906V3ZM32.2577 16.4698L24.8939 11.4453L32.2577 6.42078V16.4698Z"
                                    fill="black" />
                            </svg>
                        </td>
                        <td style="padding: 3px;font-size: 13px;">Yaqoob</td>
                        <td style="padding: 3px;font-size: 13px;">27-Dec-21 11:30 AM</td>
                        <td style="padding: 3px;font-size: 13px;">Ongoing</td>
                        <td style="padding: 3px;font-size: 13px;"><button
                                style="border: none;
                        height: 35px;
                        font-size: 14px;
                        padding: 5px 10px 5px 10px;
                        border-radius: 5px;
                        background: #000000;
                        color: white;
                        ">View
                                Detail</button></td>
                        <td style="padding: 3px;font-size: 13px;">Edit</td>
                    </tr>
                    <tr style="opacity: 30%;">
                        <td style="padding: 3px;font-size: 13px;">Discussion on upcoming budget and its im...</td>
                        <td style="padding: 3px;font-size: 13px;">

                        </td>
                        <td style="padding: 3px;font-size: 13px;">Yaqoob</td>
                        <td style="padding: 3px;font-size: 13px;">27-Dec-21 11:30 AM</td>
                        <td style="padding: 3px;font-size: 13px;">Cancelled</td>
                        <td style="padding: 3px;font-size: 13px;">
                            <button
                                style="border: none; height: 35px; font-size: 14px; padding: 5px 10px 5px 10px; border-radius: 5px; background: #0C5097; color: white;">
                                Add Detail
                            </button>
                        </td>
                        <td style="padding: 3px;font-size: 13px;">Edit</td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
