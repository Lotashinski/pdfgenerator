<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\HtmlStructRequest;
use App\Service\DocumentGeneratorService;
use App\Service\PdfStoreService;
use App\Util\RandomString;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class PdfGenerate
{
    public function __construct(
        private readonly SerializerInterface      $serializer,
        private readonly DocumentGeneratorService $documentGeneratorService,
        private readonly PdfStoreService          $pdfStoreService,
        private readonly Security                 $security,
    )
    {
    }

    #[Route('/generator', name: 'app_pdf_generator', methods: ['POST'])]
    public function generate(Request $request): Response
    {
        $data = $request->getContent();

        $dto = $this->serializer->deserialize($data, HtmlStructRequest::class, 'json',
            [AbstractObjectNormalizer::DEEP_OBJECT_TO_POPULATE]);

        $pdf = $this->documentGeneratorService->generate($dto);
        return $dto->isSaveFile() ? $this->saveFile($pdf) : $this->showDraft($pdf);
    }

    #[Route('/file', name: 'app_pdf_load', methods: ['GET'])]
    public function getPdfFile(Request $request): Response
    {
        $fileName = $request->get("file_name");
        if (!preg_match('/^([0-9]+T[0-9]+[0-9a-zA-Z]+).pdf$/i', $fileName)) {
            throw new AccessDeniedHttpException("Not valid pdf name");
        }
        $fileContent = $this->pdfStoreService->load($fileName);
        return $this->showDraft($fileContent);
    }

    private function saveFile(string $pdf): Response
    {
        $user = $this->security->getUser();
        $salt = $user?->getUserIdentifier() ?? (new RandomString(8));
        $fileName = (new \DateTimeImmutable())->format('Ymd\THis') . $salt . '.pdf';
        $this->pdfStoreService->save($fileName, $pdf);
        return new JsonResponse(["file_name" => $fileName], Response::HTTP_CREATED);
    }

    private function showDraft(string $pdf): Response
    {
        $response = new Response($pdf, Response::HTTP_OK, ['content-type' => 'application/pdf']);
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            (new \DateTimeImmutable())->format(DATE_W3C) . '.pdf'
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
