<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PdfStoreService
{
    private string $fileStorage;

    /**
     * @param string $fileStorage
     */
    public function __construct(string $fileStorage)
    {
        if (preg_match('/\/$/i', $fileStorage)) {
            $this->fileStorage = $fileStorage;
        } else {
            $this->fileStorage = "$fileStorage/";
        }
    }

    public function save(string $fileName, string $content): string
    {
        $fullPath = "$this->fileStorage$fileName";

        if (!is_dir($this->fileStorage)) {
            mkdir($this->fileStorage, 0700);
        }

        file_put_contents($fullPath, $content);

        return $fileName;
    }

    public function load(string $fileName): string
    {
        $fullPath = "$this->fileStorage$fileName";

        if (!file_exists($fullPath)){
            throw new NotFoundHttpException("File '$fileName' not found");
        }

        return file_get_contents($fullPath) ?? throw new \LogicException("Can not read file $fileName");
    }
}