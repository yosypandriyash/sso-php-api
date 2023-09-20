<?php

namespace App\Helpers;

class AppHelper {

    /**
     * @return string
     */
    public static function getPublicPath(): string
    {
        return Config('Paths')->publicDirectory;
    }

}