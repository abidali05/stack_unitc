<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'deadline' => 'date',
        'end_date' => 'date',
        'deadline' => 'date',
    ];

    //protected $dates = ['start_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statuses()
    {
        return $this->hasMany(ProjectStatus::class);
    }

    public function getExpectedDaysAttribute()
    {
        if ($this->start_date && $this->deadline) {
            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->deadline);

            // Calculate the total number of days between the two dates
            $totalDays = $startDate->diffInDays($endDate);

            // Calculate the number of full months
            $months = $startDate->diffInMonths($endDate);

            // If total days are less than 30, we only show days
            if ($totalDays < 30) {
                return $totalDays . ' days';
            }

            // Calculate remaining days after months
            $remainingDays = $totalDays - ($months * 30);

            // If months is greater than 0, return months and remaining days
            if ($months > 0) {
                return $months . ' months ' . $remainingDays . ' days';
            }

            // If there are no months, just return the days
            return $remainingDays . ' days';
        }

        return null;
    }

    public function getDaysUsedAttribute()
    {
        if ($this->status === 'completed' && $this->start_date) {
            $startDate = Carbon::parse($this->start_date);

            if (!$this->end_date) {
                $this->end_date = Carbon::now();
                $this->save();
            }

            $endDate = Carbon::parse($this->end_date);

            // Calculate the total number of days between start date and current date
            $totalDaysUsed = $startDate->diffInDays($endDate);

            // Calculate the number of full months used
            $monthsUsed = $startDate->diffInMonths($endDate);

            // If total days are less than 30, we only show days
            if ($totalDaysUsed < 30) {
                return $totalDaysUsed . ' days';
            }

            // Calculate remaining days after months
            $remainingDaysUsed = $totalDaysUsed - ($monthsUsed * 30);

            // If monthsUsed is greater than 0, return months and remaining days
            if ($monthsUsed > 0) {
                return $monthsUsed . ' months ' . $remainingDaysUsed . ' days';
            }

            // If there are no months, just return the days
            return $remainingDaysUsed . ' days';
        }

        if ($this->status === 'reopen') {
            return null;
        }

        return null;
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
