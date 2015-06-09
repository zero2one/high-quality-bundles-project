<?php

namespace Derp\Domain;

use Derp\Bundle\ERBundle\Entity\Patient;
use Derp\Bundle\ERBundle\Entity\PatientId;

interface PatientRepository
{
    /**
     * Add a single patient.
     *
     * @param Patient $patient
     *
     * @return mixed
     */
    public function add(Patient $patient);

    /**
     * Get all patients.
     *
     * @return Patient[]
     */
    public function all();

    /**
     * @param $lastName
     *
     * @return Patient[]
     */
    public function findByLastName($lastName);

    /**
     * @param $id
     *
     * @return Patient
     *
     * @throws PatientNotFound
     */
    public function byId($id);

    /**
     * @return PatientId
     */
    public function nextIdentity();
}