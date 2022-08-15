<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateTask extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $trainer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $trainer)
    {
        $this->user = User::find($id);
        $this->trainer = $trainer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mail@mental.test')
            ->view('emails.create_task')
            ->with([
                'user' => $this->user,
                'trainer' => $this->trainer
            ]);
    }
}
