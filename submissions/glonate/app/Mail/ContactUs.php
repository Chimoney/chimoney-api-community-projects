<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    protected $request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->request->email)->to(get_option('email_address'))->subject("[".get_option('site_name')."] Contact Us Query")->markdown('emails.contact_us.send')->with([
            'name' => $this->request->name,
            'email' => $this->request->email,
            'subject' => $this->request->subject,
            'message' => $this->request->message,
            'project_owner' => $this->request->project_owner,
            'project_backer' => $this->request->project_backer,
            'other' => $this->request->other,
        ]);
    }
}
