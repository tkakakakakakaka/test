<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('age')
            ->add('description')
            ->add('date')
            ->add('patient', EntityType::class, [
                'class' => User::class,
                'choice_label' => fn(User $user) => $user->getPrenom(),
                'placeholder' => 'choisir un patient',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->where('u.roles LIKE :role')
                    ->setParameter('role', '%ROLE_PATIENT%');
                },
            ])
            ->add('medecin', EntityType::class, [
                'class' => User::class,
                'choice_label' => fn(User $user) => $user->getPrenom(),
                'placeholder' => 'choisir un medecin',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->where('u.roles LIKE :role')
                    ->setParameter('role', '%ROLE_MEDECIN%');
                },
            ]); 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
