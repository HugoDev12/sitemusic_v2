<?php

namespace App\Form;

use App\Entity\Advertisement;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertisementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $musicians = json_decode(file_get_contents("datas/musicians.json"));
        $musicianList = [];
        foreach ($musicians as $musician) {
           $musicianList[$musician] = $musician;
        }
        $group = ["un groupe" => "Groupe"];
        $lookingForList = $group + $musicianList;

        $citiesList = unserialize(file_get_contents("datas/cities.txt"));
        
        // dd($citiesList2);

        // file_put_contents("datas/cities.php", serialize($citiesList));

        // dd($citiesList);

        $builder
            ->add('title', TextType::class, [
                "label" => "Titre :"
            ])
            // ->add('lookingFor', TextType::class, [
            //     'attr' => ["autocomplete" => "off"],
            //     "label" => "Je cherche :"
            // ])
            ->add('lookingFor', ChoiceType::class, [
                'attr' => ["autocomplete" => "off"],
                "label" => "Je cherche :",
                "choices" => $lookingForList

            ])
            ->add('city', TextType::class, [
                'attr' => ["autocomplete" => "off"],
                "label" => "Ville :",
                // "row_attr" => [
                //     "class" => "autoCompleteInput"
                // ]
            ])
            // ->add('city', ChoiceType::class, [
            //     'attr' => ["autocomplete" => "off"],
            //     "label" => "Ville :",
            //     "choices" => $citiesList

            // ])
            ->add('description', TextAreaType::class, [
                "label" => "Description :"
            ])
            // ->add('date')
            // ->add('status')
            // ->add('user')
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                // 'attr' => ['class' => 'col-4 btn btn-dark'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advertisement::class,
        ]);
    }
}
