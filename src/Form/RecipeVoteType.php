<?php

namespace App\Form;

use App\Entity\RecipeVote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeVoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('voterName', TextType::class, [
                'label'=>'Name',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[
                    'placeholder'=>'Name',
                    'required'=>true,
                ],
                'row_attr'=>[
                    'class'=>'input_container'
                ]
            ])
            ->add('voterEmail', EmailType::class, [
                'label'=>'Email',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[
                    'placeholder'=>'Email',
                    'required'=>true,
                ],
                'row_attr'=>[
                    'class'=>'input_container'
                ]
            ])
            ->add('voterOptIn', CheckboxType::class, [
                'help'=>'<b>Yes!</b> I\'d like to receive emails from Steak-umm.',
                'help_html'=>true,
                'label'=>'Opt-in to the Steak-umm email list',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[

                ],
                'required'=>false
            ])
            ->add('voterAcceptRules', CheckboxType::class, [
                'help'=>'I understand and agree to these <a href="/rules" target="_blank">Official Rules</a> and <a href="/privacy" target="_blank">Privacy Policy</a>.',
                'help_html'=>true,
                'label'=>'Agree to rules and privacy policy',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[
                    'required'=>true
                ],
                'mapped'=>false
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Vote'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RecipeVote::class,
        ]);
    }
}
