<?php

namespace Derp\Event;

use Derp\Bundle\ERBundle\Entity\PatientId;
use SimpleBus\Message\Message;

class WalkinRegistered implements Message
{
    private $patientId;

    /**
     * Constructor
     *
     * @param PatientId $patientId
     */
    public function __construct(PatientId $patientId)
    {
        $this->patientId = $patientId;
    }

    /**
     * @return mixed
     */
    public function patientId()
    {
        return $this->patientId;
    }
}
