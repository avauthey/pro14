<?php
// src/Admin/JoueurAdmin.php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


/**
 * Description of EquipeAdmin
 *
 * @author Antoine
 */
class JoueurAdmin extends AbstractAdmin
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
            : $object->getPrenom().' '.$object->getNom(); // shown in the breadcrumb on the create view
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('prenom', TextType::class);
        $formMapper->add('nom', TextType::class);
        $formMapper->add('dateNaissance', DateType::class, ['widget'=>'single_text']);
        $formMapper->add('villeNaissance', TextType::class,['required'=>false]);
        $formMapper->add('paysNaissance', TextType::class);
        $formMapper->add('photo', TextType::class,['required'=>false]);
        $formMapper->add('poids', TextType::class,['required'=>false]);
        $formMapper->add('taille', TextType::class,['required'=>false]);
        $formMapper->add('poste', EntityType::class, ['class' => \App\Entity\Poste::class, 'choice_label' => 'nom']);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('nom');
        $datagridMapper->add('prenom');
        $datagridMapper->add('paysNaissance');
        $datagridMapper->add('dateNaissance');
        /*$datagridMapper->add('taille');
        $datagridMapper->add('poids');*/
        $datagridMapper->add('poste.nom');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('nom');
        $listMapper->add('prenom');
        $listMapper->add('dateNaissance','date',['format'=>'d/m/Y']);        
        $listMapper->add('paysNaissance');
        $listMapper->add('poste.nom');
        $listMapper->add('_action', null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }
}
