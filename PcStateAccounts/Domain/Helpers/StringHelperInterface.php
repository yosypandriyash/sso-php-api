<?php

namespace Core\Domain\Helpers;

interface StringHelperInterface {

    public function getRandomString(int $length): string;

}