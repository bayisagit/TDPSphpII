<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0ae6f371fb6cd8d6f75b1933a9fc9b4f
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0ae6f371fb6cd8d6f75b1933a9fc9b4f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0ae6f371fb6cd8d6f75b1933a9fc9b4f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0ae6f371fb6cd8d6f75b1933a9fc9b4f::$classMap;

        }, null, ClassLoader::class);
    }
}
