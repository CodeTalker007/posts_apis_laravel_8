<?php

namespace App\Listeners;

use App\Events\PasswordResetRequest;
use App\Jobs\SendPasswordResetEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyPasswordResetRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PasswordResetRequest  $event
     * @return void
     */
    public function handle(PasswordResetRequest $event)
    {
        SendPasswordResetEmailJob::dispatch($event);
    }
}
