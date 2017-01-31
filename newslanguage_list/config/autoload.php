<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'NewsLanguageListHelper' => 'system/modules/newslanguage_list/classes/NewsLanguageListHelper.php',

	// Modules
	'ModuleNewsListLanguage' => 'system/modules/newslanguage_list/modules/ModuleNewsListLanguage.php',
));
