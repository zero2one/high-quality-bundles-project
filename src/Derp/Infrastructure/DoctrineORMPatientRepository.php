<?php

namespace Derp\Infrastructure;

use Derp\Bundle\ERBundle\Entity\Patient;
use Derp\Domain\PatientRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
     * Get all patients.
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
}