<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    public function __construct(
        private readonly Security $security
    )
    {

    }

    #[Route('/room', name: 'app_room', methods: ["GET"])]
    public function index(): Response
    {
        $token = $this->security->getToken();

        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
            'token' => $token
        ]);
    }
}
