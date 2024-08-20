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
        $allUzors = [];
        $imageCount = $this->color ** ($this->width * $this->height);
        for ($i = 0; $i < $imageCount; $i++) {
            if (isset($allUzors[$i])) {
                continue;
            }
            $allUzors[$i] = $i;
            $allUzors = $this->getAllNextColors($i, $allUzors);

            $image = Image::getByIndex($i, $this->width, $this->height, $this->color);
            $image->rightShift();
            $leftShiftImageIndex = $image->getIndex();
            $allUzors[$leftShiftImageIndex] = $allUzors[$leftShiftImageIndex] ?? $i;

            $image = Image::getByIndex($i, $this->width, $this->height, $this->color);
            $image->upShift();
            $upShiftImageIndex = $image->getIndex();
            $allUzors[$upShiftImageIndex] = $allUzors[$upShiftImageIndex] ?? $i;
        }

        $outUzors = [];
        foreach ($allUzors as $uzor) {
            if (isset($outUzors[$uzor])) {
                continue;
            }
            $outUzors[$uzor] = Image::getByIndex($uzor, $this->width, $this->height, $this->color);
        }

        return $outUzors;
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

    /**
     * @param int $i
     * @param array $allUzors
     * @return array
     * @throws ImageOutOfRangeException
     */
    public function getAllNextColors(int $i, array $allUzors): array
    {
        $image = Image::getByIndex($i, $this->width, $this->height, $this->color);
        for ($j = 1; $j < $this->color; $j++) {
            $image->colorNextSwitch();
            $nextColorSetImageIndex = $image->getIndex();
            $allUzors[$nextColorSetImageIndex] = $allUzors[$nextColorSetImageIndex] ?? $i;
        }
        return $allUzors;
    }

}