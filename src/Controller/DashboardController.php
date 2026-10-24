<?php

namespace App\Controller;

use App\Service\AuditLogger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    public function __construct(private AuditLogger $auditLogger)
    {
    }

    #[Route('/', name: 'app_dashboard')]
    public function index(): Response
    {
        $this->auditLogger->log('ACCESS_DASHBOARD', 'dashboard', 'Accès au tableau de bord');
        return $this->render('dashboard/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
