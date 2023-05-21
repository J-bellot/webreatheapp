<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\NouveauModuleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/add-module', name: 'add_module')]
    public function register(Request $request): Response
    {
        $module = new Module();
        $form = $this->createForm(NouveauModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $module->setEtat(True);
            $this->entityManager->persist($module);
            $this->entityManager->flush();
            
            // Redirigez l'utilisateur vers une autre page après l'inscription réussie
            return $this->redirect('/');
        }

        return $this->render('module/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'status_module')]
    public function status(EntityManagerInterface $entityManager): Response
    {
        // Récupérez les données nécessaires depuis la base de données à l'aide de Doctrine

        // Exemple : récupération de la liste des modules depuis une entité Module
        $modules = $entityManager->getRepository(Module::class)->findAll();

        // Retournez une réponse en utilisant un template Twig pour afficher les données
        return $this->render('module/status.html.twig', [
            'modules' => $modules,
        ]);
    }

    #[Route('/update', name: 'status_module_update')]
    public function getUpdates(EntityManagerInterface $entityManager)
    {
        // Récupérer les mises à jour des états des modules depuis la base de données
        $updates = $entityManager->getRepository(Module::class)->findAll();

        // Créer un tableau pour stocker les données des modules
        $moduleData = [];

        // Parcourir les mises à jour et récupérer les propriétés spécifiques
        foreach ($updates as $module) {
            $moduleData[] = [
                'installation' => $module->getInstallation(),
                'nom' => $module->getNom(),
                'description' => $module->getDescription(),
                'etat' => $module->getEtat(),
            ];
        }

        // Convertir les mises à jour en format JSON
        $jsonData = json_encode($moduleData);

        // Renvoyer les mises à jour au format JSON
        return new JsonResponse($jsonData);
    }
}
