<?php
// src/Admin/TagsAdmin.php
namespace App\Admin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TagsAdmin extends AbstractAdmin {
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
            : 'Tags n°'.$object->getId(); // shown in the breadcrumb on the create view
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('article', EntityType::class, ['class' => \App\Entity\Article::class, 'choice_label' => 'titre']);
        $formMapper->add('equipe', EntityType::class, ['class' => \App\Entity\Equipe::class, 'choice_label' => 'nom', 'required'=>false]);
        $formMapper->add('joueur', EntityType::class, ['class' => \App\Entity\Joueur::class, 'choice_label' => 'fullName', 'required'=>false]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('article.titre',null,['label'=>'Article']);
        $datagridMapper->add('equipe.nom',null,['label'=>'Equipe']);
        $datagridMapper->add('joueur.nom',null,['label'=>'Joueur']);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('article.titre',null,['label'=>'Article']);
        $listMapper->add('article.statut',null,['label'=>'Statut']);
        $listMapper->add('equipe.nom',null,['label'=>'Equipe']);
        $listMapper->add('joueur.fullName',null,['label'=>'Joueur']);
        $listMapper->add('_action', null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }
}
