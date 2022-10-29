<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $message=explode('</br>',$content);
        $this->content = $message;
    }

    public function build(){
        $this->subject('Notificacion diaria: progreso en objetivos');
        return $this->markdown('emails.notification');
    }

    // public function envelope()
    // {
    //     return new Envelope(
    //         from: new Address('comic-ar@mail.com', 'Marvel Comics'),
    //         subject: 'Notificacion diaria: progreso en objetivos',
    //     );
    // }

    // public function content()
    // {
    //     return new Content(
    //         view: 'emails.notification',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
