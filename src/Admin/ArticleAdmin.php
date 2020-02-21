<?php
// src/Admin/ArticleAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


final class ArticleAdmin extends AbstractAdmin
{
    protected $datagridValues = [

        // display the first page (default = 1)
        '_page' => 1,

        // reverse order (default = 'ASC')
        '_sort_order' => 'DESC',

        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'id',
    ];
    public function toString($object)
    {
        return $object instanceof Article
            ? $object->getTitle()
            : $object->getTitre(); // shown in the breadcrumb on the create view
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('titre', TextType::class);
        $formMapper->add('dateCreation', DateType::class);
        $formMapper->add('dateDerniereModification', DateType::class, ['empty_data'=>'','required'=>false,'widget' => 'choice', ]);
        $formMapper->add('contenu', TextareaType::class, ['attr'=>['rows'=>'10']]);
        $formMapper->add('miniature', TextType::class);
        $formMapper->add('statut', ChoiceType::class,['choices'=> ['Brouillon'=>'Brouillon','Publié'=>'Publié','Archivé'=>'Archivé']]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('titre');
        $datagridMapper->add('statut');
        $datagridMapper->add('dateCreation');
        $datagridMapper->add('dateDerniereModification');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('titre');
        $listMapper->add('statut');
        $listMapper->add('dateCreation','date',['format'=>'d/m/Y']);
        $listMapper->add('dateDerniereModification','date',['format'=>'d/m/Y']);
        $listMapper->add('_action', null, [
            'actions' => [
                'show' => [],
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper->add('titre', null, ['label'=>'Titre']);
        $showMapper->add('statut', null, ['label'=>'Statut']);
        $showMapper->add('dateCreation', 'date', ['format'=>'d/m/Y','label'=>'Date Creation']);
        $showMapper->add('dateDerniereModification', 'date', ['format'=>'d/m/Y','label'=>'Date de dernière modification']);
        $showMapper->add('miniature', "text", ['label'=>'Miniature']);
        /*$showMapper->add('article.miniature', 'file', array(
            'prefix' => '/images/articles/article_article.id/',
            'width' => 75,
            'height' => 75,
            'label'=>'Miniature',
            
        ));*/
        $showMapper->add('article.contenu', 'html', ['label'=>'Contenu']);
    }
}
