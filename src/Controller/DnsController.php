<?php

namespace App\Controller;

use App\Service\DigitalOcean;
use App\Service\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DnsController
{
    /** @var string */
    private $domain;

    /** @var string */
    private $subdomain;

    public function __construct(string $domain, string $subdomain)
    {
        $this->domain = $domain;
        $this->subdomain = $subdomain;
    }

    public function getIp(Request $request, Security $security)
    {
        $ip = $request->getClientIp();

        return new JsonResponse([
            'ip' => $ip,
            'timestamp' => (new \DateTime())->format('Y-m-d H:i:s'),
            'auth' => $security->check($request->get('otp', '')),
        ]);
    }

    public function update(Request $request, DigitalOcean $digitalOcean, Security $security)
    {
        if (false === $security->check($request->get('otp', ''))) {
            throw new AccessDeniedHttpException();
        }

        $response = $digitalOcean->updateSubDomain($this->subdomain, $this->domain, $request->getClientIp());

        return new JsonResponse($response);
    }
}
