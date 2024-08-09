<?php

namespace Bierrysept\UzorGenerator\Tests;

use Bierrysept\UzorGenerator\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testImageColorSwitch()
    {
        $image = new Image(1,1,2);
        $this->assertEquals(0, $image->getPixel(0,0));

        $image->colorNextSwitch();
        $this->assertEquals(1, $image->getPixel(0,0));

        $image->colorNextSwitch();
        $this->assertEquals(0, $image->getPixel(0,0));
    }

    public function testImage1x1()
    {
        $image = new Image();
        $this->assertEquals(0, $image->getPixel(0,0));

        $image->setPixel(0,0,1);
        $this->assertEquals(1, $image->getPixel(0,0));
    }

    public function testImageColor3Switch()
    {
        $image = new Image(1, 1,3);
        $this->assertEquals(0, $image->getPixel(0,0));

        $image->colorNextSwitch();
        $this->assertEquals(1, $image->getPixel(0,0));

        $image->colorNextSwitch();
        $this->assertEquals(2, $image->getPixel(0,0));

        $image->colorNextSwitch();
        $this->assertEquals(0, $image->getPixel(0,0));
    }

    public function testImage2x2()
    {
        $image = new Image(2,2,2);
        $this->assertEquals(0, $image->getPixel(0,0));
        $this->assertEquals(0, $image->getPixel(0,1)); // 00
        $this->assertEquals(0, $image->getPixel(1,0)); // 00
        $this->assertEquals(0, $image->getPixel(1,1));

        $image->setPixel(0,1,1);
        $image->setPixel(1,0,1);

        $this->assertEquals(0, $image->getPixel(0,0));
        $this->assertEquals(1, $image->getPixel(0,1));// 01
        $this->assertEquals(1, $image->getPixel(1,0));// 10
        $this->assertEquals(0, $image->getPixel(1,1));

        $image->colorNextSwitch();

        $this->assertEquals(1, $image->getPixel(0,0));
        $this->assertEquals(0, $image->getPixel(0,1));// 10
        $this->assertEquals(0, $image->getPixel(1,0));// 01
        $this->assertEquals(1, $image->getPixel(1,1));
    }
}