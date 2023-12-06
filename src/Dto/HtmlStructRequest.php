<?php
declare(strict_types=1);

namespace App\Dto;

class HtmlStructRequest
{
    private string $orientation = "landscape";

    private string $paper = "A4";

    private array $html = [""];

    private ?string $css = null;

    private bool $saveFile = false;


    public function __construct()
    {
    }


    public function getOrientation(): string
    {
        return $this->orientation;
    }

    public function setOrientation(string $orientation): void
    {
        $this->orientation = $orientation;
    }

    public function getPaper(): string
    {
        return $this->paper;
    }

    public function setPaper(string $paper): void
    {
        $this->paper = $paper;
    }

    public function getHtml(): array
    {
        return $this->html;
    }

    public function setHtml(array $html): void
    {
        $this->html = $html;
    }

    public function getCss(): ?string
    {
        return $this->css;
    }

    public function setCss(?string $css): void
    {
        $this->css = $css;
    }

    public function isSaveFile(): bool
    {
        return $this->saveFile;
    }

    public function setSaveFile(bool $saveFile): void
    {
        $this->saveFile = $saveFile;
    }

}