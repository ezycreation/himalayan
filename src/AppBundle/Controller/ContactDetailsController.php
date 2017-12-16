<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ContactDetails;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Contactdetail controller.
 *
 * @Route("contactdetails")
 */
class ContactDetailsController extends Controller
{
    /**
     * Lists all contactDetail entities.
     *
     * @Route("/", name="contactdetails_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contactDetails = $em->getRepository('AppBundle:ContactDetails')->findAll();

        return $this->render('contactdetails/index.html.twig', array(
            'contactDetails' => $contactDetails,
        ));
    }

    /**
     * Creates a new contactDetail entity.
     *
     * @Route("/new", name="contactdetails_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $contactDetail = new ContactDetails();
        $form = $this->createForm('AppBundle\Form\ContactDetailsType', $contactDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactDetail);
            $em->flush();

            return $this->redirectToRoute('contactdetails_show', array('id' => $contactDetail->getId()));
        }

        return $this->render('contactdetails/new.html.twig', array(
            'contactDetail' => $contactDetail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a contactDetail entity.
     *
     * @Route("/{id}", name="contactdetails_show")
     * @Method("GET")
     */
    public function showAction(ContactDetails $contactDetail)
    {
        $deleteForm = $this->createDeleteForm($contactDetail);

        return $this->render('contactdetails/show.html.twig', array(
            'contactDetail' => $contactDetail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing contactDetail entity.
     *
     * @Route("/{id}/edit", name="contactdetails_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ContactDetails $contactDetail)
    {
        $deleteForm = $this->createDeleteForm($contactDetail);
        $editForm = $this->createForm('AppBundle\Form\ContactDetailsType', $contactDetail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Page has been successfully updated !');
            return $this->redirectToRoute('contactdetails_edit', array('id' => $contactDetail->getId()));
        }

        return $this->render('contactdetails/edit.html.twig', array(
            'contactDetail' => $contactDetail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a contactDetail entity.
     *
     * @Route("/{id}", name="contactdetails_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ContactDetails $contactDetail)
    {
        $form = $this->createDeleteForm($contactDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contactDetail);
            $em->flush();
        }

        return $this->redirectToRoute('contactdetails_index');
    }

    /**
     * Creates a form to delete a contactDetail entity.
     *
     * @param ContactDetails $contactDetail The contactDetail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ContactDetails $contactDetail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contactdetails_delete', array('id' => $contactDetail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
