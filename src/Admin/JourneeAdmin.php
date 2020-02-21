<?php
// src/Admin/JourneeAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class JourneeAdmin extends AbstractAdmin
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
            : 'Journée n°'.$object->getId(); // shown in the breadcrumb on the create view
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        //$formMapper->add('id', TextType::class);
        $formMapper->add('saison', TextType::class);
        //$formMapper->add('saison', EntityType::class, ['class' => \App\Entity\Saison::class, 'choice_label' => 'saison', 'choice_value' => 'saison']);
        $formMapper->add('journee', IntegerType::class);
        $formMapper->add('idEquipeHome', EntityType::class, ['class' => \App\Entity\Equipe::class, 'choice_label' => 'nom']);
        $formMapper->add('idEquipeAway', EntityType::class, ['class' => \App\Entity\Equipe::class, 'choice_label' => 'nom']);
        $formMapper->add('idArbitreCentral', EntityType::class, ['class' => \App\Entity\Arbitre::class, 'choice_label' => 'nom','required'=>false]);
        $formMapper->add('scoreHome', IntegerType::class, ['required'=>false]);
        $formMapper->add('scoreAway', IntegerType::class, ['required'=>false]);
        $formMapper->add('scoreAway', IntegerType::class, ['required'=>false]);
        $formMapper->add('BPHome', ChoiceType::class, ['choices'=> [
                                                            'Oui'=>'Oui',
                                                            'Non'=>'Non',
                                                            'Non joué'=>'']
                                                        ,'label' => 'Bonus offensif equipe domicile', 'required'=>false,'expanded'=>true,'multiple'=>false]);
        $formMapper->add('BPAway', ChoiceType::class, ['choices'=> [
                                                            'Oui'=>'Oui',
                                                            'Non'=>'Non',
                                                            'Non joué'=>'']
                                                        ,'label' => 'Bonus offensif equipe extérieur', 'required'=>false,'expanded'=>true,'multiple'=>false]);
        $formMapper->add('BDHome', ChoiceType::class, ['choices'=> [
                                                            'Oui'=>'Oui',
                                                            'Non'=>'Non',
                                                            'Non joué'=>'']
                                                        ,'label' => 'Bonus défensif equipe domicile', 'required'=>false,'expanded'=>true,'multiple'=>false]);
        $formMapper->add('BDAway', ChoiceType::class, ['choices'=> [
                                                            'Oui'=>'Oui',
                                                            'Non'=>'Non',
                                                            'Non joué'=>'']
                                                        ,'label' => 'Bonus défensif equipe extérieur', 'required'=>false,'expanded'=>true,'multiple'=>false]);
        $formMapper->add('jour', DateType::class, ['empty_data'=>'','required'=>false,'widget' => 'choice', ]);
        $formMapper->add('heure', TextType::class, ['required'=>false]);
        $formMapper->add('lieu', TextType::class, ['required'=>false]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        $datagridMapper->add('saison');
        $datagridMapper->add('journee');
        $datagridMapper->add('idEquipeHome.nom');
        $datagridMapper->add('idEquipeAway.nom');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('saison');
        $listMapper->add('journee');
        $listMapper->add('idEquipeHome.nom');
        $listMapper->add('idEquipeAway.nom');
        $listMapper->add('_action', null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }
}
