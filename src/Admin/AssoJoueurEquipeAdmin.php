<?php

// src/Admin/AssoJoueurEquipeAdmin.php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class AssoJoueurEquipeAdmin extends AbstractAdmin {
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
            : $object->getIdJoueur()->getPrenom().' '.$object->getIdJoueur()->getNom().'-> '.$object->getSaison(); // shown in the breadcrumb on the create view
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('idJoueur', EntityType::class, ['class' => \App\Entity\Joueur::class, 'choice_label' => 'fullName']);
        $formMapper->add('idEquipe', EntityType::class, ['class' => \App\Entity\Equipe::class, 'choice_label' => 'nom']);
        $formMapper->add('saison', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('idJoueur.nom',null,['label'=>'Joueur']);
        $datagridMapper->add('idEquipe.nom',null,['label'=>'Equipe']);
        $datagridMapper->add('saison');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('idJoueur.fullName',null,['label'=>'Joueur']);
        $listMapper->add('idEquipe.nom',null,['label'=>'Equipe']);
        $listMapper->add('saison');
        $listMapper->add('_action', null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }
}
