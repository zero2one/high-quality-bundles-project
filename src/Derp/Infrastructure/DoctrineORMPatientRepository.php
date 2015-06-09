<?php

namespace Derp\Infrastructure;

use Derp\Bundle\ERBundle\Entity\Patient;
use Derp\Bundle\ERBundle\Entity\PatientId;
use Derp\Domain\PatientNotFound;
use Derp\Domain\PatientRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Rhumsaa\Uuid\Uuid;

class DoctrineORMPatientRepository implements PatientRepository
{
    /**
     * @var managerregistry
     */
    private $doctrine;

    public function __construct(managerregistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function add(patient $patient)
    {
        $em = $this->doctrine->getmanager();
        $em->persist($patient);
    }


    /**
     * get all patients.
     *
     * @return patient[]
     */
    public function all()
    {
        $patients = $this
            ->doctrine
            ->getmanager()
            ->getrepository(patient::class)
            ->findall();

        return $patients;
    }

    /**
     * @param $lastname
     *
     * @return patient[]
     */
    public function findbylastname($lastname)
    {
        $patients = $this
            ->doctrine
            ->getmanager()
            ->getrepository(patient::class)
            ->findby(
                ['personalinformation.name.lastname' => $lastname]
            );

        return $patients;
    }

    /**
     * @param $id
     *
     * @return patient
     *
     * @throws patientnotfound
     */
    public function byid($id)
    {
        $patient = $this
            ->doctrine
            ->getmanager()
            ->getrepository(patient::class)
            ->find($id);

        if (!$patient) {
            throw new patientnotfound();
        }

        return $patient;
    }

    /**
     * @return PatientId
     */
    public function nextIdentity()
    {
        return PatientId::fromString(Uuid::uuid4()->toString());
    }

}
