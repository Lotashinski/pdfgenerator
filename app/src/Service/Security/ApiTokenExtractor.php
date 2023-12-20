<?php
declare(strict_types=1);

namespace App\Service\Security;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\AccessToken\AccessTokenExtractorInterface;

final class ApiTokenExtractor implements AccessTokenExtractorInterface
{
    public function __construct(
        #[Autowire('%env(resolve:BEARER_HEADER)%')]
        private readonly string          $header,
        private readonly LoggerInterface $securityLogger
    )
    {
    }

    public function extractAccessToken(Request $request): ?string
    {
        $this->securityLogger->debug("Extract bearer token if exists");
        return $request->headers->get($this->header);
    }
}