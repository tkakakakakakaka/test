<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\Traitement;
use App\Form\TraitementType;
use App\Repository\TraitementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;


#[Route('/')]
final class TraitementController extends AbstractController
{
    #[Route('/consults/{id}/traitements', name: 'app_traitement_index', methods: ['GET'])]
    public function index(Consultation $consultation): Response
    {
        return $this->render('traitement/index.html.twig', [
        'consultation' => $consultation,
        'traitements' => $consultation->getTraitements(),//ajout
    ]);
}
    

    #[Route('/consults/{id}/new', name: 'app_traitement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Consultation $consultation, EntityManagerInterface $entityManager): Response
    {
        $traitement = new Traitement();
        $traitement->setConsultation($consultation);//ajout
        $form = $this->createForm(TraitementType::class, $traitement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($traitement);
            $entityManager->flush();

            return $this->redirectToRoute('app_traitement_index', ['id' => $consultation->getId()]);//ajout
        }

        return $this->render('traitement/new.html.twig', [
            'traitement' => $traitement,
            'consultation' => $consultation,//ajout
            'form' => $form,
            
        ]);
    }
    

    #[Route('/consults/{cid}/traitements/{tid}', name: 'app_traitement_show', methods: ['GET'])]
    public function show(#[MapEntity(id: 'tid')] Traitement $traitement,#[MapEntity(id: 'cid')] Consultation $consultation): Response//ajout
    {
        return $this->render('traitement/show.html.twig', [
            'consultation' => $consultation,//ajout
            'traitement' => $traitement,
        ]);
    }
   

    #[Route('/consults/{cid}/traitements/{tid}/edit', name: 'app_traitement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(id: 'tid')] Traitement $traitement,#[MapEntity(id: 'cid')] Consultation $consultation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TraitementType::class, $traitement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_traitement_index', ['id' => $consultation->getId()]);//ajout
        }

        return $this->render('traitement/edit.html.twig', [
            'traitement' => $traitement,
            'consultation' => $consultation,//ajout
            'form' => $form,
        ]);
    }

    #[Route('/consults/{cid}/traitements/{tid}', name: 'app_traitement_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(id: 'tid')] Traitement $traitement,#[MapEntity(id: 'cid')] Consultation $consultation, EntityManagerInterface $entityManager): Response//ajout
    {
        if ($this->isCsrfTokenValid('delete'.$traitement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($traitement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_traitement_index', ['id' => $consultation->getId()]);//ajout
    }
    
    
}
