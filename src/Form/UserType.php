<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        // $user = $this->getUser();

        $builder
            ->add('email', EmailType::class, [
                "label" => "Email :"
            ])
            // ->add('roles')
            // ->add('password', PasswordType::class, [
            //     "label" => "Mot de passe :",
            // ])
            ->add('pseudo', TextType::class, [
                "label" => "Pseudo :"
            ])
            ->add('isAlone', ChoiceType::class, [
              
                    // "Un musicien seul",
                    // "Un groupe"
                "choices"=> [
                    "Un musicien" => true,
                    "Un groupe" => false
                ],
                "label"=> "Je suis :",
                // "mapped"=>false
            ])

            ->add('instrument', TextType::class, [
                "label" => "Instrument :",
                "required"=>false,
                "row_attr" => [
                    "class" => "autoCompleteInput"
                ]
            ])
            ->add('city', TextType::class, [
                "label" => "Ville :",
                "required"=>false,
                "row_attr" => [
                    "class" => "autoCompleteInput"
                ]
            ])
            ->add('style_music', TextType::class, [
                "label" => "Style de musique :",
                "required"=>false
            ])
            // ->add('book')
            ->add('avatar', FileType::class,  [
                "label" => "Changer mon avatar : ",
                "mapped" => false,
                "required" => false,
                "constraints" => [new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => ['image/png', 'image/jpeg'],
                    'mimeTypesMessage' => 'Veuillez choisir une image au format jpeg ou png',])],
                ])
            // ->add('date')
            // ->add('last_login')
            ->add('level', ChoiceType::class, [
                "label" => "Niveau :",
                "required"=>false,
                "choices"=> [
                    "Débutant" => "Débutant",
                    "Intermédiaire" => "Intermédiaire",
                    "Avancé" => "Avancé",
                    "Professionnel" => "Pro"
                ]
            ])
            // ->add('status')
            ->add('description', TextAreaType::class, [
                "label" => "Description :",
                "required"=>false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                // 'attr' => ['class' => 'col-4 btn btn-dark'],
            ]);
            // ->add('googleId')
        ;

       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
