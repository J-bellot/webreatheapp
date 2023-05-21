<?php

namespace App\Controller;


use DateTime;
use App\Entity\Panne;
use App\Entity\Module;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanneController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/check-panne', name: 'app_check_panne')]
    public function checkPanne(): Response
    {
        $entityManager = $this->entityManager;

        $modules = $entityManager->getRepository(Module::class)->findAll();

        foreach ($modules as $module) {
            // Vérifier si le module est en panne
            if (!$module->getEtat()) {
                // Le module est en panne
                $random = mt_rand(1, 3);
                if ($random === 1) {
                    // Il y a 1/3 chances que le module soit réparé
                    $module->setEtat(1);
                    
                    // Mettre à jour l'objet Panne existant
                    $panne = $entityManager->getRepository(Panne::class)->findOneBy(['module' => $module, 'fin' => null]);
                    if ($panne) {
                        $panne->setFin(new DateTime());
                        $entityManager->flush();
                    }
                } else {
                    // Le module est en panne mais il n'y a pas de changement d'état
                    continue;
                }
            } else {
                // Le module n'est pas en panne
                $random = mt_rand(1, 10);
                if ($random === 1) {
                    // Il y a 1/10 chances que le module tombe en panne
                    $module->setEtat(0);
        
                    // Créer l'objet Panne
                    $panne = new Panne();
                    $panne->setModule($module);
                    $panne->setDescription("Panne qui est arrivée je sais pas trop quand mais tkt");
                    $panne->setDebut(new DateTime());
        
                    // Persist et flush l'objet Panne
                    $entityManager->persist($panne);
                    $entityManager->flush();
                }
            }
            
            $entityManager->persist($module);
        }
        
        $entityManager->flush();
        

        return new Response(); // Renvoyer une réponse vide
    }
}


