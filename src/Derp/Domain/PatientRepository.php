<?php

namespace Derp\Domain;

use Derp\Bundle\ERBundle\Entity\Patient;

interface PatientRepository
{
    public function add(Patient $patient);
}