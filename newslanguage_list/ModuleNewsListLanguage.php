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
 * Class ModuleNewsListLanguage
 * * based on ModuleNewsList
 *
 * Front end module "news list language".
 * @copyright  Richard Henkenjohann 2013
 * @author     Richard Henkenjohann
 * @package    Controller
 */
class ModuleNewsListLanguage extends ModuleNewsList
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_newslist';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		return parent::generate();
	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$objCheckArchive = $this->Database->prepare("SELECT language FROM tl_news_archive WHERE id=?")
		                                  ->execute($this->news_archives[0]);

		// Update archives if languages aren't coincident
		if ($GLOBALS["TL_LANGUAGE"] != $objCheckArchive->language)
		{
			$arrRelatedArchives = array();

			foreach ($this->news_archives as $archive)
			{
				$objRelatedArchive = $this->Database->prepare("SELECT id FROM tl_news_archive WHERE master=? AND language=?")
				                                    ->limit(1)
				                                    ->execute($archive, $GLOBALS["TL_LANGUAGE"]);

				$arrRelatedArchives[] = $objRelatedArchive->id;
			}

			$this->news_archives = (count($arrRelatedArchives) > 0) ? $arrRelatedArchives : $this->news_archives;
		}

		parent::compile();
	}
}
