<?php
/**
 * Created by PhpStorm.
 * User: ejjak
 * Date: 08/03/17
 * Time: 10:39 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array('placeholder' => 'Your name'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide your name")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Your email address'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide a valid email")),
                    new Email(array("message" => "Your email doesn't seems to be valid")),
                )
            ))
            ->add('phone', TextType::class, array('attr' => array('placeholder' => 'Your phone number'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide you phone no.")),
                )
            ))
            ->add('address', TextType::class, array('attr' => array('placeholder' => 'Your address'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide your address")),
                )
            ))
            ->add('message',TextareaType::class, array('attr' => array('placeholder' => 'Your message here'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide a message here")),
                )
            ))

        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'contact_form';
    }

}