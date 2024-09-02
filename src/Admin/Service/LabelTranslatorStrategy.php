<?php
namespace App\Admin\Service;

use Sonata\AdminBundle\Translator\LabelTranslatorStrategyInterface;

/**
 * LabelTranslatorStrategy
 *
 * Used in Sonata Admin breadcrumbs
 *
 * @author Richard Ruibar <richard@ruibar.cz>
 */
class LabelTranslatorStrategy implements LabelTranslatorStrategyInterface
{
    private const TRANSLATIONS = [
        '_actions' => 'Akce',   // ListMapper::NAME_ACTIONS
        'Comment_list' => 'Komentáře',
        'Post_list' => 'Příspěvky',
    ];

    public function getLabel(string $label, string $context = '', string $type = ''): string
    {
        if (isset(self::TRANSLATIONS[$label])) {
            return self::TRANSLATIONS[$label];
        }

        return $label;
    }
}