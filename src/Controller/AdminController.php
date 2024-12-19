<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cours;
use App\Entity\Session;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'datas' => 'AdminController',
        ]);
    }

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createCours(Request $request): Response
    {
        $titre = $request->get('titre');
        $module = $request->get('module');
        $professeurId = $request->get('professeur_id');
        
        $professeur = $this->em->getRepository(Professeur::class)->find($professeurId);

        if (!$professeur) {
            return new Response('Professeur non trouvé', 404);
        }

        $cours = new Cours();
        $cours->setTitre($titre);
        $cours->setModule($module);
        $cours->setProfesseur($professeur);

        $this->em->persist($cours);
        $this->em->flush();

        return new Response('Cours créé avec succès');
    }

    public function listCours(): Response
    {
        $cours = $this->em->getRepository(Cours::class)->findAll();
        return $this->json($cours);
    }

    public function createSession(Request $request): Response
    {
        $date = new \DateTime($request->get('date'));
        $heureDebut = new \DateTime($request->get('heure_debut'));
        $heureFin = new \DateTime($request->get('heure_fin'));
        $salle = $request->get('salle');
        $coursId = $request->get('cours_id');

        $cours = $this->em->getRepository(Cours::class)->find($coursId);

        if (!$cours) {
            return new Response('Cours non trouvé', 404);
        }

        $session = new Session();
        $session->setDate($date);
        $session->setHeureDebut($heureDebut);
        $session->setHeureFin($heureFin);
        $session->setSalle($salle);
        $session->setCours($cours);

        $this->em->persist($session);
        $this->em->flush();

        return new Response('Session créée avec succès');
    }

    public function listSessionsByCours(int $coursId): Response
    {
        $sessions = $this->em->getRepository(Session::class)->findBy(['cours' => $coursId]);
        return $this->json($sessions);
    }

    public function assignEtudiantToClasse(Request $request): Response
    {
        $etudiantId = $request->get('etudiant_id');
        $classeId = $request->get('classe_id');

        $etudiant = $this->em->getRepository(Etudiant::class)->find($etudiantId);
        $classe = $this->em->getRepository(Classe::class)->find($classeId);

        if (!$etudiant || !$classe) {
            return new Response('Étudiant ou classe non trouvé', 404);
        }

        $etudiant->setClasse($classe);
        $this->em->flush();

        return new Response('Étudiant assigné à la classe avec succès');
    }
}
