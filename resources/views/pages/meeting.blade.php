@extends('layouts.master')
@section('content')
    @include('pages.main', ['emails' => $emails])
    <div class="container" id="meeting-content" style="display: block; position: absolute;top: 180px; left: 120px;">
        <div style="display: flex; justify-content: space-between;align-items: center;">
            <div style="display: flex; align-items: end; gap: 10px;">
                <div>
                    <p style="color: #0C5097;font-size: 20px;font-weight: 700;">Meeting</p>
                </div>
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
                        <form action="{{ route('meetings.store') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scheduleMeetingModalLabel">Schedule Google Meet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="users" class="form-label">Invite Users (by email)</label>
                                        <select name="user_ids[]" multiple class="form-control" required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                    ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Selected users will receive calendar invites</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="topic" class="form-label">Meeting Topic</label>
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
                                    <button type="submit" class="btn btn-primary">Create Google Meet</button>
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
                            $joinUrl = $meeting['join_url'] ?? '#';

                            // For Google Meet events, we don't have participant info from API
                            $assignedUsers = isset($meeting['type']) && $meeting['type'] === 'database' ?
                                \App\Models\Meeting::find($meeting['id'])->participants :
                                collect([]);
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
                                @if ($status !== 'Cancelled' && $status !== 'Finished' && $joinUrl !== '#')
                                    <a href="{{ $joinUrl }}" target="_blank" rel="noopener noreferrer"
                                        @if (!$isButtonEnabled) style="pointer-events: none; opacity: 0.5;" @endif>
                                        <i class="fas fa-video" style="font-size: 20px; color: green;"></i>
                                    </a>
                                @endif
                            </td>

                            <td style="padding: 3px;font-size: 13px;">{{ $meeting['host'] ?? 'Unknown' }}</td>
                            <td style="padding: 3px;font-size: 13px;">
                                {{ $meetingStartTime->format('d-M-y h:i A') }}
                            </td>
                            <td style="padding: 3px;font-size: 13px;">{{ $status }}</td>
                            <td style="padding: 3px;">
                                <button
                                    style="border: none; height: 35px; font-size: 14px; padding: 5px 10px; border-radius: 5px; background: black; color: white;"
                                    data-bs-toggle="modal" data-bs-target="#viewMeetingDetailModal{{ $meeting['id'] }}">
                                    View Detail
                                </button>
                            </td>

                            <div class="modal fade" id="viewMeetingDetailModal{{ $meeting['id'] }}" tabindex="-1"
                                aria-labelledby="viewMeetingDetailModalLabel{{ $meeting['id'] }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewMeetingDetailModalLabel{{ $meeting['id'] }}">
                                                Meeting Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <h5>Topic: {{ $meeting['topic'] }}</h5>
                                            <p><strong>Start Time:</strong>
                                                {{ $meetingStartTime->format('d-M-y h:i A') }}
                                            </p>
                                            <p><strong>Status:</strong> {{ $status }}</p>
                                            <p><strong>Duration:</strong> {{ $meeting['duration'] }} minutes</p>
                                            <p><strong>Agenda:</strong> {{ $meeting['agenda'] ?? 'No agenda provided.' }}
                                            </p>
                                            <p><strong>Meeting Link:</strong>
                                                @if($joinUrl !== '#')
                                                    <a href="{{ $joinUrl }}" target="_blank">Join Google Meet</a>
                                                @else
                                                    No meeting link available
                                                @endif
                                            </p>

                                            @if(isset($meeting['type']) && $meeting['type'] === 'database' && $assignedUsers->count() > 0)
                                                <h6>Invited Users:</h6>
                                                <ul>
                                                    @foreach ($assignedUsers as $user)
                                                        <li>{{ $user->name }} ({{ $user->email }})</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Button (only for database meetings) -->
                            <td style="padding: 3px; font-size: 13px;">
                                @if ($status !== 'Cancelled' && $status !== 'Finished' && isset($meeting['type']) && $meeting['type'] === 'database')
                                    <button type="button" style="text-decoration: none;" class="btn btn-link p-0"
                                            data-bs-toggle="modal" data-bs-target="#editMeetingModal{{ $meeting['id'] }}">
                                        Edit
                                    </button>
                                @endif
                            </td>

                            <!-- Delete Button (only for database meetings) -->
                            <td style="padding: 3px; font-size: 13px;">
                                @if (isset($meeting['type']) && $meeting['type'] === 'database')
                                    <form action="{{ route('meetings.destroy', $meeting['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0"
                                                onclick="return confirm('Are you sure you want to delete this meeting?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <!-- Edit Modal (only for database meetings) -->
                            @if (isset($meeting['type']) && $meeting['type'] === 'database')
                                <div class="modal fade" id="editMeetingModal{{ $meeting['id'] }}" tabindex="-1"
                                    aria-labelledby="editMeetingModalLabel{{ $meeting['id'] }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('meetings.update', $meeting['id']) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editMeetingModalLabel{{ $meeting['id'] }}">
                                                        Edit Meeting</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    @php
                                                        $dbMeeting = \App\Models\Meeting::find($meeting['id']);
                                                        $assignedUserIds = $dbMeeting->participants->pluck('id')->toArray();
                                                    @endphp

                                                    <div class="mb-3">
                                                        <label for="user_ids{{ $meeting['id'] }}" class="form-label">Invite Users</label>
                                                        <select name="user_ids[]" id="user_ids{{ $meeting['id'] }}"
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
                                                        <label for="topic{{ $meeting['id'] }}"
                                                            class="form-label">Topic</label>
                                                        <input type="text" class="form-control" name="topic"
                                                            id="topic{{ $meeting['id'] }}" value="{{ $meeting['topic'] }}"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="start_time{{ $meeting['id'] }}" class="form-label">Start
                                                            Time</label>
                                                        <input type="datetime-local" class="form-control" name="start_time"
                                                            id="start_time{{ $meeting['id'] }}"
                                                            value="{{ \Carbon\Carbon::parse($meeting['start_time'])->timezone('Asia/Karachi')->format('Y-m-d\TH:i') }}"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="duration{{ $meeting['id'] }}" class="form-label">Duration
                                                            (minutes)
                                                        </label>
                                                        <input type="number" class="form-control" name="duration"
                                                            id="duration{{ $meeting['id'] }}"
                                                            value="{{ $meeting['duration'] }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="agenda{{ $meeting['id'] }}"
                                                            class="form-label">Agenda</label>
                                                        <textarea class="form-control" name="agenda" id="agenda{{ $meeting['id'] }}" rows="3">{{ $meeting['agenda'] ?? '' }}</textarea>
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
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
