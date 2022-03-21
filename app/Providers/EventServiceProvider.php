<?php

namespace App\Providers;

use App\Events\PasswordResetRequest;
use App\Events\PostCreated;
use App\Events\UserRegistered;
use App\Listeners\NotifyPasswordResetRequest;
use App\Listeners\SendEmailVerificationNotification;
use App\Listeners\SendPostCreationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegistered::class => [
            SendEmailVerificationNotification::class,
        ],
        PasswordResetRequest::class=>[
            NotifyPasswordResetRequest::class
        ],
        PostCreated::class=>[
            SendPostCreationNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
