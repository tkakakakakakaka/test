<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Traitement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;




class TraitementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medicament')
            ->add('quantite')
            ->add('contenant', ChoiceType::class,[
                'choices' => [
                    'boite' => 'boite',
                    'tube' => 'tube',
                    'pilulier' => 'pilulier',
                    'flacons' => 'flacons',
                ]
            ])
            ->add('duree')
            ->add('dose')
            ->add('frequence') 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Traitement::class,
        ]);
    }
}
