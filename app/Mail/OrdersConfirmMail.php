<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use Mailtrap\EmailHeader\CategoryHeader;
use Mailtrap\EmailHeader\CustomVariableHeader;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Header\UnstructuredHeader;

class OrdersConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    private $carts;

    public function __construct(array $carts)
    {
        $this->carts = $carts;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('hello@example.com', 'Mailtrap Test'),
            replyTo: [
                new Address('hello@example.com', 'Mailtrap Test'),
            ],
            subject: 'Order confirmation',
            using: [
                function (Email $email) {
                    // Headers
                    $email->getHeaders()
                        ->addTextHeader('X-Message-Source', 'example.com')
                        ->add(new UnstructuredHeader('X-Mailer', 'Mailtrap PHP Client'))
                    ;

                    // Custom Variables
                    $email->getHeaders()
                        ->add(new CustomVariableHeader('user_id', '45982'))
                        ->add(new CustomVariableHeader('batch_id', 'PSJ-12'))
                    ;

                    // Category (should be only one)
                    $email->getHeaders()
                        ->add(new CategoryHeader('Integration Test'))
                    ;
                },
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.order-confirm-email',
            with: ['data' => $this->carts],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath('https://mailtrap.io/wp-content/uploads/2021/04/mailtrap-new-logo.svg')
                ->as('logo.svg')
                ->withMime('image/svg+xml'),
        ];
    }
    public function headers(): Headers
    {
        return new Headers(
            'custom-message-id@example.com',
            ['previous-message@example.com'],
            [
                'X-Custom-Header' => 'Custom Value',
            ],
        );
    }
}
