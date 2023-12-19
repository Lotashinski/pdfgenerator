<?php
declare(strict_types=1);

namespace App\Util;

class RandomString
{
    private int $length;

    private ?string $str = null;


    /**
     * @param int $length
     */
    public function __construct(int $length = 8)
    {
        $this->length = $length;
    }


    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): void
    {
        $this->length = $length;
    }


    public function __toString(): string
    {
        if (null === $this->str) {
            $generator = new RandomStringGenerator();
            $this->str = $generator->generateRandomString($this->getLength());
        }

        return $this->str;
    }

}