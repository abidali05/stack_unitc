<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'all_day' => filter_var($this->all_day, FILTER_VALIDATE_BOOLEAN),
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'all_day' => 'boolean',
            'event_start_time' => 'required_if:all_day,false|nullable',
            'event_end_time' => 'required_if:all_day,false|nullable',
            'event_location' => 'nullable|string|max:255',
            'event_description' => 'nullable|string',
            'event_shared' => 'nullable|string',
            'reminder_value' => 'nullable|integer|min:0',
            'reminder_unit' => 'nullable|in:minutes,hours,days,weeks',
            'send_notification' => 'boolean',
            'notification_type' => 'array',
            'notification_type.*' => 'in:system,email',
            'recurrence_mode' => 'required|in:never,on,after',
            'recurrence_end_date' => 'required_if:recurrence_mode,on|nullable|date|after_or_equal:event_date',
            'recurrence_count' => 'required_if:recurrence_mode,after|nullable|integer|min:1',
            'recurrence_type' => 'nullable|in:daily,weekly,monthly,yearly',
        ];
    }

    public function messages(): array
    {
        return [
            'event_start_time.required_if' => 'Start time is required unless "All Day" is selected.',
            'event_end_time.required_if' => 'End time is required unless "All Day" is selected.',
            'recurrence_end_date.required_if' => 'An end date is required when recurrence is set to "On".',
            'recurrence_count.required_if' => 'A recurrence count is required when recurrence is set to "After".',
        ];
    }
}
