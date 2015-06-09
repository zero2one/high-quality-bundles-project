<?php

namespace Derp\Event;

use Derp\Domain\PatientRepository;
use SimpleBus\Message\Message;
use SimpleBus\Message\Subscriber\MessageSubscriber;

class WhenWalkinRegisteredNotifyTriageNurse implements MessageSubscriber
{
    private $mailer;
    private $patientRepository;

    /**
     * Constructor
     */
    public function __construct(\Swift_Mailer $mailer, PatientRepository $patientRepository)
    {
        $this->mailer = $mailer;
        $this->patientRepository = $patientRepository;
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
        $patient = $this->patientRepository->byId($message->patientId());

        $message = \Swift_Message::newInstance(
            'A new patient is about to arrive',
            'Indication: ' . $patient->getIndication()
        );
        $message->setTo('triage-nurse@derp.nl');
        $this->mailer->send($message);
    }

}