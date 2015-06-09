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
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function add(Patient $patient)
    {
        $em = $this->doctrine->getManager();
        $em->persist($patient);
    }


    /**
     * get all patients.
     *
     * @return Patient[]
     */
    public function all()
    {
        $patients = $this
            ->doctrine
            ->getManager()
            ->getRepository(Patient::class)
            ->findAll();

        return $patients;
    }

    /**
     * @param $lastName
     *
     * @return Patient[]
     */
    public function FindByLastname($lastName)
    {
        $patients = $this
            ->doctrine
            ->getManager()
            ->getRepository(Patient::class)
            ->findBy(
                ['personalInformation.name.lastName' => $lastName]
            );

        return $patients;
    }

    /**
     * @param PatientId $id
     *
     * @return Patient
     *
     * @throws PatientNotFound
     */
    public function byId(PatientId $id)
    {
        $patient = $this
            ->doctrine
            ->getManager()
            ->getRepository(Patient::class)
            ->find($id);

        if (!$patient) {
            throw new PatientNotFound();
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
