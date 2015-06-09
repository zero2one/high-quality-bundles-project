<?php

namespace Derp\Command;

use Symfony\Component\Validator\Constraints as Assert;


class RegisterWalkin
{
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