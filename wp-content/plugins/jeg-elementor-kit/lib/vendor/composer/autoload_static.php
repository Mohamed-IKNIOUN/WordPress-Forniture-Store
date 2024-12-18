<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit705f40a697515a9776bbee0842dcae96
{
    public static $prefixLengthsPsr4 = array (
        'e' => 
        array (
            'enshrined\\svgSanitize\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'enshrined\\svgSanitize\\' => 
        array (
            0 => __DIR__ . '/..' . '/enshrined/svg-sanitize/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit705f40a697515a9776bbee0842dcae96::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit705f40a697515a9776bbee0842dcae96::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit705f40a697515a9776bbee0842dcae96::$classMap;

        }, null, ClassLoader::class);
    }
}
