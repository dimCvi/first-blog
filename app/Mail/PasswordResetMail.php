<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $message;
    protected $contactName;
    protected $contactEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactEmail, $contactName, $message)
    {
        $this->contactEmail = $contactEmail;
        $this->contactName = $contactName;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from($this->contactEmail, $this->contactName)
                ->replyTo($this->contactEmail)
                ->subject('You have new message on contact form')
                ;

        return $this->view('auth.emails.contact_form')
            ->with([
                'contactName' => $this->contactName,
                'contactMessage' => $this->message,
            ]);
    }
}
