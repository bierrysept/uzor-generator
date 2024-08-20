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

    public function colorNextSwitch(): void
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
    public function setPixel(int $x, int $y, int $color): void
    {
        if ($x >= $this->width || $y >= $this->height) {
            throw new ImageOutOfRangeException();
        }

        $this->pixels[$x][$y] = $color;
    }

    public function leftShift(int $step=1): Image
    {
        if ($step === 0) {
            return $this;
        }

        $outPixels = $this->pixels;
        $moveColumn = $this->pixels[0];
        $lastColumnIndex = count($this->pixels) - 1;
        for ($i = 0; $i < $lastColumnIndex; $i++) {
            $outPixels[$i] = $outPixels[$i+1];
        }
        $outPixels[$lastColumnIndex] = $moveColumn;
        $this->pixels = $outPixels;
        return $this->leftShift($step-1);
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @throws ImageOutOfRangeException
     */
    public static function getByIndex(int $index, int $width = 1, int $height = 1, int $colorAmount = 2): Image
    {
        $colorsInt = $index;
        $image = new Image($width, $height, $colorAmount);
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                if (!$colorsInt) {
                    break 2;
                }
                $curColor = $colorsInt % $colorAmount;
                $colorsInt = (int) $colorsInt / $colorAmount;

                $image->setPixel($x, $y, $curColor);
            }
        }
        return $image;
    }

    public function getIndex(): int
    {
        $i = 0;
        for ($y = $this->height-1; $y >= 0; $y--) {
            for($x = $this->width-1; $x >= 0; $x--) {
                $i *= $this->colorAmount;
                $i += $this->getPixel($x, $y);
            }
        }
        return $i;
    }

    public function rightShift(int $step=1): Image
    {
        if ($step === 0) {
            return $this;
        }

        $outPixels = $this->pixels;
        $count = count($this->pixels);
        $moveColumn = $this->pixels[$count-1];
        for ($i = $count-1; $i > 0; $i--) {
            $outPixels[$i] = $outPixels[$i-1];
        }
        $outPixels[0] = $moveColumn;
        $this->pixels = $outPixels;
        return $this->leftShift($step-1);
    }

    public function upShift(int $step = 1)
    {
        if ($step === 0) {
            return $this;
        }

        $outPixels = $this->pixels;
        $moveColumn = array_column($outPixels, 0);
        foreach ($outPixels as $x => $column) {
            for ($y = 0; $y < $this->height-1; $y++) {
                $outPixels[$x][$y] = $outPixels[$x][$y+1];
            }
            $outPixels[$x][$this->height-1] = $moveColumn[$x];
        }
        $this->pixels = $outPixels;
        return $this->upShift($step-1);
    }
}