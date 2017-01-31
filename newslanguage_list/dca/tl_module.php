<?php

/**
 * contao-newslanguage-list extension for Contao Open Source CMS
 *
 * Copyright (c) 2013-2017 Richard Henkenjohann
 *
 * @package    Newslanguage
 * @subpackage NewslanguageList
 * @author     Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist_ml'] = $GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'];


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['news_archives']['save_callback'] = [
    ['NewsLanguageListHelper', 'checkArchives'],
];
