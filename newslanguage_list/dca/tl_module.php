<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Richard Henkenjohann 2013
 * @author     Richard Henkenjohann
 * @package    News
 * @license    LGPL
 * @filesource
 */


/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist_ml'] = $GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'];


/**
 * Callbacks
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['news_archives']['save_callback'] = array(array('tl_module_newslanguage_list', 'checkArchives'));


/**
 * Class tl_module_newslanguage_list
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Richard Henkenjohann 2013
 * @author     Richard Henkenjohann
 * @package    Controller
 */
class tl_module_newslanguage_list extends Backend
{
	/**
	 * Construct the class
	 */
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Check if selection is possible
	 *
	 * @param mixed $varValue
	 * @param DataContainer $dc
	 * @return mixed
	 * @throws Exception
	 */
	public function checkArchives($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord->type == 'newslist_ml')
		{
			$arrArchives = deserialize($varValue);
			$objArchives = $this->Database->query("SELECT master,language FROM tl_news_archive WHERE id IN (" . implode(',', $arrArchives) . ")");
			$arrLanguages = array();

			while ($objArchives->next())
			{
				if ($objArchives->master != 0)
				{
					throw new Exception("Only select masters");
				}

				$arrLanguages[] = $objArchives->language;
			}

			// Check if there is only one language
			if (count(array_unique($arrLanguages)) > 1)
			{
				throw new Exception('Only select one language');
			}
		}

		return $varValue;
	}
}
