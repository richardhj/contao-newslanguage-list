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
 * Class ModuleNewsListLanguage
 */
class ModuleNewsListLanguage extends ModuleNewsList
{

    /**
     * Generate the module
     */
    protected function compile()
    {
        $language = $GLOBALS['TL_LANGUAGE'];

        $checkArchive = \Database::getInstance()
            ->prepare("SELECT language FROM tl_news_archive WHERE id=?")
            ->execute($this->news_archives[0]);

        // Use the related (translated) news archive(s)
        if ($language != $checkArchive->language) {
            $relatedArchives = [];

            foreach (deserialize($this->news_archives, true) as $archive) {
                $relatedArchive = \Database::getInstance()
                    ->prepare("SELECT id FROM tl_news_archive WHERE master=? AND language=?")
                    ->limit(1)
                    ->execute($archive, $language);

                $relatedArchives[] = $relatedArchive->id;
            }

            $this->news_archives = (count($relatedArchives) > 0)
                ? $relatedArchives
                : $this->news_archives;
        }

        parent::compile();
    }
}
