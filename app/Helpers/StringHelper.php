<?php

namespace App\Helpers;

use Core\Domain\Helpers\StringHelperInterface;

class StringHelper implements StringHelperInterface {

    private const RANDOM_GENERATOR_MODE = 'alnum';
    /* Database Sequential Order Propose */
    private const TRANSLATION = [
        0 => 'aZ3',
        1 => 'b0n',
        2 => 'cTw',
        3 => 'dTh',
        4 => 'eF0',
        5 => 'fF1',
        6 => 'gS1',
        7 => 'hS3',
        8 => 'i31',
        9 => 'jN1',
    ];

    public function getRandomString(int $length): string
    {
        // Codeigniter StringHelpers invoke
        helper('text');

        $timestampString = $this->fromTimestamp();
        $randomString = random_string(self::RANDOM_GENERATOR_MODE, $length - strlen($timestampString));

        return $timestampString . $randomString;
    }

    /**
     * @return string
     * Always with 30 chars length, based on current timestamp digits + 5 md5() as constraint
     */
    private function fromTimestamp(): string
    {
        $output = '';
        foreach(str_split(time()) as $char ) {
            $output .= self::TRANSLATION[(int) $char];
        }

        return $output  . substr(md5($output), 0, 5);
    }
}