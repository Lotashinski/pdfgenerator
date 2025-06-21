<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocController extends AbstractController
{
    #[Route('/', name: 'app_doc', methods: ["GET"])]
    public function index(): Response
    {
        return $this->render('doc/index.html.twig', [
            'controller_name' => 'DocController',
            'header' => "",
        ]);
    }
} 
