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

        return $this->render('patient/index.html.twig', array(
            'patients' => $patients,
        ));
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

        return $this->render('patient/show.html.twig', array(
            'patient' => $patient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing patient entity.
     *
     * @Route("/patient/api/{id}/edit", name="patient_api_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Patient $patient)
    {
        $deleteForm = $this->createDeleteForm($patient);
        $editForm = $this->createForm('PatientBundle\Form\PatientType', $patient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('patient_edit', array('id' => $patient->getId()));
        }

        return $this->render('patient/edit.html.twig', array(
            'patient' => $patient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a patient entity.
     *
     * @Route("/patient/api/{id}", name="patient_api_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Patient $patient)
    {
        $form = $this->createDeleteForm($patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($patient);
            $em->flush();
        }

        return $this->redirectToRoute('patient_index');
    }

    /**
     * Creates a form to delete a patient entity.
     *
     * @param Patient $patient The patient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Patient $patient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('patient_delete', array('id' => $patient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
