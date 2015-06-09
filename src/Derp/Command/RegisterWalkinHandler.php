<?php

namespace Derp\Command;

use Derp\Bundle\ERBundle\Entity\BirthDate;
use Derp\Bundle\ERBundle\Entity\FullName;
use Derp\Bundle\ERBundle\Entity\Patient;
use Derp\Bundle\ERBundle\Entity\PersonalInformation;
use Derp\Bundle\ERBundle\Entity\Sex;
use Derp\Domain\PatientRepository;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;
use Symfony\Bridge\Doctrine\ManagerRegistry;


class RegisterWalkinHandler implements MessageHandler
{
    private $patientRepository;

    /**
     * Constructor
     */
    public function __construct(
        PatientRepository $patientRepository
    )
    {
        $this->patientRepository = $patientRepository;
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
            $command->patientId,
            PersonalInformation::fromDetails(
                FullName::fromParts($command->firstName, $command->lastName),
                BirthDate::fromYearMonthDayFormat(
                    $command->birthDate->format('Y-m-d')
                ),
                new Sex($command->sex)
            ),
            $command->indication
        );

        $this->patientRepository->add($patient);
    }
}
