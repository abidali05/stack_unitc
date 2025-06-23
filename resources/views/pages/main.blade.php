<div class="main">
    <a href="{{ route('news-feed.index') }}" style="color:inherit;font-weight:bold;text-decoration:none">
        <div class="main-first">
            <div class="main-second" id="feed-btn" style="background: #7C53F2;">
                <img src="{{ asset('svg/feed.svg') }}" alt="">
            </div>
            <div class="main-first-text">
                Feed
            </div>
        </div>
    </a>

    <a href="{{ route('project.index') }}" style="color:inherit;font-weight:bold">
        <div class="notification">
            <div class="main-first">
                <div class="main-second" id="project-btn" style="background: #036AB2;">
                    <img src="{{ asset('svg/project.svg') }}" alt="">
                </div>
                <div class="main-first-text">
                    Projects
                </div>
            </div>
            <div class="notification-main">
                <p style="color: white; text-align: center; font-size: 12px; font-weight: 600;">5</p>
            </div>
        </div>
    </a>

    <a href="{{ route('meetings.index') }}" style="color:inherit;font-weight:bold">
        <div class="notification">
            <div class="main-first">
                <div class="main-second" id="meeting-btn" style="background: #FF8E1D;">
                    <img src="{{ asset('svg/meeting.svg') }}" alt="">
                </div>
                <div class="main-first-text" id="meeting-btn">
                    Meetings
                </div>
            </div>
            <div class="notification-main">
                <p style="color: white; text-align: center; font-size: 12px; font-weight: 600;">8</p>
            </div>
        </div>
    </a>

    <div class="main-first">
        <div class="main-second" style="background: #31B6EF;">
            <img src="{{ asset('svg/social-media.svg') }}" alt="">
        </div>
        <div class="main-first-text">
            Social Media
        </div>
    </div>

    <a href="{{ route('team.index') }}" style="color:inherit;font-weight:bold;text-decoration:none">
        <div class="main-first">
            <div class="main-second" id="team-btn" style="background: #14A085;">
                <img src="{{ asset('svg/team.svg') }}" alt="">
            </div>
            <div class="main-first-text">
                Teams
            </div>
        </div>
    </a>

    <a href="{{ route('minisites.index') }}" style="color:inherit;font-weight:bold;text-decoration:none">
        <div class="main-first">
            <div class="main-second" id="minisite-btn1" style="background: #10AA2E;">
                <img src="{{ asset('svg/minisite.svg') }}" alt="">
            </div>
            <div class="main-first-text">
                Minisite
            </div>
        </div>
    </a>

    <a href="{{ route('file-sync.index') }}" style="color:inherit;font-weight:bold;text-decoration:none">
        <div class="main-first">
            <div class="main-second" style="background: #C7C700;">
                <img src="{{ asset('svg/file-sync.svg') }}" alt="">
            </div>
            <div class="main-first-text">
                File Sync
            </div>
        </div>
    </a>

    <a href="{{ route('note.index') }}" style="color:inherit;font-weight:bold;text-decoration:none">
        <div class="main-first">
            <div class="main-second" id="notes-btn" style="background: #CC8F0D;">
                <img src="{{ asset('svg/note.svg') }}" alt="">
            </div>
            <div class="main-first-text">
                Notes
            </div>
        </div>
    </a>

    <a href="{{ route('email.index', 'inbox') }}" style="color:inherit;font-weight:bold">
        <div class="notification">
            <div class="main-first">
                <div class="main-second" id="email-btn" style="background: #8644B1;">
                    <img src="{{ asset('svg/email.svg') }}" alt="">
                </div>
                <div class="main-first-text">
                    Email
                </div>
            </div>
            <div class="notification-main">
                <p style="color: white; text-align: center; font-size: 12px; font-weight: 600;">{{ $emails->count() }}
                </p>
            </div>
        </div>
    </a>

    <a href="{{ route('full-calendar') }}" style="color:inherit;font-weight:bold;text-decoration:none">
        <div class="main-first">
            <div class="main-second" style="background: #CF6548;">
                <img src="{{ asset('svg/calendar.svg') }}" alt="">
            </div>
            <div class="main-first-text">
                Calendar
            </div>
        </div>
    </a>

    <div class="main-first">
        <div class="main-second" style="background: #CF6548;">
            <img src="{{ asset('svg/calendar.svg') }}" alt="">
        </div>
        <div class="main-first-text">
            Attendance
        </div>
    </div>
</div>
