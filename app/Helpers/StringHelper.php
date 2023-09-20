<?php

namespace App\Helpers;

class StringHelper implements StringHelperInterface {

    public function getRandomString(int $length): string
    {
        helper('text');
        return random_string('alnum', $length);
    }
}