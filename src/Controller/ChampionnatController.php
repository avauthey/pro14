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
    public function getClassement($nomSaison = null){
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Classement::class);
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $repositorySaison = $this->getDoctrine()->getRepository(\App\Entity\Saison::class);
        $repositoryJournee = $this->getDoctrine()->getRepository(\App\Entity\AssoJoueurJournee::class);
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
        $lesRealisateurs = $repositoryJournee->findRealisateur($saison[0]->getSaison());
        $lesMarqueurs = $repositoryJournee->findMarqueur($saison[0]->getSaison());
        return $this->render('competition/classement.html.twig', [
            'selected' => "Competition",
            'equipes'=> $lesEquipes,
            'classementsA'=> $classementsA,
            'classementsB'=> $classementsB,
            'active' => "Classement",
            'lastClassementA' => $lastClassementA,
            'lastClassementB' => $lastClassementB,
            'realisateurs'=>$lesRealisateurs,
            'marqueurs'=>$lesMarqueurs,
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
    
    public function getJournee($id){
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        $repositoryJournee = $this->getDoctrine()->getRepository(\App\Entity\Journee::class);
        $repositoryStatsMatch = $this->getDoctrine()->getRepository(\App\Entity\StatsMatch::class);
        $journee = $repositoryJournee->find($id);
        if (!$journee) {
            throw $this->createNotFoundException(
                    'Page non trouvée. Pas de journée pour l\'id '.$id
            );
        }
        $repositoryAssoJoueurJournee = $this->getDoctrine()->getRepository(\App\Entity\AssoJoueurJournee::class);
        $equipeHome = $repositoryAssoJoueurJournee->findByJourneeAndEquipe($journee->getId(),$journee->getIdEquipeHome());
        $equipeAway = $repositoryAssoJoueurJournee->findByJourneeAndEquipe($journee->getId(),$journee->getIdEquipeAway());
        $statsMatch = $repositoryStatsMatch->findBy(array('journee'=>$journee->getId()));
        //var_dump($statsMatch);
        return $this->render('competition/journee.html.twig', [
            'selected' => "Competition",
            'equipes'=> $lesEquipes,
            'journee'=> $journee,
            'equipeHome'=>$equipeHome,
            'equipeAway'=>$equipeAway,
            'statsMatch'=>$statsMatch,
        ]);
    }
        
    public function getPresse(){
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        
        $data  = array();
        /*$xml = simplexml_load_file("http://feeds.bbci.co.uk/sport/rugby-union/rss.xml",'SimpleXMLElement', LIBXML_NOCDATA);
        foreach ($xml->channel->item as $element){
            //var_dump($element);
            if((strpos($element->title,"Pro14")!=false || strpos($element->description,"Pro14")!=false) && !in_array($element, $data)){
                $date = explode(' ',$element->pubDate);
                $data["$date[0] $date[1] $date[2] $date[3]"][] = $element;
            }
            foreach ($lesEquipes as $uneEquipe){
                if((strpos($element->title,$uneEquipe['nom'])!=false || strpos($element->description,$uneEquipe['nom'])!=false) && !in_array($element, $data)){
                    $date = explode(' ',$element->pubDate);
                    $data["$date[0] $date[1] $date[2] $date[3]"][] = $element;
                }
            }
        }*/
        for($i=0; $i<5; $i++){
            $filename = "https://www.pro14.rugby/api/v1/newsfeed/latestnews?page=$i&pageSize=10";        
            $file_headers = @get_headers($filename);
            if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                $exists = false;
            }
            else {
                $exists = true;
            }
            if($filename != false){
                $json = file_get_contents($filename);
                if($json != false){
                    $tmp = json_decode($json,true);
                    $articles = $tmp['articles'];
                    foreach($articles as $unArticle){
                        $lien = $unArticle['url'];
                        $dateTab = explode("T", $unArticle['publishDate']);
                        $article = $unArticle['heroMedia']['title'];
                        $data["$dateTab[0]"]["$lien"] = $article;
                    }
                }
            }
        }
        return $this->render('competition/presse.html.twig', [
            'selected' => "Competition",
            'equipes'=> $lesEquipes,
            'active' => "Presse",
            'presses' => $data,
        ]);
    }
}
