<?php

namespace Libaro\QualityTools\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PluginInterface;

class Extra implements PluginInterface, EventSubscriberInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        echo 'ACTIVATE';
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        echo 'DEACTIVATE';
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        echo 'UNINSTALL';
    }

    public static function getSubscribedEvents()
    {
        return [
            PackageEvents::POST_PACKAGE_INSTALL => 'post',
        ];
    }

    public function post(PackageEvent $e): void
    {
        // TODO - copy grumphp stub to root of project if not already exists
    }
}
