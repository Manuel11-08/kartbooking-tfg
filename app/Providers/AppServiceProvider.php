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
    \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));

    ResetPassword::toMailUsing(function ($notifiable, $token) {
        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        \Illuminate\Support\Facades\Log::info('Reset URL construida: ' . $url);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Kartbooking — Restablecer contraseña')
            ->view('emails.reset-password', ['url' => $url]);
    });
}
}
