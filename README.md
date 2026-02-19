# Question 10
symfony console make:entity Traitement

pour les attributs de posologie j'ai décidé d'ajouter la dose et la fréquence

pour ce qui est de la relation ManyToOne

# Question 11

Je décide de faire un symfony console make:crud Traitement pour simplifier la création des dossiers et je vais
venir par la suite modifier pour faire correspondre a la question


#[Route('/consults/{id}/traitements', name: 'app_traitement_index', methods: ['GET'])]
    public function index(Consultation $consultation): Response
    {
        return $this->render('traitement/index.html.twig', [
        'consultation' => $consultation,
        'traitements' => $consultation->getTraitements(),
    ]);
}