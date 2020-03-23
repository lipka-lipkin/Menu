<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailParent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends VerifyEmailParent
{
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        $hash = sha1($notifiable->getEmailForVerification());
        $id = $notifiable->getKey();
        $url = config('app.front_url') . '/verify-email' . '?id=' . $id . '&hash=' . $hash . '&' . '';
        $temporaryUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $id,
                'hash' => $hash,
            ]
        );
        $url .= parse_url($temporaryUrl, PHP_URL_QUERY);
        return $url;
    }
}
