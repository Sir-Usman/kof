<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $seller;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // protected $detail ='';
    public function __construct($seller)
    {
        //
        $this->seller = $seller;
    }
   

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('registration')
        ->view('email-templates.saller-apply');
    }
}
