<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfcb209b6f7aa2e6093f8c5969693b18d
{
    public static $files = array (
        '45e8c92354af155465588409ef796dbc' => __DIR__ . '/../..' . '/lib/base.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitfcb209b6f7aa2e6093f8c5969693b18d::$classMap;

        }, null, ClassLoader::class);
    }
}
