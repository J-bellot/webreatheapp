<?php

namespace App\Controller\Admin;

use App\Entity\Mesure;
use App\Entity\Panne;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\MainMenuDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Validator\DependencyInjection\AddAutoMappingConfigurationPass;


class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
        
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(ModuleCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('WebreatheApp');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Modules', 'fa fa-area-chart');
        yield MenuItem::linkToCrud('Mesures', 'fas fa-bar-chart', Mesure::class);
        yield MenuItem::linkToCrud('Pannes', 'fas fa-exclamation-triangle', Panne::class);
        yield MenuItem::linkToUrl('Retour à WebeartheApp','fa fa-chevron-left','/');
    }
}
