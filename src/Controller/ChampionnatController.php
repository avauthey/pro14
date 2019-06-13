<?php

/**
 * Description of ChampionnatController
 *
 * @author Antoine
 */
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ChampionnatController extends AbstractController {
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        return $this->render('competition/accueilCompetition.html.twig', [
            'selected' => "Competition",
            'equipes'=> $lesEquipes,
            'active' => "Présentation",
        ]);
    }
    public function getClassement($nomSaison = null){
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Classement::class);
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $repositorySaison = $this->getDoctrine()->getRepository(\App\Entity\Saison::class);
        if($nomSaison == null){
            $saison = $repositorySaison->findBy(['actuelle'=>"Oui"]);
        }else{
            $saison = $repositorySaison->findBy(['saison'=>$nomSaison]);
        }
        $saisonsPrecedentes = $repositorySaison->findPrevious($saison[0]->getId());
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        $classementsA = array();
        $classementsB = array();
        $classementsBDDA = $repository->findAllClassementBySaisonConf($saison[0]->getSaison(),'A');
        foreach($classementsBDDA as $unClass){
            $classementsA[$unClass->getEquipe()->getId()][$unClass->getJournee()]=$unClass;
        }
        $classementsBDDB = $repository->findAllClassementBySaisonConf($saison[0]->getSaison(),'B');
        foreach($classementsBDDB as $unClass){
            $classementsB[$unClass->getEquipe()->getId()][$unClass->getJournee()]=$unClass;
        }
        $lastClassementA = $repository->findLastClassementPlayedByConf($saison[0]->getSaison(),'A');
        $lastClassementB = $repository->findLastClassementPlayedByConf($saison[0]->getSaison(),'B');
        return $this->render('competition/classement.html.twig', [
            'selected' => "Competition",
            'equipes'=> $lesEquipes,
            'classementsA'=> $classementsA,
            'classementsB'=> $classementsB,
            'active' => "Classement",
            'lastClassementA' => $lastClassementA,
            'lastClassementB' => $lastClassementB,
            'saison' => $saison[0]->getSaison(),
            'saisonsPrécédentes'=> $saisonsPrecedentes,
        ]);
    }
    
    public function getCalendrier($nomSaison = null){
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        $repositoryJournee = $this->getDoctrine()->getRepository(\App\Entity\Journee::class);
        $repositorySaison = $this->getDoctrine()->getRepository(\App\Entity\Saison::class);
        if($nomSaison == null){
            $saison = $repositorySaison->findBy(['actuelle'=>"Oui"]);
        }else{
            $saison = $repositorySaison->findBy(['saison'=>$nomSaison]);
        }
        $saisonsPrecedentes = $repositorySaison->findPrevious($saison[0]->getId());
        $calendrier = $repositoryJournee->findBy(['saison'=>$saison[0]->getSaison()], ['id'=>'ASC']);
        //var_dump($calendrier);
        $lesJournees = array();
        foreach($calendrier as $unCal){
            $lesJournees[$unCal->getJournee()][$unCal->getId()] = $unCal;
        }
        return $this->render('competition/calendrier.html.twig', [
            'selected' => "Competition",
            'equipes'=> $lesEquipes,
            'active' => "Calendrier / Résultats",
            'calendrier' => $lesJournees,
            'saison' => $saison[0]->getSaison(),
            'saisonsPrécédentes' => $saisonsPrecedentes,
        ]);
    }
}
