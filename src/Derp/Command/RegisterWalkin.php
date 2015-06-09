<?php

namespace Derp\Command;

use SimpleBus\Message\Message;
use Symfony\Component\Validator\Constraints as Assert;
use Derp\Bundle\ERBundle\Entity\PatientId;


class RegisterWalkin implements Message
{
    /**
     * @var string
     */
    public $patientId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $firstName;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $lastName;

    /**
     * @var string
     * @Assert\Choice(choices={"male", "female", "intersex"})
     */
    public $sex;

    /**
     * @var \DateTime
     */
    public $birthDate;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $indication;
}