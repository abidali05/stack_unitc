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
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getCategoryColor($category)
    {
        return match ($category) {
            'task' => '#5e6c84',
            'tweak' => '#00b8d9',
            'bug' => '#ff5630',
            'custom' => '#6554c0',
            default => '#5e6c84',
        };
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function statuses()
    {
        return $this->hasMany(ProjectStatus::class);
    }

    public function getExpectedDaysAttribute()
    {
        if ($this->start_date && $this->end_date) {
            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);

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
            $endDate = $this->end_date ? Carbon::parse($this->end_date) : Carbon::now();

            // Calculate the total number of days between start date and end date (or now)
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

        return null;
    }
}
