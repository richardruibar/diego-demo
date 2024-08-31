<?php

namespace App\Admin;

use App\Entity\Post;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class PostAdmin extends BaseAdmin
{
    public function __construct(
        private readonly string $dateTimeFormat,
        ?string $code = null,
        ?string $class = null,
        ?string $baseControllerName = null
    ) {
        parent::__construct($code, $class, $baseControllerName);
    }
    
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('title', TextType::class, [
                'label' => 'Nadpis',
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'required' => false,
            ])
            ->add('author', TextType::class, [
                'label' => 'Autor',
            ])
            ->add('annotation', TextareaType::class, [
                'label' => 'Anotace',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Obsah',
                'attr' => [
                    'rows' => 10,
                ],
            ])
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('title', null, [
                'label' => 'Nadpis',
            ])
            ->add('slug', null, [
                'label' => 'Slug',
            ])
            ->add('createdAt', TextType::class, [
                'label' => 'Publikováno',
                'accessor' =>
                    function (Post $post) {
                        return $post->getCreatedAt()->format($this->dateTimeFormat);
                    },
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'header_class' => 'text-center',
                'actions' => [
                    'delete' => [],
                    'edit' => [],
                ],
                'header_style' => 'width: 200px;',
            ])
        ;
    }
}