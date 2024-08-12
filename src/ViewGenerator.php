<?php

namespace Bierrysept\UzorGenerator;

class ViewGenerator
{
    static public function run(\Composer\Script\Event $event) {
        /** @var string[] $args */
        $args = $event->getArguments();

        echo "↑ Arguments that was putted is here ↑";
    }

    static public function runAllImages(\Composer\Script\Event $event) {
        /** @var string[] $args */
        $args = $event->getArguments();

        $width = $args[0] ?? 2;
        $height= $args[1] ?? 2;
        $color = $args[2] ?? 2;
        $generator = new UzorGenerator($width, $height, $color);

        echo "Generate images {$width}X$height\n\n";
        $images = $generator->getAllImages();
        foreach ($images as $key => $image) {
            echo "Image #$key\n";
            for($y = 0; $y < $image->getHeight(); $y++){
                for ($x = 0; $x < $image->getWidth(); $x++) {
                    echo $image->getPixel($x,$y) ? "W" : "_";
                }
                echo "\n";
            }
            echo "\n";
        }
    }

    static public function testComposerArgument(\Composer\Script\Event $event) {
        /** @noinspection ForgottenDebugOutputInspection */
        var_dump($event->getArguments());

        echo "↑ List of arguments put's here ↑\n";
    }
}