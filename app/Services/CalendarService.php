<?php

namespace App\Services;

use App\Models\Calendar;
use App\Notifications\EventNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CalendarService
{
    public function generateRecurringEvents(Calendar $event)
    {
        if ($event->recurrence_mode === 'never') {
            return;
        }

        $events = [];
        $baseDate = Carbon::parse($event->event_date);

        if ($event->recurrence_mode === 'after') {
            $repeatCount = $event->recurrence_count;
        } else {
            $repeatCount = Carbon::parse($event->recurrence_end_date)->diffInDays($baseDate) ?? 1;
        }

        for ($i = 1; $i <= $repeatCount; $i++) {
            $newEvent = $event->replicate();
            $newEvent->event_date = $this->getNextRecurringDate($baseDate, $event->recurrence_type, $i);
            $events[] = $newEvent;
        }

        Calendar::insert(collect($events)->map(fn($e) => $e->toArray())->toArray());
    }

    private function getNextRecurringDate(Carbon $baseDate, string $type, int $step)
    {
        return match ($type) {
            'daily'   => $baseDate->copy()->addDays($step),
            'weekly'  => $baseDate->copy()->addWeeks($step),
            'monthly' => $baseDate->copy()->addMonths($step),
            'yearly'  => $baseDate->copy()->addYears($step),
            default   => $baseDate,
        };
    }

    public function sendNotification(Calendar $event)
    {
        $users = $event->users;
        if ($users->isEmpty()) return;

        $reminderTime = Carbon::parse($event->event_date)->subMinutes($event->reminder_value);

        foreach ($users as $user) {

            $notificationTypes = $event->notification_type ?? ['system'];

            if (in_array('system', $notificationTypes)) {
                $user->notify(new EventNotification($event))->delay($reminderTime);
            }
            if (in_array('email', $notificationTypes)) {
                Notification::route('mail', $user->email)->notify((new EventNotification($event))->delay($reminderTime));
            }
        }
    }
}
