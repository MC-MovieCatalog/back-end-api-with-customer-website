<?php

namespace App\Form;

use App\Entity\AgreeTerms;
use App\Entity\User;
use App\Form\FormConfig\FormConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, $this->getFormConf(false, false, false, [
                'attr' => array(
                    'placeholder' => 'Votre adresse email',
                    'class' => 'form-control mb-0'
                )
            ]))
            ->add('lastName', TextType::class, $this->getFormConf(false, false, false, [
                'attr' => array(
                    'placeholder' => 'Votre nom',
                    'class' => 'form-control mb-0'
                )
            ]))
            ->add('firstName', TextType::class, $this->getFormConf(false, false, false, [
                'attr' => array(
                    'placeholder' => 'Votre prénom',
                    'class' => 'form-control mb-0'
                )
            ]))
            ->add('agreeTerms', CheckboxType::class, [
                'label'    => 'J\'accepte les termes et les conditions générales d\'utilisation.',
                'data' => false,
                'label_attr' => ['class' => 'checkbox-custom'],
                'required' => false,
            ])
            ->add('plainPassword', PasswordType::class, $this->getFormConf(false, false, false, [
                'attr' => array(
                    'placeholder' => 'Votre mot de passe',
                    'class' => 'form-control mb-0'
                )
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
