<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url('/reset-password/'.$token.'?email='.$notifiable->email);

            return (new MailMessage)
                ->subject('Redefinição de senha | CineBox')
                ->markdown('emails.reset-password', [
                    'url' => $url,
                    'notifiable' => $notifiable,
                ]);
        });
    }
}
