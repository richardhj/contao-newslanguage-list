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

use Contao\DataContainer;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class CheckNewsArchivesListener
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function onSaveCallback($value, DataContainer $dc)
    {
        if ('newslist_ml' !== $dc->activeRecord->type) {
            return $value;
        }

        $archives = $this->connection->createQueryBuilder()
            ->select('master', 'language')
            ->from('tl_news_archive')
            ->where('id IN (:ids)')
            ->setParameter('ids', StringUtil::deserialize($value, true), Connection::PARAM_STR_ARRAY)
            ->execute();

        $languages = [];

        while ($archive = $archives->fetch(FetchMode::STANDARD_OBJECT)) {
            if (!$archive->master) {
                throw new \LogicException('Only select masters');
            }

            $languages[] = $archive->language;
        }

        // Check if there is only one language
        if (\count(array_unique($languages)) > 1) {
            throw new \LogicException('Only select one language');
        }

        return $value;
    }
}
