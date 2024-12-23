<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Achievement;
use App\Policies\AchievementPolicy;
use App\Models\Internship;
use App\Policies\InternshipPolicy;
use App\Models\Course;
use App\Policies\CoursePolicy;
use App\Models\Publication;
use App\Policies\PublicationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Achievement::class => AchievementPolicy::class,
        Internship::class => InternshipPolicy::class,
        Course::class => CoursePolicy::class,
        Publication::class => PublicationPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}

