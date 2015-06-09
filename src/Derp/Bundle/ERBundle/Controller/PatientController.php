<?php

namespace Derp\Bundle\ERBundle\Controller;

use Derp\Bundle\ERBundle\Entity\BirthDate;
use Derp\Bundle\ERBundle\Entity\FullName;
use Derp\Bundle\ERBundle\Entity\PersonalInformation;
use Derp\Bundle\ERBundle\Entity\Sex;
use Derp\Bundle\ERBundle\Form\RegisterWalkinType;
use Derp\Bundle\ERBundle\Entity\Patient;
use Derp\Command\RegisterWalkin;
use Derp\Domain\PatientNotFound;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/patients")
 */
class PatientController extends Controller
{
    /**
     * @Route("/", name="patient_list")
     * @Template()
     */
    public function listAction()
    {
        $patients = $this->get('patient_repository')->all();

        return array(
            'patients' => $patients
        );
    }

    /**
     * @Route("/find-by-last-name/", name="patient_find_by_last_name")
     * @Template("@DerpERBundle/Resources/views/Patient/list.html.twig")
     */
    public function findByLastName(Request $request)
    {
        $patients = $this->get('patient_repository')->findByLastName(
            $request->query->get('lastName')
        );

        return array(
            'patients' => $patients
        );
    }

    /**
     * @Route("/create/", name="patient_create")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new RegisterWalkinType());

        $form->handleRequest($request);

        if ($form->isValid()) {
            /* @var $command RegisterWalkin */
            $patientId = $this->get('patient_repository')->nextIdentity();
            $command = $form->getData();
            $command->patientId = $patientId;

            $this->get('command_bus')->handle($command);

            return $this->redirect(
                $this->generateUrl(
                    'patient_details',
                    ['id' => $command->patientId]
                )
            );
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}/", name="patient_details")
     * @Method("GET")
     * @Template()
     */
    public function detailsAction($id)
    {
        try {
            $patient = $this->get('patient_repository')->byId($id);
        }
        catch (PatientNotFound $e) {
            throw $this->createNotFoundException();
        }

        return array(
            'patient' => $patient
        );
    }
}
