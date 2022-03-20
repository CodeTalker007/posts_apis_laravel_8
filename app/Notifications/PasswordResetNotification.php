<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class PasswordResetNotification extends Notification
{
    use Queueable;
    protected string $token;
    protected User $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $token, User $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function passwordResetTemporaryUrl($notifiable): string
    {
        return URL::temporarySignedRoute('forget-password.reset', Carbon::now()->addMinutes(60), ['token' => $this->token]
        ); // this will basically mimic the email endpoint with get request
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->passwordResetTemporaryUrl($notifiable);

        return (new MailMessage)->subject(Lang::get('Reset Password'))->view('email-templates.password-reset', ['userName'=>$this->user->name,'url' => $verificationUrl]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
