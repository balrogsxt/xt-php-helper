<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9f64ee3f5eefce0b28b4b601a28d27f0
{
    public static $prefixLengthsPsr4 = array (
        'x' => 
        array (
            'xt\\' => 3,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'xt\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9f64ee3f5eefce0b28b4b601a28d27f0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9f64ee3f5eefce0b28b4b601a28d27f0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
