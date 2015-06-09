<?php

namespace Derp\Command;

use Derp\Bundle\ERBundle\Entity\BirthDate;
use Derp\Bundle\ERBundle\Entity\FullName;
use Derp\Bundle\ERBundle\Entity\Patient;
use Derp\Bundle\ERBundle\Entity\PersonalInformation;
use Derp\Bundle\ERBundle\Entity\Sex;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;
use Symfony\Bridge\Doctrine\ManagerRegistry;


class RegisterWalkinHandler implements MessageHandler
{
    private $doctrine;
    private $mailer;

    /**
     * Constructor
     */
    public function __construct(
        ManagerRegistry $doctrine,
        \Swift_Mailer $mailer
    )
    {
        $this->doctrine = $doctrine;
        $this->mailer = $mailer;
    }

    /**
     * Handle the command.
     *
     * @param Message $command
     */
    public function handle(Message $command)
    {
        /* @var $command RegisterWalkin */

        $patient = Patient::walkIn(
            PersonalInformation::fromDetails(
                FullName::fromParts($command->firstName, $command->lastName),
                BirthDate::fromYearMonthDayFormat(
                    $command->birthDate->format('Y-m-d')
                ),
                new Sex($command->sex)
            ),
            $command->indication
        );

        $em = $this->doctrine->getManager();
        $em->persist($patient);
        $em->flush();

        if (!$patient->hasArrived()) {
            $message = \Swift_Message::newInstance(
                'A new patient is about to arrive',
                'Indication: ' . $patient->getIndication()
            );
            $message->setTo('triage-nurse@derp.nl');
            $this->mailer->send($message);
        }
    }
}
