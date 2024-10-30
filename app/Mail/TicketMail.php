<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $ticketId;
    public $userName;
    public $tourDetails;
    public $totalQuantity;

    public $orderId;


    /**
     * Create a new message instance.
     */
    public function __construct($ticketId, $userName, $tourDetails, $totalQuantity, $orderId)
    {
        $this->ticketId = $ticketId;
        $this->userName = $userName;
        $this->tourDetails = $tourDetails;
        $this->totalQuantity = $totalQuantity;
        $this->orderId = $orderId;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tour Ticket',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.ticket',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
