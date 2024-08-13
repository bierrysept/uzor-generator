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

    public function getAllImages(): array
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
        return Image::getByIndex($i, $this->width, $this->height, $this->color);
    }

}