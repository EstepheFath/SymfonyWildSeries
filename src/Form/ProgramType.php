<?php

namespace App\Form;

use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Actor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class);
        $builder
            ->add('synopsis', TextType::class);
        $builder
            ->add('poster', TextType::class);

        $builder->add('actors', EntityType::class, [
            'class' => Actor::class,
            'choice_label' => 'name',
            'multiple' => true,
            'expanded' => true,
        ]);



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
