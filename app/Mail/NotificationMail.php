<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $id;
    public $status;
    public $dateTime;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id,$status,$dateTime)
    {
        $this->id = $id;
        $this->status = $status;
        $this->dateTime = $dateTime;
    }


    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->subject('close status')
                    ->view('mail.notification');
    }
}
