<?php
declare(strict_types=1);

namespace App\Dto;

class GeneratorRequest
{
    private ?string $html = null;

    private bool $saveFile = false;

    private ?string $orientation = "portrait";

    private int $width = 210;

    private int $height = 297;


    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function setHtml(?string $html): void
    {
        $this->html = $html;
    }

    public function isSaveFile(): bool
    {
        return $this->saveFile;
    }

    public function setSaveFile(bool $saveFile): void
    {
        $this->saveFile = $saveFile;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function setOrientation(?string $orientation): void
    {
        $this->orientation = $orientation;
    }
}