<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7ba58db8480d5522eecd4d02414b375f
{
    public static $prefixesPsr0 = array (
        'F' => 
        array (
            'Flow' => 
            array (
                0 => __DIR__ . '/..' . '/flowjs/flow-php-server/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit7ba58db8480d5522eecd4d02414b375f::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}