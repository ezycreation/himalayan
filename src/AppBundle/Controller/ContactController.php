<?php
/**
 * Created by PhpStorm.
 * User: ejjak
 * Date: 09/10/17
 * Time: 10:40 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact_form")
     *
     */
    public function contactAction(Request $request)
    {
        // Create the form according to the FormType created previously.
        // And give the proper parameters
        $form = $this->createForm('AppBundle\Form\ContactType',null,array(
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('contact_form'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);

            if($form->isValid()){
                // Send mail
                if($this->sendEmail($form->getData())){

                    $request->getSession()
                        ->getFlashBag()
                        ->add('success', 'Message has been sent successfully, we will get back to you as soon as possible. Thank you!');
                    // Everything OK, redirect to wherever you want ! :

//                    return $this->redirectToRoute('redirect_to_somewhere_now');
                }else{
                    // An error ocurred, handle
                    var_dump("Errooooor :(");
                }
            }
        }

        return $this->render(':page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function sendEmail($data){
        $myappContactMail = 'teavillagecottage@gmail.com';
        $myappContactPassword = 'qjtpxgdtgvitbbtj';

        // In this case we'll use the ZOHO mail services.
        // If your service is another, then read the following article to know which smpt code to use and which port
        // http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("Himalayan Milestone Tours & Travels Enquiry")
            ->setFrom(array($data["email"] => $data["name"]))
            ->setTo(array(
                'ezycreation@gmail.com' => 'ezycreation',
                'himalayanmilestonesikkim' => 'himalayan'
            ))
            ->setBody(
                "Name: ".$data["name"].
                "<br><b>Email id.: </b>".$data["email"].
                "<br><b>Phone no.: </b>".$data["phone"].
                "<br><b>Address: </b>".$data["address"].
                "<br><b>Message: </b>".$data["message"]
                ,'text/html');


        return $mailer->send($message);
    }

}