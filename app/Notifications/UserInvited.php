<?php

namespace App\Notifications;

use App\Enums\UserLevel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class UserInvited extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param UserLevel $userLevel
     * @param User $sender
     * @return void
     */
    public function __construct(public UserLevel $userLevel, public User $sender)
    {
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $appName = env('APP_NAME');

        $url = $this->generateInvitationUrl($notifiable->routes['mail']);

        return (new MailMessage)
                    ->subject('Personal Invitation')
                    ->greeting('Hello!')
                    ->line("You have been invited by {$this->sender->name} to join the {$appName} application!")
                    ->action('Click here to register your account', url($url))
                    ->line('Note: this link expires after 24 hours.');
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

    /**
     * Generates a unique signed URL that the mail receiver can user to register.
     * The URL contains the UserLevel and the receiver's email address, and will be valid for 1 day.
     *
     * @param $notifiable
     * @return string
     */
    public function generateInvitationUrl(string $email)
    {
        return URL::temporarySignedRoute('users.create', now()->addDay(), [
            'level' => $this->userLevel,
            'email' => $email
        ]);
    }
}
