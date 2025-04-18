<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {

        $contacts = $contactRepository->findAll();

        return $this->render('index.html.twig', [
            "contacts" => $contacts
        ]);
    }

    #[Route('/create', name: 'app_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        // 1. Créer une nouvelle instance du contact à insérer en base.
        $contact = new Contact;

        // 2. Créer le formulaire en se basant sur son type et sur l'instance du contact.
        $form = $this->createForm(ContactFormType::class, $contact);

        // 4. Associer les données de la requête au formulaire.
        $form->handleRequest($request);

        // $contact->setFirstName($request->request->get('firstName'));
        // $contact->setLastName($request->request->get('lastName'));
        // $contact->setEmail($request->request->get('email'));
        // $contact->setPhone($request->request->get('phone'));
        // $contact->setComment($request->request->get('comment'));

        // 5. Si le formulaire est soumis et que le formulaire est valide
        if ( $form->isSubmitted() && $form->isValid() )
        {
            // 6. Initialiser les dates de création et de modification du contact,
            $contact->setCreatedAt(new DateTimeImmutable());
            $contact->setUpdatedAt(new DateTimeImmutable());

            // 7. Préparer la requête d'insertion du contact en base de données,
            $entityManager->persist($contact); // Préparation de la requête d'insertion
            $entityManager->flush(); // Exécution de la requête

            // 8. Générer le message flash de succès de l'opération,
            $this->addFlash("success", "Le contact a été ajouté à la liste.");

            // 9. Rediriger l'utilisateur vers la route menant à la page d'accueil
                // Puis arrêter l'exécution du script.
            return $this->redirectToRoute('app_index');
        }

        // 3. Afficher la page ainsi que le formulaire.
        return $this->render('create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/show/{id<\d+>}', name: 'app_show', methods: ['GET'])]
    public function show(int $id, ContactRepository $contactRepository): Response
    {

        $contact = $contactRepository->find($id);

        if ( null === $contact ) 
        {
            return $this->redirectToRoute('app_index');
        }

        return $this->render('show.html.twig', [
            "contact" => $contact
        ]);
    }


    #[Route('/edit/{id<\d+>}', name: 'app_edit', methods: ['GET', 'POST'])]
    public function edit(
        int $id, 
        ContactRepository $contactRepository, 
        Request $request, 
        EntityManagerInterface $entityManager
    ): Response {

        // 1. Vérifions si le contact à modifier existe dans la base de données.
        $contact = $contactRepository->find($id);

        // 2. S'il n'existe pas,
        if ( null === $contact ) 
        {
            // Rediriger l'utilisateur vers la route menant à la page d'accueil.
            return $this->redirectToRoute('app_index');
        }

        // Dans le cas contraire,
        // 3. Créons le formulaire de modification
        $form = $this->createForm(ContactFormType::class, $contact);

        // 5. Associons aux formulaire, les données de la requête
        $form->handleRequest($request);

        // 6. Si le formulaire est soumis et valide
        if ( $form->isSubmitted() && $form->isValid() ) 
        {
            // 7. Mettre à jour la date de modification du contact
            $contact->setUpdatedAt(new DateTimeImmutable());
    
            // 8. Préparer la requête de modification
            $entityManager->persist($contact); //Préparer la requête de modification du contact
            $entityManager->flush(); // Exécution de la requête
    
            // 9. Générer le message flash de succès
            $this->addFlash("success", "Le contact a bien été modifié.");
    
            // 10. Rediriger vers la route menant à la page d'accueil
                // Puis, arrêter l'exécution du script.
            return $this->redirectToRoute('app_index');
        }

        // 4. Passons la formulaire à la page de modification du contact pour affichage.
        return $this->render('edit.html.twig', [
            "form" => $form->createView()
        ]);
    }


    #[Route('/delete/{id<\d+>}', name: 'app_delete', methods: ['POST'])]
    public function delete(Contact $contact, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ( $this->isCsrfTokenValid("delete-contact-".$contact->getId(), $request->request->get('csrf_token')) ) 
        {
            $entityManager->remove($contact); 
            $entityManager->flush();

            $this->addFlash("success", "Le contact a été supprimé.");
        }

        return $this->redirectToRoute("app_index");
    }



}
   