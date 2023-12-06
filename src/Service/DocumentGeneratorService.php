<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\HtmlStructRequest;
use Dompdf\Css\Stylesheet;
use Dompdf\Dompdf;
use Dompdf\Options;
use mikehaertl\wkhtmlto\Pdf;

class DocumentGeneratorService
{
    public function generate(HtmlStructRequest $htmlStructRequest): string
    {
        $pdf = new Pdf();

        foreach ($htmlStructRequest->getHtml() as $page) {
            $pdf->addPage($page);
        }


        return $pdf->toString();
//        $dompdf = new Dompdf();
//        $dompdf->setPaper($htmlStructRequest->getPaper(), $htmlStructRequest->getOrientation());
//
//        $option = new Options();
//        $option->setIsRemoteEnabled(true);
//        $dompdf->setOptions($option);
//
//        $html = $htmlStructRequest->getHtml();
//
//        if (null !== $htmlStructRequest->getCss()){
//            $requestStyle = $htmlStructRequest->getCss();
//            $css = new Stylesheet($dompdf);
//            $css->load_css($requestStyle);
//            $dompdf->setCss($css);
//        }
//
//        $dompdf->loadHtml($html);
//
//        $dompdf->render();
//
//        return $dompdf->output();
    }
}