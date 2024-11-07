<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit24a0dd8f508fab725fc9e9a5b0c8c384
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Introvert\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Introvert\\' => 
        array (
            0 => __DIR__ . '/..' . '/mahatmaguru/intr-sdk-test/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit24a0dd8f508fab725fc9e9a5b0c8c384::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit24a0dd8f508fab725fc9e9a5b0c8c384::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit24a0dd8f508fab725fc9e9a5b0c8c384::$classMap;

        }, null, ClassLoader::class);
    }
}