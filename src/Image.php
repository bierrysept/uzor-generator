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

    /**
     * @throws ImageOutOfRangeException
     */
    public function setPixel(int $x, int $y, int $color)
    {
        if ($x >= $this->width || $y >= $this->height) {
            throw new ImageOutOfRangeException();
        }

        $this->pixels[$x][$y] = $color;
    }

    public function leftShift(int $step)
    {
        if ($step == 0) {
            return $this->pixels;
        }

        $outPixels = $this->pixels;
        $moveColumn = $this->pixels[0];
        $count = count($this->pixels) - 1;
        for ($i = 0; $i < $count; $i++) {
            $outPixels[$i] = $outPixels[$i+1];
        }
        $outPixels[$count] = $moveColumn;
        $this->pixels = $outPixels;
        return $this->leftShift($step-1);
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }
}