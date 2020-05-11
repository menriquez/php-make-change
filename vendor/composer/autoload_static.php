<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit02c786f5c804a67791548a970b0e0c47
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'G' => 
        array (
            'Garden\\Cli\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Garden\\Cli\\' => 
        array (
            0 => __DIR__ . '/..' . '/vanilla/garden-cli/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit02c786f5c804a67791548a970b0e0c47::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit02c786f5c804a67791548a970b0e0c47::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit02c786f5c804a67791548a970b0e0c47::$classMap;

        }, null, ClassLoader::class);
    }
}