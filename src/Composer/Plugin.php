<?php

namespace Libaro\QualityTools\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    const PACKAGE_NAME = 'libaro-io/quality-tools';

    public static function getSubscribedEvents(): array
    {
        return [
            PackageEvents::POST_PACKAGE_INSTALL => 'postInstall',
        ];
    }

    public function postInstall(PackageEvent $event): void
    {
        $operation = $event->getOperation();

        if (! method_exists($operation, 'getPackage')) {
            return;
        }

        $package = $operation->getPackage();

        if ($package->getName() !== self::PACKAGE_NAME) {
            return;
        }

        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $projectDir = realpath(dirname(rtrim($vendorDir)));

        $targetFile = sprintf('%s/grumphp.yml', $projectDir);

        if (file_exists($targetFile)) {
            $event->getIO()->warning(
                sprintf('We see you already have a grumphp.yml at "%s" file, we won\'t overwrite it.', $targetFile),
            );
            return;
        }

        $sourceFile = realpath(__DIR__ . '/../../stubs/grumphp.yml.stub');

        copy($sourceFile, $targetFile);
    }

    public function activate(Composer $composer, IOInterface $io)
    {
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
}
