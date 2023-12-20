<?php
declare(strict_types=1);

namespace App\Service\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private readonly LoggerInterface $securityLogger,
        private readonly JwtTokenService $tokenService,
    )
    {

    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        if (!preg_match('/^Bearer.+/', $accessToken)) {
            throw new InvalidJwtBearerException("Token is not 'Bearer'");
        }
        $accessToken = str_replace("Bearer ", "", $accessToken);
        return new UserBadge($accessToken, fn(string $token) => $this->getUserByToken($token));
    }

    /**
     * @throws JWTDecodeFailureException
     */
    private function getUserByToken(string $accessToken): UserInterface
    {
        $this->securityLogger->debug('loadUser from database');
        return $this->tokenService->extract($accessToken);
    }
}