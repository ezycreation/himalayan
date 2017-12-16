<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Destination;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * Destination controller.
 *
 * @Route("destination")
 */
class DestinationController extends Controller
{
    /**
     * Lists all destination entities.
     *
     * @Route("/", name="destination_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $destinations = $em->getRepository('AppBundle:Destination')->findAll();

        return $this->render('destination/index.html.twig', array(
            'destinations' => $destinations,
        ));
    }

    /**
     * Creates a new destination entity.
     *
     * @Route("/new", name="destination_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $destination = new Destination();
        $form = $this->createForm('AppBundle\Form\DestinationType', $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $destination->getImageurl();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('destination'),
                $fileName
            );
            $destination->setImageurl($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($destination);
            $em->flush();

            return $this->redirectToRoute('destination_show', array('id' => $destination->getId()));
        }

        return $this->render('destination/new.html.twig', array(
            'destination' => $destination,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a destination entity.
     *
     * @Route("/{id}", name="destination_show")
     * @Method("GET")
     */
    public function showAction(Destination $destination)
    {
        $deleteForm = $this->createDeleteForm($destination);

        return $this->render('destination/show.html.twig', array(
            'destination' => $destination,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing destination entity.
     *
     * @Route("/{id}/edit", name="destination_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Destination $destination)
    {
        $fileName=$destination->getImageurl();
        $deleteForm = $this->createDeleteForm($destination);
        $destination->setImageurl(
            new File($this->getParameter('destination').'/'.$destination->getImageurl())
        );
        $editForm = $this->createForm('AppBundle\Form\DestinationType', $destination);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $destination->getImageurl();
            if ($file)
            {
                $file_path='images/destination/'.$fileName;
                unlink($file_path);
                $fileName1 = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('destination'),
                    $fileName1
                );
                $destination->setImageurl($fileName1);

            }
            else
            {
                $destination->setImageurl($fileName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($destination);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Page has been successfully updated !');
            return $this->redirectToRoute('destination_edit', array('id' => $destination->getId()));
        }

        return $this->render('destination/edit.html.twig', array(
            'destination' => $destination,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a destination entity.
     *
     * @Route("/{id}", name="destination_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Destination $destination)
    {
        $form = $this->createDeleteForm($destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($destination);
            $em->flush();
        }

        return $this->redirectToRoute('destination_index');
    }

    /**
     * Creates a form to delete a destination entity.
     *
     * @param Destination $destination The destination entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Destination $destination)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('destination_delete', array('id' => $destination->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
