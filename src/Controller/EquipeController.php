<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * Description of EquipeController
 *
 * @author Antoine
 */
class EquipeController extends AbstractController {
    
    public function getUneEquipe($id) {
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $equipe = $repository->find($id);
        if (!$equipe) {
            throw $this->createNotFoundException(
                    'Pas d\'équipe pour l\'id '.$id
            );
        }
        $lesEquipes = $repository->findAllByNomOrder('ASC');
    
        return $this->render('equipes/accueilEquipe.html.twig', [
            'selected' => "Equipe",
            'equipes'=>$lesEquipes,
            'active'=>'Présentation',
            'equipe'=>$equipe,
        ]);
    }
    
    public function getEquipes() {
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        return $this->render('equipes/lesEquipes.html.twig', [
            'selected' => "Equipe",
            'equipes'=>$lesEquipes,
        ]);
    }
}
