<?php

namespace App\Controller;

use App\Entity\AuditLog;
use App\Entity\LoginAttempt;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuditController extends AbstractController
{
    #[Route('/admin/audit', name: 'app_audit')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $auditLogs = $entityManager->getRepository(AuditLog::class)
            ->findBy([], ['loggedAt' => 'DESC'], 50);

        $loginAttempts = $entityManager->getRepository(LoginAttempt::class)
            ->findBy([], ['attemptedAt' => 'DESC'], 50);

        return $this->render('audit/index.html.twig', [
            'auditLogs' => $auditLogs,
            'loginAttempts' => $loginAttempts,
        ]);
    }
}
