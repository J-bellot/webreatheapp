<?php

namespace App\Controller;

use DateTime;
use App\Entity\Mesure;
use App\Entity\Module;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RandomDataCommandController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/run-random-data-command', name: 'app_random_data_command')]
    public function runCommand(): Response
    {
        $entityManager = $this->entityManager;

        $modules = $entityManager->getRepository(Module::class)->findAll();

        foreach ($modules as $module) {
            if ($module->getEtat()){
                $value = mt_rand(10, 30); // Générer une valeur aléatoire pour la mesure

                $mesure = new Mesure();
                $mesure->setModule($module);
                $mesure->setValeur($value);
                $mesure->setDate(new DateTime());

                $entityManager->persist($mesure);
            }
                
        }

        $entityManager->flush();

        return new Response();
    }
}
