<?php

namespace Derp\Event;

use SimpleBus\Message\Message;
use SimpleBus\Message\Subscriber\MessageSubscriber;

class WhenWalkinRegisteredNotifyTriageNurse implements MessageSubscriber
{
    private $mailer;

    /**
     * Constructor
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Provide the given message as a notification to this subscriber
     *
     * @param Message $message
     *
     * @return void
     */
    public function notify(Message $message)
    {
        $message = \Swift_Message::newInstance(
            'A new patient is about to arrive',
            'Indication: ' . $message->indication()
        );
        $message->setTo('triage-nurse@derp.nl');
        $this->mailer->send($message);
    }

}