<?php

// src/Admin/ClassementAdmin.php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class ClassementAdmin extends AbstractAdmin {
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
            : $object->getId().' '.$object->getEquipe()->getNom(); // shown in the breadcrumb on the create view
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('equipe', EntityType::class, ['class' => \App\Entity\Equipe::class, 'choice_label' => 'nom']);
        $formMapper->add('saison', TextType::class);
        $formMapper->add('journee', IntegerType::class);
        $formMapper->add('conference', ChoiceType::class, ['choices'=> [
                                                            'A'=>'A',
                                                            'B'=>'B']]);
        $formMapper->add('joue', IntegerType::class);
        $formMapper->add('nbPoints', IntegerType::class);
        $formMapper->add('victoire', IntegerType::class);
        $formMapper->add('nul', IntegerType::class);
        $formMapper->add('defaite', IntegerType::class);
        $formMapper->add('bo', IntegerType::class);
        $formMapper->add('bd', IntegerType::class);
        $formMapper->add('difference', TextType::class);
        $formMapper->add('classement', IntegerType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('equipe.nom',null, ['label'=>'Equipe']);
        $datagridMapper->add('saison');
        $datagridMapper->add('journee');
        $datagridMapper->add('classement');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('saison');
        $listMapper->add('equipe.nom',null, ['label'=>'Equipe']);
        $listMapper->add('journee');
        $listMapper->add('conference');
        $listMapper->add('classement');
        $listMapper->add('victoire');
        $listMapper->add('nul');
        $listMapper->add('defaite');
        $listMapper->add('bo');
        $listMapper->add('bd');
        $listMapper->add('difference');
        $listMapper->add('_action', null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }
}
