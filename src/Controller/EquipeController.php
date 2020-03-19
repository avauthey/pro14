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
    
    public function getEffectif($id, $nomSaison = null){
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
        $repositoryJoueur = $this->getDoctrine()->getRepository(\App\Entity\AssoJoueurEquipe::class);
        $joueurs = $repositoryJoueur->findBy(['idEquipe'=>$equipe->getId(),'saison'=>$saison[0]->getSaison()]);
        //var_dump($joueurs);
        return $this->render('equipes/effectif.html.twig', [
            'selected' => "Equipe",
            'active'=>'Effectif',
            'equipes'=>$lesEquipes,
            'equipe'=>$equipe,
            'joueurs'=>$joueurs,
            'saison'=>$saison[0]->getSaison(),
            'saisonsPrécédentes' =>$saisonsPrecedentes,
        ]);
    }
    public function getArticles($id, $nomSaison=null){
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $equipe = $repository->find($id);
        if (!$equipe) {
            throw $this->createNotFoundException(
                    'Pas d\'équipe pour l\'id '.$id
            );
        }
        
        $repositoryTags = $this->getDoctrine()->getRepository(\App\Entity\Tags::class);
        $lesTagsEquipe = $repositoryTags->findBy(array('equipe'=>$equipe->getId()));
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        $repositorySaison = $this->getDoctrine()->getRepository(\App\Entity\Saison::class);
        if($nomSaison == null){
            $saison = $repositorySaison->findBy(["actuelle"=>"Oui"]);
        }else{
            $saison = $repositorySaison->findBy(["saison"=>$nomSaison]);
        }
        $lesArticlesJoueurs= array();
        //$saisonsPrecedentes = $repositorySaison->findPrevious($saison[0]->getId());
        $repositoryAssoJoueurEquipe = $this->getDoctrine()->getRepository(\App\Entity\AssoJoueurEquipe::class);
        $lesJoueurs = $repositoryAssoJoueurEquipe->findBy(array('idEquipe'=>$equipe->getId(),"saison"=>$saison[0]->getSaison()));
        foreach ($lesJoueurs as $unJoueur){
            $lesArticles = $repositoryTags->findBy(array('joueur'=>$unJoueur->getIdJoueur()));
            if(!empty($lesArticles)){
                foreach ($lesArticles as $unArticle){
                    $lesArticlesJoueurs[] = $unArticle;
                }
            }
        }
        /*var_dump($lesArticlesJoueurs);
        var_dump($lesTagsEquipe);*/
        //for
        $tagsTmp = array_merge($lesTagsEquipe, $lesArticlesJoueurs);
        //var_dump($tagsTmp);
        if(!empty($tagsTmp)){
            $taille = count($tagsTmp);
            for($i = $taille-2; $i >= 0; $i--){
                for($j = 0; $j <= $i; $j++){
                    if($tagsTmp[$j+1]->getId() < $tagsTmp[$j]->getId()){
                        $temp = $tagsTmp[$j+1];
                        $tagsTmp[$j+1] = $tagsTmp[$j];
                        $tagsTmp[$j] = $temp;
                    }
                }
            }
        }
        //var_dump($tagsTmp);
        $lesTags = array_reverse($tagsTmp);
        return $this->render('equipes/articles.html.twig', [
            'selected' => "Equipe",
            'active'=>'Article',
            'equipes'=>$lesEquipes,
            'equipe'=>$equipe,
            'tags' =>$lesTags,
        ]);
        
    }
    
    public function getStats($id) {
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $repositorySaison = $this->getDoctrine()->getRepository(\App\Entity\Saison::class);
        $repositoryAssoJoueurEquipe = $this->getDoctrine()->getRepository(\App\Entity\AssoJoueurEquipe::class);
        $repositoryJournee = $this->getDoctrine()->getRepository(\App\Entity\Journee::class); 
        $repositoryClassement = $this->getDoctrine()->getRepository(\App\Entity\Classement::class);
        $repositoryAssoJourneeJoueur = $this->getDoctrine()->getRepository(\App\Entity\AssoJoueurJournee::class);
        $equipe = $repository->find($id);
        if (!$equipe) {
            throw $this->createNotFoundException(
                    'Pas d\'équipe pour l\'id '.$id
            );
        }
        $saison = $repositorySaison->findBy(array('actuelle'=>'Oui'));
        //var_dump($saison);
        //$joueurs = $repositoryAssoJoueurEquipe->findBy(array('idEquipe'=>$equipe->getId(),'saison'=>$saison[0]->getSaison()));
        $lastClassement = $repositoryClassement->findLastByEquipe($equipe->getId());
        $journees = $repositoryJournee->findPointsByEquipe($saison[0]->getSaison(), $equipe->getId());
        $realisateurs = $repositoryAssoJourneeJoueur->findRealisateurByEquipe($saison[0]->getSaison(),$equipe->getId());
        $marqueurs = $repositoryAssoJourneeJoueur->findMarqueurByEquipe($saison[0]->getSaison(),$equipe->getId());
        $placages = $repositoryAssoJourneeJoueur->findPlaqueurByEquipe($saison[0]->getSaison(), $equipe->getId());
        $courses = $repositoryAssoJourneeJoueur->findCourseMetreByEquipe($saison[0]->getSaison(), $equipe->getId());
        $discipline = $repositoryAssoJourneeJoueur->findDisciplineByEquipe($saison[0]->getSaison(), $equipe->getId());
        //var_dump($realisateurs);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        return $this->render('equipes/stats.html.twig', [
            'selected' => "Equipe",
            'active'=>'Stats',
            'equipes'=>$lesEquipes,
            'equipe'=>$equipe,
            'saison'=>$saison[0],
            'journees' => $journees,
            'classement'=>$lastClassement[0],
            'realisateurs'=>$realisateurs,
            'marqueurs'=>$marqueurs,
            'plaqueurs'=> $placages,
            'coureurs'=>$courses,
            'fautifs'=>$discipline,
        ]);
    }
}
