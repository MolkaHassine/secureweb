<?php

namespace App\Service;

use App\Entity\AuditLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class AuditLogger
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RequestStack $requestStack,
        private Security $security
    ) {
    }

    public function log(string $action, string $resource = null, string $details = null, $user = null): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $ip = $request ? $request->getClientIp() : '127.0.0.1';
        $ua = $request ? $request->headers->get('User-Agent') : null;

        $auditLog = new AuditLog();
        $auditLog->setIpAddress($ip ?? '127.0.0.1');
        $auditLog->setAction($action);
        $auditLog->setResource($resource);
        $auditLog->setDetails($details);
        $auditLog->setUser($user ?? $this->security->getUser());

        $this->entityManager->persist($auditLog);
        $this->entityManager->flush();
    }
}
