<?php
declare(strict_types=1);

namespace App\Service\Security;

use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class PlaceboUserAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly UserRepository  $userRepository,
        private readonly LoggerInterface $securityLogger,
    )
    {

    }

    public function supports(Request $request): ?bool
    {
        $this->securityLogger->debug('check request');
        return true;
    }

    public function authenticate(Request $request): Passport
    {
        $this->securityLogger->debug('authenticate');
        return new SelfValidatingPassport(new UserBadge('', function ($_) {
            return $this->userRepository->find(145253);
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $this->securityLogger->debug('forbidden');
        return new Response(status: Response::HTTP_UNAUTHORIZED);
    }
}