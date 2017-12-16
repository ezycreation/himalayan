<?php
/**
 * Created by PhpStorm.
 * User: Demi
 * Date: 06-Oct-17
 * Time: 11:45 AM
 */
namespace AppBundle\Controller;
use AppBundle\Entity\Adventure;
use AppBundle\Entity\ContactDetails;
use AppBundle\Entity\Destination;
use AppBundle\Entity\Gallery;
use AppBundle\Entity\Images;
use AppBundle\Entity\Packages;
use AppBundle\Entity\Pages;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render(':page:index.html.twig');
    }

    /**
     *  @Route("admin", name="admin")
     */
    public function adminAction()
    {
        return $this->render('::admin.html.twig');
    }

//    /**
//     * @Route("page", name="page")
//     */
//    public function  PageAction()
//    {
//        return $this->render(':page:page.html.twig');
//    }

    /**
     * @Route("page/adventure/{id}", name="adventure")
     */
    public function AdventureAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $view = $em->getRepository('AppBundle:Adventure')->find($id);

        if($view instanceof Adventure){
            $title = $view->getTitle();
            $description = $view->getDescription();
            $image = $view->getImageurl();
        }

        return $this->render(':page:adventure.html.twig', array(
            'title' => $title,
            'description' => $description,
            'image' => $image
        ));

    }

    public function AdventureListAction(){
        $em = $this->getDoctrine()->getManager();
        $detail= array();
        $view = $em->getRepository('AppBundle:Adventure')->findAll();
        foreach($view as $value)
        {
            if ($value instanceof Adventure) {
                $title = $value->getTitle();
                $id = $value->getId();
                $detail[] = array('title' =>$title,'id' => $id);
            }
        }
        return $this->render(':adventure:links.html.twig', array(
            'detail' => $detail
        ));
    }

    /**
     * @Route("page/destination/{id}", name="destination")
     */
    public function DestinationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $view = $em->getRepository('AppBundle:Destination')->find($id);

        if($view instanceof Destination){
            $title = $view->getTitle();
            $description = $view->getDescription();
            $image = $view->getImageurl();
        }

        return $this->render(':page:destination.html.twig', array(
            'title' => $title,
            'description' => $description,
            'image' => $image
        ));

    }

    public function DestinationListAction(){
        $em = $this->getDoctrine()->getManager();
        $detail= array();
        $view = $em->getRepository('AppBundle:Destination')->findAll();
        foreach($view as $value)
        {
            if ($value instanceof Destination) {
                $title = $value->getTitle();
                $id = $value->getId();
                $detail[] = array('title' =>$title,'id' => $id);
            }
        }
        return $this->render(':page:links.html.twig', array(
            'detail' => $detail
        ));
    }

    public function DestinationHomeAction(){
        $em = $this->getDoctrine()->getManager();
        $detail= array();
        $view = $em->getRepository('AppBundle:Destination')->findAll();
        foreach($view as $value)
        {
            if ($value instanceof Destination) {
                $image = $value->getImageurl();
                $description = $value->getDescription();
                $title = $value->getTitle();
                $id = $value->getId();
                $detail[] = array('title' =>$title,'image'=>$image,'description'=>$description,'id' => $id);
            }
        }
        return $this->render(':page:featured-destination.html.twig', array(
            'detail' => $detail
        ));
    }
    /**
     * @Route("page/{id}", name="pages")
     */
    public function PagesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $view = $em->getRepository('AppBundle:Pages')->find($id);

        if($view instanceof Pages){
            $title = $view->getTitle();
            $description = $view->getDescription();
        }

        return $this->render(':page:page.html.twig', array(
            'title' => $title,
            'description' => $description
        ));

    }

    /**
     * @Route("home-about", name="home_about")
     */
    public function HomeAboutAction(){
        $em = $this->getDoctrine()->getManager();
        $detail = $em->getRepository('AppBundle:Pages')->findHomeAboutUsAction();
        $about ='';
        foreach($detail as $val){
           if($val instanceof Pages){
               $about = $val->getDescription();
           }
        }
//        dump($about);die;
        return $this->render(':pages:hom-about.html.twig', array(
            'about' => $about
        ));
    }

    public function PagesListAction(){
        $em = $this->getDoctrine()->getManager();
        $detail= array();
        $view = $em->getRepository('AppBundle:Pages')->findAll();
        foreach($view as $value)
        {
            if ($value instanceof Pages) {
                $title = $value->getTitle();
                $id = $value->getId();
                $detail[] = array('title' =>$title,'id' => $id);
            }
        }
        return $this->render(':pages:links.html.twig', array(
            'detail' => $detail
        ));
    }

    /**
     * @Route("/tour-package/{destination}", name="packages")
     * @Method("GET")
     */
    public function PackagesAction($destination)
    {
        $em = $this->getDoctrine()->getManager();
        $packages = $em->getRepository('AppBundle:Packages')->findpackagebydestinationAction($destination);
        $response = array();
        foreach($packages as $row)
        {
            if($row instanceof Packages) {
                $response[] = array(
                    'location' => $row->getLocation(),
                    'id' => $row->getId(),
                    'title' => $row->getTitle(),
                    'description' => $row->getDescription(),
                    'image' => $row->getImageurl()
                );
            }
        }
        return $this->render(':page:packages.html.twig', array(
            'res' => $response
        ));
    }

    /**
     * @Route("tour-packages/{id}", name="tour_packages")
     */
    public function TourPackageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $view = $em->getRepository('AppBundle:Packages')->find($id);

        if($view instanceof Packages){
            $title = $view->getTitle();
            $description = $view->getDescription();
        }

        return $this->render(':page:packages-page.html.twig', array(
            'title' => $title,
            'description' => $description
        ));

    }

    /**
     * @Route("photo-gallery", name="photo_gallery")
     */
    public function GalleryShowAction()
    {

        $em = $this->getDoctrine()->getManager();
        $response = array();
        $gallery = $em->getRepository('AppBundle:Gallery')->findAll();

        foreach($gallery as $value)
        {
            if($value instanceof  Gallery)
            {
                $imageDetail= $value->getImage();
                $detail = array();
                foreach ($imageDetail as $val) {
                    if ($val instanceof Images) {
                        $detail[] = $val->getPath();
                    }
                }
                $response[] = array('title' => $value->getTitleName(),'images' => $detail);
            }
        }
//      dump($response);die;
        return $this->render('page/gallery.html.twig', array(
            'response'      => $response
        ));
    }

    /**
     * @Route("contact-address", name="contact_address")
     */
    public function ContactAddressAction()
    {
        $em = $this->getDoctrine()->getManager();
        $detail = $em->getRepository('AppBundle:ContactDetails')->findContactAction();
        $address ='';
        foreach($detail as $val){
            if($val instanceof ContactDetails){
                $address = $val->getAddress();
            }
        }
//        dump($about);die;
        return $this->render(':contactdetails:address.html.twig', array(
            'address' => $address
        ));
    }

    /**
     * @Route("contact-phone", name="contact_phone")
     */
    public function ContactPhoneAction()
    {
        $em = $this->getDoctrine()->getManager();
        $detail = $em->getRepository('AppBundle:ContactDetails')->findContactAction();
        $phone ='';
        foreach($detail as $val){
            if($val instanceof ContactDetails){
                $phone = $val->getPhone();
            }
        }
//        dump($about);die;
        return $this->render(':contactdetails:phone.html.twig', array(
            'phone' => $phone
        ));
    }

    /**
     * @Route("contact-email", name="contact_email")
     */
    public function ContactEmailAction()
    {
        $em = $this->getDoctrine()->getManager();
        $detail = $em->getRepository('AppBundle:ContactDetails')->findContactAction();
        $email ='';
        foreach($detail as $val){
            if($val instanceof ContactDetails){
                $email = $val->getEmail();
            }
        }
//        dump($about);die;
        return $this->render(':contactdetails:email.html.twig', array(
            'email' => $email
        ));
    }
}