<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/create', name: 'app_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {

        // 1. Créer une nouvelle instance du contact à insérer en base.
        $contact = new Contact;

        // 2. Créer le formulaire en se basant sur son type et sur l'instance du contact.
        $form = $this->createForm(ContactFormType::class, $contact);

        // 4. Associer les données de la requête au formulaire.
        $form->handleRequest($request);

        // 5. Si le formulaire est soumis et que le formulaire est valide
        if ( $form->isSubmitted() && $form->isValid() )
        {
            dd('Continuer la partie');

            // 6. Initialiser les dates de création et de modification du contact,

            // 7. Préparer la requête d'insertion du contact en base de données,

            // 8. Exécuter la requête,

            // 9. Générer le message flash de succès de l'opération,

            // 10. Rediriger l'utilisateur vers la route menant à la page d'accueil
                // Puis arrêter l'exécution du script.
        }

        // 3. Afficher la page ainsi que le formulaire.
        return $this->render('create.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
   