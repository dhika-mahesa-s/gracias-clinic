<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email Anda - Gracias Clinic')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Terima kasih telah mendaftar di **Gracias Clinic**, klinik kecantikan terpercaya di Pekanbaru.')
            ->line('Untuk melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:')
            ->action('Verifikasi Email Saya', $verificationUrl)
            ->line('Link verifikasi ini akan kadaluarsa dalam **60 menit**.')
            ->line('Jika Anda tidak membuat akun ini, abaikan email ini.')
            ->salutation('Salam hangat,  
**Tim Gracias Clinic**  
_Your Beauty, Our Priority_');
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
