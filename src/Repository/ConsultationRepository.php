<?php

namespace App\Repository;

use App\Entity\Consultation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consultation>
 */
class ConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

    //    /**
    //     * @return Consultation[] Returns an array of Consultation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Consultation
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
            public function findByExampleField(User $medecin)
            {
                return $this->createQueryBuilder('c')
                    ->join('c.patient', 'p')
                    ->addSelect('p')
                    ->where('c.medecin = :medecin')
                    ->setParameter('medecin', $medecin)
                    ->groupBy('p.id')
                    ->getQuery()
                    ->getResult();
            }

           public function rechercheconsultation(?string $filtre)
            {
                $qb = $this->createQueryBuilder('c')
                    ->innerJoin('c.patient', 'p')
                    ->addSelect('p');

                if ($filtre) {
                    $qb->andWhere(
                        $qb->expr()->orX(
                            'LOWER(p.nom) LIKE :filtre',
                            'LOWER(p.prenom) LIKE :filtre',
                            'p.ssn LIKE :filtre'
                        )
                    )
                    ->setParameter('filtre', '%' . strtolower($filtre) . '%');
                }
                return $qb->getQuery();
            }

           public function recherchepatient(User $medecin, ?string $filtre2)
            {
                $qb = $this->createQueryBuilder('c')
                    ->join('c.patient', 'p')
                    ->addSelect('p')
                    ->where('c.medecin = :medecin')
                    ->setParameter('medecin', $medecin)
                    ->groupBy('p.id'); 

                if ($filtre2) {
                    $qb->andWhere(
                        $qb->expr()->orX(
                            'LOWER(p.nom) LIKE :filtre2',
                            'LOWER(p.prenom) LIKE :filtre2',
                            'p.ssn LIKE :filtre2'
                        )
                    )
                    ->setParameter('filtre2', '%' . strtolower($filtre2) . '%');
                }

                return $qb->getQuery()->getResult(); 
            }
}


