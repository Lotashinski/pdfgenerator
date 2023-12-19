<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::REQUEST)]
final class PlaceboUserListener
{
    public function __construct(
        private readonly Security        $security,
        private readonly UserRepository  $userRepository,
        private readonly LoggerInterface $securityLogger,
    )
    {
    }


    public function __invoke(RequestEvent $event): void
    {
        $this->securityLogger->debug("Check currentUser");
        if ($this->security->getUser()) {
            return;
        }

        $this->securityLogger->debug("SetProxy user");
        $user = $this->userRepository->find(145253);

        if (null == $user){
            return;
        }
    }
}
