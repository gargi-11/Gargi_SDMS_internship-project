<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // ... other code ...

    protected $middlewareGroups = [
        'web' => [
            // ... other middleware ...
            \App\Http\Middleware\PreventBackHistory::class,
        ],

        // ... other groups ...
    ];

    // ... other code ...
}

