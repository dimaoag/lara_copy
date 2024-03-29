<?php

namespace App\Mail\Auth;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Entity\User\User;

class VerifyMail extends Mailable
{
    use SerializesModels;
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function build()
    {
        return $this
            ->subject('Signup Confirmation')
            ->markdown('emails.auth.register.verify');
    }
}
