<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entryName', TextType::class, [
                'label'=>'Name',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[
                    'placeholder'=>'Your Name'
                ],
                'required'=>true,
                'row_attr'=>[
                    'class'=>'input_container'
                ]
            ])
            ->add('entryEmail', EmailType::class, [
                'label'=>'Email',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[
                    'placeholder'=>'Email'
                ],
                'required'=>true,
                'row_attr'=>[
                    'class'=>'input_container'
                ]
            ])
            ->add('title', TextType::class, [
                'label'=>'Recipe Title',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[
                    'placeholder'=>'Recipe Title'
                ],
                'required'=>true,
                'row_attr'=>[
                    'class'=>'input_container'
                ]
            ])
            ->add('mainImage', FileType::class, [
                'label'=>'Recipe Image',
                'label_attr'=>[
                    'class'=>'label_file'
                ],
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize'=>'2M',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage'=>'File must be JPEG or PNG'
                    ])
                ],
                'help'=>'<img id="recipe_image_preview" src="">',
                'help_html'=>true
            ])
            ->add('description', CKEditorType::class, [
                'label'=>'Recipe Description',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[
                    'placeholder'=>'Recipe Description'
                ],
                'required'=>true,
                'config'=>[
                    'toolbar'=>[
                        [
                            'name'=>'basicstyles',
                            'items'=>['Bold', 'Italic', '-', 'RemoveFormat']
                        ],
                        [
                            'name'=>'paragraph',
                            'items'=>['NumberedList', 'BulletedList']
                        ]
                    ]
                ]
            ])
            ->add('voterAge', CheckboxType::class, [
                'help'=>'<b>I AM AT LEAST 18 YEARS OLD (required)</b>',
                'help_html'=>true,
                'label'=>'I am at least 18 years old',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[
                    
                ],
                'mapped'=>false,
                'required'=>true,
                'row_attr'=>[
                    'class'=>'checkbox_row'
                ]
            ])
            ->add('entryOptIn', CheckboxType::class, [
                'help'=>'<b>Yes!</b> I\'d like to receive emails from Steak-umm.',
                'help_html'=>true,
                'label'=>'Opt-in to the Steak-umm email list',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[

                ],
                'required'=>false,
                'row_attr'=>[
                    'class'=>'checkbox_row'
                ]
            ])
            ->add('voterAcceptRules', CheckboxType::class, [
                'help'=>'I understand and agree to these <a href="/rules" target="_blank">Official Rules</a> and <a href="/privacy" target="_blank">Privacy Policy</a>.',
                'help_html'=>true,
                'label'=>'Agree to rules and privacy policy',
                'label_attr'=>[
                    'class'=>'label_hidden'
                ],
                'attr'=>[
                    
                ],
                'mapped'=>false,
                'required'=>true,
                'row_attr'=>[
                    'class'=>'checkbox_row'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Submit'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
