<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\Publisher;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPublisherNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private readonly Publisher $publisher,
        private readonly Post $post,
    ) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Publisher Approval Needed')
            ->view('emails.new-publisher-notification', [
                'publisher' => $this->publisher,
                'post' => $this->post,
            ]);
    }
}