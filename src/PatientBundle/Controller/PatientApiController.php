<?php

namespace PatientBundle\Controller;

use PatientBundle\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PatientApiController extends Controller
{
	/**
     * Lists all patient entities.
     *
     * @Route("/patient/api/list", name="patient_api_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $patients = $em->getRepository('PatientBundle:Patient')->findAll();

        $response=new Response();
        $response->headers->add([
                    'Content-Type'=>'application/json'
        ]);
        $response->setContent(json_encode($patients));
        return $response;
    }

    /**
     * Creates a new patient entity.
     *
     * @Route("/patient/api/new", name="patient_api_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $patient = new Patient();

		$form = $this->createForm(
			'PatientBundle\Form\PatientApiType',
			$patient,
			[
				'csrf_protection' => false
			]
		);
		$form->bind($request);

		$valid = $form->isValid();

		$response = new Response();

		if(false === $valid){
			$response->setStatusCode(400);
			$response->setContent(json_encode($this->getFormErrors($form)));
			return $response;
		}

		if (true === $valid) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($patient);
			$em->flush();
			$response->setContent(json_encode($patient));
		}
		return $response;
	}
	public function getFormErrors($form){
		$errors = [];
		if (0 === $form->count()){
			return $errors;
		}
		foreach ($form->all() as $child) {
			if (!$child->isValid()) {
				$errors[$child->getName()] = (string) $form[$child->getName()]->getErrors();
			}
		}
		return $errors;
    }

    /**
     * Finds and displays a patient entity.
     *
     * @Route("/patient/api/{id}", name="patient_api_show")
     * @Method("GET")
     */
    public function showAction(Patient $patient)
    {
        $deleteForm = $this->createDeleteForm($patient);
        $response = new Response();
        $response->setContent(json_encode($patient));
        return $response;
        

    }

}
