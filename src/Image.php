<?php

namespace Bierrysept\UzorGenerator;

use Bierrysept\UzorGenerator\Exceptions\ImageOutOfRangeException;

class Image
{
    /**
     * @throws ImageOutOfRangeException
     */
    public function getPixel(int $x, int $y): int
    {
        if ($x >= 1 || $y >= 2) {
            throw new ImageOutOfRangeException();
        }
        return 0;
    }
}