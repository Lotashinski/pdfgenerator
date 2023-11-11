<?php
declare(strict_types=1);

namespace App\Util;

class RandomStringGenerator
{
    public function __construct(
        private readonly string $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    )
    {
    }

    public function generateRandomString(int $length): string
    {
        $chars = $this->characters;
        $charsLength = strlen($this->characters);
        $randomString = '';
        for($i = 0; $i < $length; ++$i){
            $chars = str_shuffle($chars);
            $randomString .= $chars[random_int(0, $charsLength - 1)];
        }
        return $randomString;
    }
}