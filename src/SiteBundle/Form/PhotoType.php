<?php

namespace SiteBundle\Form;

use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fichier', FileType::class)
            ->add('titre', TextType::class)
            ->add('description', TextType::class)
            ->add('statut', ChoiceType::class, array(
                'attr' => ['class' => 'material-select'],
                'choices' => array(
                    'Privée' => true,
                    'Publique' => false,
                    'Brouillon' => false,
                ),
                'choice_label' => function ($value, $key, $index) {
                    if ($value == true) {
                        return 'Privée';
                    }
                    return strtoupper($key);
                },
            ))

            ->add('appareil', ChoiceType::class, array(
                'attr' => ['class' => 'material-select'],
                'choices' => array(
                    'EOS 700D' => true,
                    'EOS 5D MARK II' => false,
                    'Nikon 5500D' => false,
                )
            ))
            ->add('objectif', ChoiceType::class, array(
                'attr' => ['class' => 'material-select'],
                'choices' => array(
                    'Canon 70-200 f.8L IS USM' => true,
                    'Leica 50mm f1.2' => false
                )
            ))

            ->add('date', DateType::class, array(
                'label' => 'Date de la photo',
                'widget' => 'single_text',
                'html5' => true,
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Sauvegarder',
                'attr' => ['class' => 'btn waves-effect waves-light'],
            ));
    }
}