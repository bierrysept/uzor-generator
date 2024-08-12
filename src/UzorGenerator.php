<?php

namespace Bierrysept\UzorGenerator;

use Bierrysept\UzorGenerator\Exceptions\ImageOutOfRangeException;

class UzorGenerator
{

    private int $width;
    private int $height;
    private int $color;

    public function __construct(int $width=1, int $height=1, int $color=2)
    {
        $this->color = $color;
        $this->height = $height;
        $this->width = $width;
    }
    public function getAllUzors(): array
    {
        $width = $this->width;
        $height= $this->height;
        return array_fill(0, $width*$height, new Image($width,$height));
    }

    public function getAllImages()
    {
        $color = $this->color;
        $imageCount = $color ** ($this->width * $this->height);
        /** @var Image[] $images */
        $images = [];
        for($i = 0; $i < $imageCount; $i++){
            $images[$i] = $this->getImageByIndex($i);
        }

        return $images;
    }

    /**
     * @param int $i
     * @return void
     * @throws ImageOutOfRangeException
     */
    public function getImageByIndex(int $i): Image
    {
        $colorsInt = $i;
        $color = $this->color;
        $image = new Image($this->width, $this->height, $color);
        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                if (!$colorsInt) {
                    break 2;
                }
                $curColor = $colorsInt % $color;
                $colorsInt = (int) $colorsInt / $color;

                $image->setPixel($x, $y, $curColor);
            }
        }
        return $image;
    }

}