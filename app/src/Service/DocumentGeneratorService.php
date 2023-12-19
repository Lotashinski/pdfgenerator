<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\GeneratorRequest;
use Exception;
use mikehaertl\wkhtmlto\Pdf;

class DocumentGeneratorService
{
    /**
     * @throws Exception
     */
    public function generate(GeneratorRequest $pageContent): string
    {
        $options = [
            'encoding' => 'UTF-8',
            'ignoreWarnings' => true,
            'orientation' => $pageContent->getOrientation(),
            'page-width' => $pageContent->getWidth(),
            'page-height' => $pageContent->getHeight(),
        ];

        $pdf = new Pdf();
        $pdf->setOptions($options);

        $pdf->addPage($pageContent->getHtml());

        if ($output = $pdf->toString()) {
            return $output;
        }

        throw new Exception($pdf->getError());
    }
}