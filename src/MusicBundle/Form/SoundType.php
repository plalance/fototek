<?php

namespace MusicBundle\Form;

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

class SoundType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array(
                'label' => 'Sauvegarder',
                'attr' => ['class' => 'btn waves-effect waves-light'],
            ));
    }
}