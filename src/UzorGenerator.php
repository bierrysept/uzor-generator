<?php

namespace Bierrysept\UzorGenerator;

class UzorGenerator
{

    private int $width;
    private int $height;

    public function __construct(int $width=1, int $height=1)
    {
        $this->width = $width;
        $this->height= $height;
    }
    public function getAllUzors(): array
    {
        $width = $this->width;
        $height= $this->height;
        return array_fill(0, $width*$height, new Image());
    }

}