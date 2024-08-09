<?php

namespace Bierrysept\UzorGenerator;

use Bierrysept\UzorGenerator\Exceptions\ImageOutOfRangeException;

class Image
{
    /** @var int[]  */
    private array $pixels;

    /** @var int  */
    private int $colorAmount;
    private int $width;
    private int $height;

    public function __construct(int $width = 1, int $height = 1, int $colorAmount = 2)
    {
        $this->width        = $width;
        $this->height       = $height;
        $this->colorAmount  = $colorAmount;

        $ys = array_fill(0, $height, 0);
        $this->pixels = array_fill(0, $width, $ys);
    }

    /**
     * @throws ImageOutOfRangeException
     */
    public function getPixel(int $x, int $y): int
    {
        if ($x >= $this->width || $y >= $this->height) {
            throw new ImageOutOfRangeException();
        }
        return $this->pixels[$x][$y];
    }

    public function colorNextSwitch()
    {
        foreach ($this->pixels as $x => $row) {
            foreach ($row as $y => $pixel) {
                $this->pixels[$x][$y] = ($pixel + 1) % $this->colorAmount;
            }
        }
    }

    public function setPixel(int $x, int $y, int $color)
    {
        $this->pixels[$x][$y] = $color;
    }
}