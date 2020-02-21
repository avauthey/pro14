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
        $repositoryPalmares = $this->getDoctrine()->getRepository(\App\Entity\Palmares::class);
        $lesPalmares = $repositoryPalmares->findAll();
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        return $this->render('competition/accueilCompetition.html.twig', [
            'selected' => "Competition",
            'equipes'=> $lesEquipes,
            'palmares'=>$lesPalmares,
            'active' => "Présentation",
        ]);
    }
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
                    'Fuck off! Pas de journée pour l\'id '.$id
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
    
    public function getArticle($id){
        $repositoryArticle = $this->getDoctrine()->getRepository(\App\Entity\Article::class);
        $article = $repositoryArticle->find($id);
        if (!$article) {
            throw $this->createNotFoundException(
                    'Fuck off! Pas d\'article  pour l\'id '.$id
            );
        }
        $repositoryTags = $this->getDoctrine()->getRepository(\App\Entity\Tags::class);
        $lesTags = $repositoryTags->findBy(array('article'=>$article->getId()));
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        return $this->render('competition/unArticle.html.twig', [
            'selected' => "Competition",
            'equipes'=> $lesEquipes,
            'article' => $article,
            'tags'=>$lesTags,
        ]);
    }
    public function getArticles() {
        $repositoryArticle = $this->getDoctrine()->getRepository(\App\Entity\Article::class);
        $articles = $repositoryArticle->findBy(['statut'=>'Publié'],['id'=>'DESC']);
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        return $this->render('competition/articles.html.twig', [
            'selected' => "Competition",
            'equipes'=> $lesEquipes,
            'active' => "Article",
            'articles' => $articles,
        ]);
    }
    
    public function getPresse(){
        $today = date('Y/m/d');
        $data = array();
        $fin = date('Y/m/d', strtotime('-7 days', strtotime($today)));
        $date = $today;
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME, "fr_FR", "French");
        while($date>=$fin){
            $url = "https://www.pro14rugby.org/".$date."/rss";
            $xml = simplexml_load_file($url);
            foreach ($xml->channel->item as $element){
                //$data[date("l d F Y",strtotime($date))][$element->title->__toString()] = $element->link->__toString();
                $data[utf8_encode(ucfirst(strftime("%A %d %B %Y",strtotime($date))))][$element->title->__toString()] = $element->link->__toString();
            }
            $date = date('Y/m/d', strtotime('-1 days', strtotime($date)));
        }
        //var_dump($data);
        
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        return $this->render('competition/presse.html.twig', [
            'selected' => "Competition",
            'equipes'=> $lesEquipes,
            'active' => "Presse",
            'presses' => $data,
        ]);
    }
}
