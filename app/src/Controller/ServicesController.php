<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\ApiKey;
use App\Exception\ForbiddenException;
use App\Repository\ApiKeyRepository;
use App\Util\RandomString;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    public function __construct(
        private readonly ApiKeyRepository       $apiKeyRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {

    }

    #[Route('/services', name: 'services', methods: ["GET"])]
    public function index(): Response
    {
        $user = $this->getUser();
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $keys = $this->apiKeyRepository->findAll();
        } else {
            $keys = $this->apiKeyRepository->findBy(['creatorTnn' => $user->getTnn()], ['service' => 'ASC']);
        }

        return $this->render('services/index.html.twig', [
            'controller_name' => 'RoomController',
            'services' => $keys,
        ]);
    }

    #[Route('/services', name: 'services_new', methods: ["POST"])]
    public function createService(Request $request): Response
    {
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('create-item', $submittedToken)) {
            throw new ForbiddenException("Invalid csrf token");
        }

        $user = $this->getUser();
        $service = new ApiKey();

        $service->setService($request->get('service'));
        $service->setDescription($request->get('description'));

        $service->setValue(new RandomString(34) . "");
        $service->setCreator($user->getUserIdentifier());
        $service->setCreatorTnn($user->getTnn());

        $this->entityManager->persist($service);
        $this->entityManager->flush();

        return $this->redirectToRoute('services');
    }

    #[Route('/services/{id<\d+>}/update', name: 'services_update', methods: ["PUT", "POST"])]
    public function updateService(ApiKey $service, Request $request): Response
    {
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('update-item', $submittedToken)) {
            throw new ForbiddenException("Invalid csrf token");
        }

        $service->setService($request->get('service'));
        $service->setDescription($request->get('description'));

        if ($request->get("regenerate", false) === "on") {
            $service->setValue(new RandomString(34) . "");
        }

        $this->entityManager->flush();

        return $this->redirectToRoute('services');
    }

    #[Route('/services/{id<\d+>}/delete', name: 'services_delete', methods: ["DELETE", "POST"])]
    public function deleteService(ApiKey $apiKey, Request $request): Response
    {
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('delete-item', $submittedToken)) {
            throw new ForbiddenException("Invalid csrf token");
        }

        $this->entityManager->remove($apiKey);
        $this->entityManager->flush();

        return $this->redirectToRoute('services');
    }
}
