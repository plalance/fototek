<?php

namespace SiteBundle\Form;

use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityRepository;
use SiteBundle\Entity\Auteur;
use SiteBundle\Repository\AppareilRepository;
use SiteBundle\Repository\ObjectifRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $autor = $options['autor'];
//        $this->autor = $options['autor'];

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
            ->add('appareil', EntityType::class, array(
                'label' => 'Choisissez votre appareil',
                'class' => 'SiteBundle:Appareil',
                'attr' => ['class' => 'material-select'],
                'query_builder' => function(AppareilRepository $ar) use ($autor){
                    return $ar->getAllByAutor($autor);
                },
                'choice_label' => 'libelle',
                 'multiple' => false,
            ))

            ->add('objectif', EntityType::class, array(
                'label' => 'Choisissez votre objectif',
                'class' => 'SiteBundle:Objectif',
                'attr' => ['class' => 'material-select'],
                'query_builder' => function(ObjectifRepository $or) use ($autor){
                    return $or->getAllByAutor($autor);
                },
                'choice_label' => 'libelle',
                'multiple' => false,
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'autor' => new Auteur(),
        ]);

        $resolver->setRequired('autor'); // Requires that currentOrg be set by the caller.
        $resolver->setAllowedTypes('autor', 'SiteBundle\Entity\Auteur'); // Validates the type(s) of option(s) passed.
    }

}