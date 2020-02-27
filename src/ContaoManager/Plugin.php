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

namespace Richardhj\ContaoNewsLanguageList\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Config\ConfigInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\NewsBundle\ContaoNewsBundle;
use Richardhj\ContaoNewsLanguageList\RichardhjContaoNewsLanguageListBundle;

/**
 * Contao Manager plugin.
 */
class Plugin implements BundlePluginInterface
{
    /**
     * Gets a list of autoload configurations for this bundle.
     *
     * @return ConfigInterface[]
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(RichardhjContaoNewsLanguageListBundle::class)
                ->setLoadAfter([ContaoNewsBundle::class]),
        ];
    }
}
