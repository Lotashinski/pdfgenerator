<?php
declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger)
    {

    }

    #[Route('/', name: 'app_doc', methods: ["GET"])]
    public function index(): Response
    {
        $this->logger->debug("11111111");
        return $this->render('doc/index.html.twig', [
            'controller_name' => 'DocController',
        ]);
    }
}
