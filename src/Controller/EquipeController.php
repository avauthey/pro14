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
    public function getCalendrier($id,$nomSaison=null) {
        $repositorySaison = $this->getDoctrine()->getRepository(\App\Entity\Saison::class);
        if($nomSaison == null){
            $saison = $repositorySaison->findBy(["actuelle"=>"Oui"]);
        }else{
            $saison = $repositorySaison->findBy(["saison"=>$nomSaison]);
        }
        $saisonsPrecedentes = $repositorySaison->findPrevious($saison[0]->getId());
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $equipe = $repository->find($id);
        if (!$equipe) {
            throw $this->createNotFoundException(
                    'Pas d\'équipe pour l\'id '.$id
            );
        }
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        $repositoryJournee = $this->getDoctrine()->getRepository(\App\Entity\Journee::class);
        $calendrier = $repositoryJournee->findJourneeByIdEquipe($equipe->getId(), $saison[0]->getSaison());
        return $this->render('equipes/calendrier.html.twig', [
            'selected' => "Equipe",
            'active'=>'Calendrier / Résultats',
            'equipes'=>$lesEquipes,
            'equipe'=>$equipe,
            'calendrier'=>$calendrier,
            'saison'=>$saison[0]->getSaison(),
            'saisonsPrécédentes' =>$saisonsPrecedentes,
        ]);
    }
}
