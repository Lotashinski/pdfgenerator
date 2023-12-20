<?php
declare(strict_types=1);

namespace App\Service\Security;

use App\Repository\ApiKeyRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private readonly LoggerInterface  $securityLogger,
        private readonly ApiKeyRepository $repository,
    )
    {
    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        $accessToken = trim($accessToken);
        return new UserBadge($accessToken, fn(string $token) => $this->getUserByToken($token));
    }

    private function getUserByToken(string $accessToken): UserInterface
    {
        $this->securityLogger->debug('service from database');
        return $this->repository->findOneBy(['value' => $accessToken]);
    }
}