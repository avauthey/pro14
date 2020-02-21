<?php
// src/Admin/EquipeAdmin.php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



/**
 * Description of EquipeAdmin
 *
 * @author Antoine
 */
class EquipeAdmin extends AbstractAdmin
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
            : $object->getNom(); // shown in the breadcrumb on the create view
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('nom', TextType::class);
        $formMapper->add('maillotDomicile', TextType::class);
        $formMapper->add('maillotExterieur', TextType::class);
        $formMapper->add('dateCreation', TextType::class);
        $formMapper->add('histoire', TextareaType::class, ['attr'=>['rows'=>'5']]);
        $formMapper->add('logo', TextType::class);
        $formMapper->add('ville', TextType::class);
        $formMapper->add('stade', TextType::class);
        $formMapper->add('capaciteStade', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('nom');
        $datagridMapper->add('ville');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('nom');
        $listMapper->add('dateCreation');
        $listMapper->add('ville');
        $listMapper->add('stade');
        $listMapper->add('_action', null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }
}
