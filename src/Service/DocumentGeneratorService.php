<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\HtmlStructRequest;
use Dompdf\Dompdf;
use Dompdf\Options;

class DocumentGeneratorService
{
    public function generate(HtmlStructRequest $htmlStructRequest): string
    {
        $dompdf = new Dompdf();
        $dompdf->setPaper($htmlStructRequest->getPaper(), $htmlStructRequest->getOrientation());

        $option = new Options();
        $option->setIsRemoteEnabled(true);
        $dompdf->setOptions($option);

        if (null !== $htmlStructRequest->getCss()){
            $dompdf->setCss($htmlStructRequest->getCss());
        }

        $dompdf->loadHtml($htmlStructRequest->getHtml());

        $dompdf->render();

        return $dompdf->output();
    }
}