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
 * Class NewsLanguageListHelper
 */
class NewsLanguageListHelper
{

    /**
     * Check if selection is possible
     *
     * @param mixed         $value
     * @param DataContainer $dc
     *
     * @return mixed
     * @throws Exception
     */
    public function checkArchives($value, DataContainer $dc)
    {
        if ('newslist_ml' === $dc->activeRecord->type) {
            $archives  = \Database::getInstance()->query(
                "SELECT master,language FROM tl_news_archive WHERE id IN (".implode(',', deserialize($value, true)).")"
            );
            $languages = array();

            while ($archives->next()) {
                if (0 != $archives->master) {
                    throw new Exception('Only select masters');
                }

                $languages[] = $archives->language;
            }

            // Check if there is only one language
            if (count(array_unique($languages)) > 1) {
                throw new Exception('Only select one language');
            }
        }

        return $value;
    }
}
