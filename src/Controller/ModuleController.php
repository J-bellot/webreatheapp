<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\NouveauModuleType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/add-module', name: 'app_module')]
    public function index(Request $request): Response
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
}
