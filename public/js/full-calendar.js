document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        customButtons: {
            createButton: {
                text: 'Create Event',
                click: function() {
                    var modal = new bootstrap.Modal(document.getElementById('calendar-modal'));
                    modal.show();
                }
            }
        },
        headerToolbar: {
            left: 'createButton prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: 'calendar/events',
        eventClick: function (info) {
            const formatDate = (date) => {
                return new Intl.DateTimeFormat('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }).format(date);
            };

            const formatTime = (date, allDay) => {
                if (allDay) return 'All Day';
                return new Intl.DateTimeFormat('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                }).format(date);
            };

            const event = info.event;
            if (!event) return;

            const safeHTML = (str) => {
                const div = document.createElement('div');
                div.textContent = str;
                return div.innerHTML;
            };

            const location = safeHTML(event.extendedProps?.location || '');
            const description = safeHTML(event.extendedProps?.description || '');

            Swal.fire({
                title: event.title,
                html: `
                    <div class="event-details">
                        <div class="detail-row">
                            <i class="far fa-calendar text-blue-500 mr-2" style="margin-top:3px"></i>
                            <div style="margin-left:7px">
                                <div class="text-gray-700" style="font-weight: 500;">Date</div>
                                <div class="font-medium">${formatDate(event.start)}</div>
                            </div>
                        </div>

                        <div class="detail-row">
                            <i class="far fa-clock text-blue-500 mr-2" style="margin-top:3px"></i>
                            <div style="margin-left:7px">
                                <div class="text-gray-700" style="font-weight: 500;">Time</div>
                                <div class="font-medium">${formatTime(event.start, event.allDay)}</div>
                            </div>
                        </div>

                        <div class="detail-row">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-2" style="margin-top:3px"></i>
                            <div style="margin-left:7px">
                                <div class="text-gray-700" style="font-weight: 500;">Location</div>
                                <div class="font-medium">${location || 'No location specified'}</div>
                            </div>
                        </div>

                        <div class="detail-row">
                            <i class="far fa-file-alt text-blue-500 mr-2" style="margin-top:3px"></i>
                            <div style="margin-left:7px">
                                <div class="text-gray-700" style="font-weight: 500;">Description</div>
                                <div class="font-medium description-text">${description || 'No description available'}</div>
                            </div>
                        </div>
                    </div>
                `,
                icon: 'info',
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Close',
                cancelButtonColor: '#64748b',
                customClass: {
                    container: 'event-modal',
                    popup: 'rounded-lg shadow-xl',
                    header: 'border-b pb-3',
                    content: 'pt-4',
                    actions: 'border-t pt-3'
                },
                didOpen: () => {
                    // Add custom styles when modal opens
                    const style = document.createElement('style');
                    style.textContent = `
                        .event-details {
                            text-align: left;
                            padding: 1rem;
                        }
                        .detail-row {
                            display: flex;
                            align-items: flex-start;
                            margin-bottom: 1rem;
                            padding: 0.5rem;
                            border-radius: 0.375rem;
                            background-color: #f8fafc;
                        }
                        .description-text {
                            white-space: pre-wrap;
                            word-break: break-word;
                        }
                    `;
                    document.head.appendChild(style);
                }
            });
        }
    });

    calendar.render();
});
