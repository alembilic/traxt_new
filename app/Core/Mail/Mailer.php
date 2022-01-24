<?php

namespace App\Core\Mail;

use Illuminate\Contracts\Mail\Mailable as MailableContract;
use Illuminate\Mail\Mailer as BaseMailer;
use Illuminate\Mail\Transport\SesTransport;

class Mailer extends BaseMailer
{
    /**
     * Mapping transport drivers to headers in result message to retrieve identifier from.
     *
     * @var string[]
     */
    protected $idHeadersMapping = [
        SesTransport::class => 'X-SES-Message-ID',
    ];

    /**
     * {@inheritDoc}
     */
    public function send($view, array $data = [], $callback = null)
    {
        if ($view instanceof MailableContract) {
            return $this->sendMailable($view);
        }

        // First we need to parse the view, which could either be a string or an array
        // containing both an HTML and plain text versions of the view which should
        // be used when sending an e-mail. We will extract both of them out here.
        [$view, $plain, $raw] = $this->parseView($view);

        $data['message'] = $message = $this->createMessage();

        // Once we have retrieved the view content for the e-mail we will set the body
        // of this message using the HTML type, which will provide a simple wrapper
        // to creating view based emails that are able to receive arrays of data.
        $callback($message);

        $this->addContent($message, $view, $plain, $raw, $data);

        // If a global "to" address has been set, we will set that address on the mail
        // message. This is primarily useful during local development in which each
        // message should be delivered into a single mail address for inspection.
        if (isset($this->to['address'])) {
            $this->setGlobalToAndRemoveCcAndBcc($message);
        }

        // Next we will determine if the message should be sent. We give the developer
        // one final chance to stop this message and then we will send it to all of
        // its recipients. We will then fire the sent event for the sent message.
        $swiftMessage = $message->getSwiftMessage();

        if ($this->shouldSendMessage($swiftMessage, $data)) {
            $response = $this->sendSwiftMessage($swiftMessage);

            $this->dispatchSentEvent($message, $data);

            return $response;
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function sendSwiftMessage($message)
    {
        $this->failedRecipients = [];

        try {
            $this->swift->send($message, $this->failedRecipients);

            if (!isset($this->idHeadersMapping[get_class($this->swift->getTransport())])) {
                return [];
            }

            $header = $this->idHeadersMapping[get_class($this->swift->getTransport())];

            if (!$message->getHeaders()->has($header)) {
                return $header;
            }

            return ['id' => $message->getHeaders()->get($header)->getFieldBody()];
        } finally {
            $this->forceReconnection();
        }
    }
}
