<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use Symfony\Component\DomCrawler\Form;

class SonataFormHelper
{
    public static function getFormPrefix(Form $form): string
    {
        foreach ($form->all() as $name => $field) {
            if (str_contains($name, '[_token]')) {
                return str_replace('[_token]', '', $name);
            }
        }

        throw new \InvalidArgumentException('Unable to extract Sonata Form prefix');
    }
}
