<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Comment;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class CommentAdmin extends BaseAdmin
{
    private string $dateTimeFormat;

    public function setDateTimeFormat(string $dateTimeFormat)
    {
        $this->dateTimeFormat = $dateTimeFormat;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('post', null, [
                'label' => 'Příspěvek',
            ])
            ->add('title', TextType::class, [
                'label' => 'Nadpis',
            ])
            ->add('author', TextType::class, [
                'label' => 'Autor',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Obsah',
                'attr' => [
                    'rows' => 10,
                ],
            ]);
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = 'DESC';
        $sortValues[DatagridInterface::SORT_BY] = 'createdAt';
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('post.title', null, [
                'label' => 'Příspěvek',
            ])
            ->addIdentifier('title', null, [
                'label' => 'Nadpis',
            ])
            ->add('createdAt', TextType::class, [
                'label' => 'Odesláno',
                'accessor' =>
                    function (Comment $post) {
                        return $post->getCreatedAt()?->format(
                            $this->dateTimeFormat
                        );
                    },
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'header_class' => 'text-center',
                'actions' => [
                    'delete' => [
                        'template' => 'Admin/CRUD/list__action_delete.html.twig',
                    ],
                    'edit' => [],
                ],
                'header_style' => Config::COMMENT_LIST_ACTIONS_HEADER_STYLE,
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        if (!$this->isChild()) {
            $filter->add('post', null, [
                'label' => 'Příspěvek',
            ]);
        }
    }
}
