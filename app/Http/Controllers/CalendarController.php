<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarRequest;
use App\Models\Calendar;
use App\Services\CalendarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    protected CalendarService $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function storeOrUpdate(CalendarRequest $request, $id = null): JsonResponse
    {
        //dd('eee');
        $event = Calendar::updateOrCreate(
            ['id' => $id],
            $request->validate()
        );

        if ($request->has('users')) {
            $event->users()->sync($request->users);
        }

        if ($request->recurrence_mode !== 'never') {
            $this->calendarService->generateRecurringEvents($event, $request);
        }

        if ($event->send_notificaton) {
            $this->calendarService->sendNotification($event);
        }

        return response()->json([
            'message' => 'Event saved successfully',
            'event' => $event
        ], 201);
    }
}
