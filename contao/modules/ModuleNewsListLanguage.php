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
        /** @var PageModel $objPage */
        global $objPage;

        /** @var array $newsArchives */
        $newsArchives = $this->news_archives;
        /** @noinspection PhpUndefinedFieldInspection */
        $languageCheck = NewsArchiveModel::findByPk($newsArchives[0])->language;

        // Use the related (translated) news archive(s)
        if ($objPage->language !== $languageCheck) {
            $relatedArchives = [];

            /** @noinspection PhpUndefinedMethodInspection */
            $t = NewsArchiveModel::getTable();

            foreach ($newsArchives as $archive) {
                $relatedArchive = NewsArchiveModel::findOneBy(
                    [
                        "$t.master=?",
                        "$t.language=?",
                    ],
                    [
                        $archive,
                        $objPage->language,
                    ]
                );

                $relatedArchives[] = $relatedArchive->id;
            }

            if (count($relatedArchives) > 0) {
                $this->news_archives = $relatedArchives;
            }
        }

        parent::compile();
    }
}
