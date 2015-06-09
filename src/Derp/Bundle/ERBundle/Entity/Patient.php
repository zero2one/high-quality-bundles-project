<?php

namespace Derp\Bundle\ERBundle\Entity;

use Derp\Event\WalkinRegistered;
use Doctrine\ORM\Mapping as ORM;
use SimpleBus\Message\Recorder\ContainsRecordedMessages;
use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;

/**
 * @ORM\Entity(repositoryClass="Derp\Bundle\ERBundle\Entity\PatientRepository")
 */
class Patient implements ContainsRecordedMessages
{
    use PrivateMessageRecorderCapabilities;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $indication;

    /**
     * @ORM\Column(type="boolean")
     */
    private $arrived;

    /**
     * @ORM\Embedded(class="PersonalInformation", columnPrefix=false)
     */
    private $personalInformation;

    private function __construct($id, PersonalInformation $personalInformation, $indication, $arrived)
    {
        \Assert\that($indication)->string()->notEmpty('Indication is required');

        $this->id = $id;
        $this->indication = $indication;
        $this->arrived = $arrived;
        $this->personalInformation = $personalInformation;
    }

    public static function walkIn($id, PersonalInformation $personalInformation, $indication)
    {
        $patient = new Patient($id, $personalInformation, $indication, true);

        // The event "has occurred".
        $event = new WalkinRegistered($patient->getIndication());
        $patient->record($event);

        return $patient;
    }

    public static function announce($id, PersonalInformation $personalInformation, $indication)
    {
        return new Patient($id, $personalInformation, $indication, false);
    }

    public function registerArrival()
    {
        \Assert\that($this->arrived)->false('The patient already arrived');

        $this->arrived = true;
    }

    public function hasArrived()
    {
        return $this->arrived;
    }

    public function getId()
    {
        return PatientId::fromString($this->id);
    }

    public function getIndication()
    {
        return $this->indication;
    }

    public function getPersonalInformation()
    {
        return $this->personalInformation;
    }

}
