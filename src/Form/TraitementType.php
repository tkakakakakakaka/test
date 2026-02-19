<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Traitement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TraitementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medicament')
            ->add('quantite')
            ->add('contenant')
            ->add('duree')
            ->add('dose')
            ->add('frequence')
            ->add('consultation', EntityType::class, [
                'class' => Consultation::class,
                'choice_label' => 'id',
                'mapped' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Traitement::class,
        ]);
    }
}
