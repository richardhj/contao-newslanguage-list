<?php

declare(strict_types=1);

/*
 * This file is part of richardhj/contao-newslanguage-list.
 *
 * @copyright  Copyright (c) 2020 Richard Henkenjohann
 * @author     Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @license    The Hippocratic License 2.0
 * @link       http://github.com/richardhj/contao-newslanguage-list
 */

namespace Richardhj\ContaoNewsLanguageList\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class RichardhjContaoNewsLanguageListExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');
    }
}
