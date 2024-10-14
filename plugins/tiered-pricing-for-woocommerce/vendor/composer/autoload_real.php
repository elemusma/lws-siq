<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit731275dc297524451e15f7e0b2486d83
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit731275dc297524451e15f7e0b2486d83', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit731275dc297524451e15f7e0b2486d83', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit731275dc297524451e15f7e0b2486d83::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
