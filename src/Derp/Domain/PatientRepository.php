<?php

namespace Derp\Domain;

use Derp\Bundle\ERBundle\Entity\Patient;

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
}