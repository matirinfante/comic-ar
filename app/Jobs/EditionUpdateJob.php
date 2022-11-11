<?php

namespace App\Jobs;

use App\Mail\EditionNews;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class EditionUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $edition;
    protected $volume;
    protected $users;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($edition, $volume, $users)
    {
        $this->edition = $edition;
        $this->volume = $volume;
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $recipients = $this->users;
        foreach ($recipients as $recipient) {
            Mail::to($recipient->email)->send(new EditionNews($this->edition, $this->volume, $recipient->name));
        }
    }
}
