<?php

namespace Derp\Bundle\ERBundle\Controller;

use Derp\Command\RegisterWalkin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class PatientRestController
 *
 * @package Derp\Bundle\ERBundle\Controller
 *
 * @Route("/api/patients/")
 */
class PatientRestController extends Controller
{
    /**
     * @Route("/walk-in/")
     * @Method("post")
     */
    public function registerAction(Request $request)
    {
        // Use the serializer to save lines of code, not save CPU time ;-).
        $command = $this
            ->get('jms_serializer')
            ->deserialize(
                $request->getContent(),
                RegisterWalkin::class, 'json'
            );

        $this->get('command_bus')->handle($command);

        return new Response(null, Response::HTTP_CREATED);
    }
}

// REST layout.
<<<EOD
{
    "firstName": "",
    "lastName": "",
    "birthDate": "",
    "sex": "",
    "indication": "",
}
EOD;
