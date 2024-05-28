<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Tugas;

class create_job extends Notification
{
    use Queueable;
    private $job;

    /**
     * Create a new notification instance.
     */
    public function __construct($job)
    {
        $this->job = $job;
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
            'pegawai_id' => $this->job->pegawai_id,
            'nama_pegawai' => $this->job->namaUser->name,
            'title' => 'Pekerjaan Baru Diberikan',
            'description' => 'Pekerjaan ' . $this->job->jenisTask->tugas . ' telah dibuat oleh ketua ' . $this->job->jenisTask->jenisTim->tim,
            'waktu_dibuat' => $this->job->created_at->format('Y-m-d H:i:s') // Format sesuai kebutuhan Anda
        ];
    }
}
