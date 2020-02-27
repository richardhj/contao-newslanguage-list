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

namespace Richardhj\ContaoNewsLanguageList\EventListener\DataContainer;

use Contao\ModuleModel;
use Contao\ModuleNewsList;
use Contao\NewsArchiveModel;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ModuleNewsListLanguage.
 */
class NewsListMultilingual extends ModuleNewsList
{
    /** @noinspection MagicMethodsValidityInspection */

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct()
    {
    }

    public function __invoke(ModuleModel $model, string $section): Response
    {
        parent::__construct($model, $section);

        return new Response($this->generate());
    }

    protected function compile()
    {
        /* @var PageModel $objPage */
        global $objPage;

        $newsArchives  = $this->news_archives;
        $languageCheck = NewsArchiveModel::findByPk($newsArchives[0])->language;

        // If desired language does not match, use the related (translated) news archive(s)
        if ($objPage->language !== $languageCheck) {
            $relatedArchives = [];

            $t = NewsArchiveModel::getTable();

            foreach ($newsArchives as $archiveId) {
                $relatedArchive = NewsArchiveModel::findOneBy(
                    [
                        "$t.master=?",
                        "$t.language=?",
                    ],
                    [
                        $archiveId,
                        $objPage->language,
                    ]
                );

                if (null !== $relatedArchive) {
                    $relatedArchives[] = $relatedArchive->id;
                }
            }

            if (\count($relatedArchives) > 0) {
                $this->news_archives = $relatedArchives;
            }
        }

        parent::compile();
    }
}
