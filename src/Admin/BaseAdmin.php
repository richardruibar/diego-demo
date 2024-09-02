<?php
declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

class BaseAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection
    ): void {
        $collection->remove('show');
    }

    protected function configureActionButtons(
        array $buttonList,
        string $action,
        ?object $object = null
    ): array {
        unset($buttonList['show']);

        return $buttonList;
    }

    protected function configureBatchActions(array $actions): array
    {
        return [];
    }
}