<?php

namespace Derp\Command;

use Derp\Bundle\ERBundle\Entity\BirthDate;
use Derp\Bundle\ERBundle\Entity\FullName;
use Derp\Bundle\ERBundle\Entity\Patient;
use Derp\Bundle\ERBundle\Entity\PersonalInformation;
use Derp\Bundle\ERBundle\Entity\Sex;
use Derp\Event\WalkinRegistered;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;
use SimpleBus\Message\Recorder\RecordsMessages;
use Symfony\Bridge\Doctrine\ManagerRegistry;


class RegisterWalkinHandler implements MessageHandler
{
    private $doctrine;
    private $eventRecorder;

    /**
     * Constructor
     */
    public function __construct(
        ManagerRegistry $doctrine,
        RecordsMessages $eventRecorder
    )
    {
        $this->doctrine = $doctrine;
        $this->eventRecorder = $eventRecorder;
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

        // The event "has occurred".
        $event = new WalkinRegistered($patient->getIndication());
        $this->eventRecorder->record($event);
    }
}
