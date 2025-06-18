<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[AsController]
class EchoController
{
    #[Route(path: "/api/echo")]
    public function function_name(Request $request) : Response 
    {
        return new JsonResponse(['message' => $request->get('message')]);
    }
}

