<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(public string $code) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Password Reset Code')
            ->greeting('Hello!')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->line('Your password reset code is:')
            ->line('# '.$this->code)
            ->line('This code will expire in 60 minutes.')
            ->line('If you did not request a password reset, no further action is required.');
    }
}
