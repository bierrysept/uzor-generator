<?php

namespace Bierrysept\UzorGenerator\Tests;

use Bierrysept\UzorGenerator\Exceptions\ImageOutOfRangeException;
use Bierrysept\UzorGenerator\Image;
use Bierrysept\UzorGenerator\UzorGenerator;
use PHPUnit\Framework\TestCase;

class UzorGeneratorTest extends TestCase
{
    /**
     * @throws ImageOutOfRangeException
     */
    public function test1x1UzorGenerator(): void
    {
        $generator = new UzorGenerator();
        $uzors = $generator->getAllUzors();
        $this->assertCount(1,$uzors);

        $uzor = $uzors[0];
        $this->assertInstanceOf(Image::class, $uzor);

        $this->assertEquals(0, $uzor->getPixel(0,0));
    }

    public function testGetAllImages(): void
    {
        $generator = new UzorGenerator(2,2);
        $images = $generator->getAllImages();
        $this->assertCount(16, $images);

        $image1 = $images[1];                                               //10
        $this->assertEquals(1, $image1->getPixel(0, 0));    //00

        $image2 = $images[2];                                               //01
        $this->assertEquals(1, $image2->getPixel(1,0));     //00

        $image1001 = $images[9];                                            //10
        $this->assertEquals(1, $image1001->getPixel(0,0));  //01
        $this->assertEquals(0, $image1001->getPixel(1,0));
        $this->assertEquals(0, $image1001->getPixel(0,1));
        $this->assertEquals(1, $image1001->getPixel(1,1));
    }

    public function testGenerate1x2Images()
    {
        $generator = new UzorGenerator(2,1);
        $uzor = $generator->getAllUzors();
        $this->assertCount(2, $uzor);

    }

    public function testGetImageByIndex(): void
    {
        $generator = new UzorGenerator(2,2);
        $image2 = $generator->getImageByIndex(2);
        $this->assertEquals(1, $image2->getPixel(1,0));
    }

    public function test2x2UzorGenerator(): void
    {
        $generator = new UzorGenerator(2,2);
        $uzors = $generator->getAllUzors();
        $this->assertCount(4, $uzors);
    }

    public function testXxXUzorGenerator(): void
    {
        $width = random_int(1,5);
        $height= random_int(1,5);

        $generator = new UzorGenerator($width, $height);

        $uzors = $generator->getAllUzors();
        /** @var Image $uzor */
        $uzor = $uzors[0];

        $this->expectException(ImageOutOfRangeException::class);

        $uzor->getPixel($width, $height);
    }
}