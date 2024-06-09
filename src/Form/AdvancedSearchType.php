<?php

namespace App\Form;

// use App\Entity\Advertisement;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvancedSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isAlone', ChoiceType::class, [
                'choices' => [
                    'Musicien et Groupe' => "Tous",
                    'Musicien' => true,
                    'Groupe' => false
                ],
                "attr"=> ['class'=> "search-input"]
            ])
            ->add('city', TextType::class, [
                'label'=> false,
                'required'=>false,
                'attr'=>[
                    "autocomplete"=>"off",
                    "placeholder"=>"Ville",
                    'class'=> "search-input"
                ],
                "row_attr" => [
                    "class" => "autoCompleteInput"
                ]
            ])
            ->add('pseudo', TextType::class, [
                'label'=> false,
                'required'=>false,
                'attr'=>[
                    "autocomplete"=>"off",
                    "placeholder"=>"Pseudo",
                    'class'=> "search-input"
                ],
            ])
            ->add('lookingFor', TextType::class, [
                'label'=> false,
                'required'=>false,
                'attr'=>[
                    "autocomplete"=>"off",
                    "placeholder"=>"Instrument",
                    'class'=> "search-input"
                ],
                "row_attr" => [
                    "class" => "autoCompleteInput"
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'submit-search'],
                'row_attr' => ['class'=>'d-flex justify-content-end']
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Advertisement::class,
            'attr'=>["id" => 'search-form']
        ]);
    }
}