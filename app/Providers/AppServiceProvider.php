<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Project::created(function ($project) {
            ProjectStatus::create([
                'project_id' => $project->id,
                'status' => 'todo',
                'updated_by' => auth()->id(),
            ]);
        });
    }
}
