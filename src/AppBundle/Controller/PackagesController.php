<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Packages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * Package controller.
 *
 * @Route("packages")
 */
class PackagesController extends Controller
{
    /**
     * Lists all package entities.
     *
     * @Route("/", name="packages_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $packages = $em->getRepository('AppBundle:Packages')->findAll();

        return $this->render('packages/index.html.twig', array(
            'packages' => $packages,
        ));
    }

    /**
     * Creates a new package entity.
     *
     * @Route("/new", name="packages_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $package = new Packages();
        $form = $this->createForm('AppBundle\Form\PackagesType', $package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $package->getImageurl();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('directory'),
                $fileName
            );
            $package->setImageurl($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($package);
            $em->flush();

            return $this->redirectToRoute('packages_show', array('id' => $package->getId()));
        }

        return $this->render('packages/new.html.twig', array(
            'package' => $package,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a package entity.
     *
     * @Route("/{id}", name="packages_show")
     * @Method("GET")
     */
    public function showAction(Packages $package)
    {
        $deleteForm = $this->createDeleteForm($package);

        return $this->render('packages/show.html.twig', array(
            'package' => $package,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing package entity.
     *
     * @Route("/{id}/edit", name="packages_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Packages $package)
    {
        $fileName=$package->getImageurl();
        $deleteForm = $this->createDeleteForm($package);
        $package->setImageurl(
            new File($this->getParameter('directory').'/'.$package->getImageurl())
        );
        $editForm = $this->createForm('AppBundle\Form\PackagesType', $package);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $package->getImageurl();
            if ($file)
            {
                $file_path='images/uploads/'.$fileName;
                unlink($file_path);
                $fileName1 = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('directory'),
                    $fileName1
                );
                $package->setImageurl($fileName1);

            }
            else
            {
                $package->setImageurl($fileName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($package);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Page has been successfully updated !');
            return $this->redirectToRoute('packages_edit', array('id' => $package->getId()));
        }

        return $this->render('packages/edit.html.twig', array(
            'package' => $package,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a package entity.
     *
     * @Route("/{id}", name="packages_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Packages $package)
    {
        $form = $this->createDeleteForm($package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($package);
            $em->flush();
        }

        return $this->redirectToRoute('packages_index');
    }

    /**
     * Creates a form to delete a package entity.
     *
     * @param Packages $package The package entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Packages $package)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('packages_delete', array('id' => $package->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
