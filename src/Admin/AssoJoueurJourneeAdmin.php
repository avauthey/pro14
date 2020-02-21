<?php

// src/Admin/AssoJoueurJourneeAdmin.php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class AssoJoueurJourneeAdmin extends AbstractAdmin {
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
            : $object->getJoueur()->getPrenom().' '.$object->getJoueur()->getNom().'-> '.$object->getJournee()->getId(); // shown in the breadcrumb on the create view
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('joueur', EntityType::class, ['class' => \App\Entity\Joueur::class, 'choice_label' => 'fullName']);
        $formMapper->add('equipe', EntityType::class, ['class' => \App\Entity\Equipe::class, 'choice_label' => 'nom']);
        $formMapper->add('journee', EntityType::class, ['class' => \App\Entity\Journee::class, 'choice_label' => 'infoJournee']);
        $formMapper->add('poste', EntityType::class, ['class' => \App\Entity\Poste::class, 'choice_label' => 'nom']);
        $formMapper->add('numero', IntegerType::class);
        $formMapper->add('points', IntegerType::class);
        $formMapper->add('essais', IntegerType::class);
        $formMapper->add('transformation', IntegerType::class);
        $formMapper->add('penalite', IntegerType::class);
        $formMapper->add('drops', IntegerType::class);
        $formMapper->add('placagesReussis', IntegerType::class);
        $formMapper->add('placagesManques', IntegerType::class);
        $formMapper->add('assist', IntegerType::class);
        $formMapper->add('offload', IntegerType::class);
        $formMapper->add('passe', IntegerType::class);
        $formMapper->add('course', IntegerType::class);
        $formMapper->add('metreGagne', IntegerType::class);
        $formMapper->add('perce', IntegerType::class);
        $formMapper->add('defenseurBattu', IntegerType::class);
        $formMapper->add('penaliteConcedee', IntegerType::class);
        $formMapper->add('CJ', IntegerType::class);
        $formMapper->add('CR', IntegerType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('joueur.nom',null,['label'=>'Joueur']);
        $datagridMapper->add('equipe.nom',null,['label'=>'Equipe']);
        $datagridMapper->add('poste.nom',null,['label'=>'Joueur']);
        $datagridMapper->add('journee.journee',null,['label'=>'Joueur']);
        $datagridMapper->add('numero');
        $datagridMapper->add('points');
        $datagridMapper->add('essais');
        $datagridMapper->add('transformation');
        $datagridMapper->add('penalite');
        $datagridMapper->add('drops');
        $datagridMapper->add('placagesReussis');
        $datagridMapper->add('placagesManques');
        $datagridMapper->add('assist');
        $datagridMapper->add('offload');
        $datagridMapper->add('passe');
        $datagridMapper->add('course');
        $datagridMapper->add('metreGagne');
        $datagridMapper->add('perce');
        $datagridMapper->add('defenseurBattu');
        $datagridMapper->add('penaliteConcedee');
        $datagridMapper->add('CJ');
        $datagridMapper->add('CR');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('journee.saison',null,['label'=>'Saison']);
        $listMapper->add('journee.journee',null,['label'=>'Journee']);
        $listMapper->add('joueur.fullName',null,['label'=>'Joueur']);
        $listMapper->add('equipe.nom',null,['label'=>'Equipe']);
        $listMapper->add('poste.nom',null,['label'=>'Joueur']);
        
        $listMapper->add('numero');
        /*$listMapper->add('points');
        $listMapper->add('essais');
        $listMapper->add('transformation');
        $listMapper->add('penalite');
        $listMapper->add('drops');
        $listMapper->add('placagesReussis');
        $listMapper->add('placagesManques');
        $listMapper->add('assist');
        $listMapper->add('offload');
        $listMapper->add('passe');
        $listMapper->add('course');
        $listMapper->add('metreGagne');
        $listMapper->add('perce');
        $listMapper->add('defenseurBattu');
        $listMapper->add('penaliteConcedee');
        $listMapper->add('CJ');
        $listMapper->add('CR');*/
        $listMapper->add('_action', null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }
}
