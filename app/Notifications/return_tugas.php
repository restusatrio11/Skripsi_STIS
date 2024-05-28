<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class return_tugas extends Notification
{
    use Queueable;
    private $job_return;

    /**
     * Create a new notification instance.
     */
    public function __construct($job_return)
    {
        $this->job_return = $job_return;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pekerjaan Dikembalikan',
            'description' => $this->job_return->jenisTask->tugas . ' Telah dikembalikan oleh ketua ' . $this->job_return->jenisTask->jenisTim->tim,
            'waktu_dibuat' => $this->job_return->created_at->format('Y-m-d H:i:s')
        ];
    }
}
