<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EditionNews extends Mailable
{
    use Queueable, SerializesModels;

    public $edition;
    public $volume;
    public $usrName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($edition, $volume, $usrName)
    {
        $this->edition = $edition;
        $this->volume = $volume;
        $this->usrName = $usrName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Novedades en ComicAR');
        return $this->markdown('emails.news');
    }
}