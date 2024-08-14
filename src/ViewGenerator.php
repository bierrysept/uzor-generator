<?php

/**
 * @noinspection UnknownInspectionInspection
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedNamespaceInspection
 */

namespace Bierrysept\UzorGenerator;

use Bierrysept\UzorGenerator\Exceptions\ImageOutOfRangeException;
use Composer\Script\Event;

/** @usedby \Composer\Autoload\ClassLoader */
class ViewGenerator
{
    static private array $colors = [
        " ", "█","▓","░","▒"
    ];

    public static function run(Event $event): void
    {
        /** @var string[] $args */
        $args = $event->getArguments();
        /**
         * @noinspection ForgottenDebugOutputInspection
         * @noinspection PhpUndefinedFunctionInspection
         */
        dump($args);
        echo "↑ Arguments that was putted is here ↑";
    }

    /** @usedby \Composer\Autoload\ClassLoader */
    public static function runAllImages(Event $event): void
    {
        /** @var string[] $args */
        $args = $event->getArguments();

        $width = ((int) ($args[0] ?? '2'));
        $height= ((int) ($args[1] ?? '2'));
        $color = ((int) ($args[2] ?? '2'));
        $generator = new UzorGenerator($width, $height, $color);

        echo "Generate images {$width}X$height\n\n";
        $images = $generator->getAllImages();
        self::echoImages($images);
    }

    /** @usedby \Composer\Autoload\ClassLoader */
    public static function runAllUzors(Event $event): void
    {
        /** @var string[] $args */
        $args = $event->getArguments();

        $width = ((int) ($args[0] ?? '2'));
        $height= ((int) ($args[1] ?? '2'));
        $color = ((int) ($args[2] ?? '2'));
        $generator = new UzorGenerator($width, $height, $color);

        echo "Generate uzors {$width}X$height\n\n";
        $uzors = $generator->getAllUzors();
        self::echoImages($uzors);
    }

    /** @usedby \Composer\Autoload\ClassLoader */
    public static function testComposerArgument(Event $event): void
    {
        /** @noinspection ForgottenDebugOutputInspection */
        var_dump($event->getArguments());

        echo "↑ List of arguments put's here ↑\n";
    }

    /**
     * @param Image[] $uzors
     * @return void
     * @throws ImageOutOfRangeException
     */
    public static function echoImages(array $uzors): void
    {
        foreach ($uzors as $key => $image) {
            echo "Image #$key\n";
            for ($y = 0; $y < $image->getHeight(); $y++) {
                for ($x = 0; $x < $image->getWidth(); $x++) {
                    echo static::$colors[$image->getPixel($x, $y)] ?? chr(61+$image->getPixel($x, $y));
                }
                echo "\n";
            }
            echo "\n";
        }
    }
}