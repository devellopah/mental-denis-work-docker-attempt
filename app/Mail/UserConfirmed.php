<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserConfirmed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $user;
    protected $password;

    /**
     * UserConfirmed constructor.
     * @param $id user id
     */
    public function __construct(User $user, $password = '')
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user_confirmed')->with([
            'login' => $this->user->email,
            'password' => $this->password
        ]);
    }
}
