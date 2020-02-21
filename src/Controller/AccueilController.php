<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * Description of AccueilController
 *
 * @author Antoine
 */
class AccueilController extends AbstractController {
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $repositoryJournee = $this->getDoctrine()->getRepository(\App\Entity\Journee::class);
        $repositoryClassement = $this->getDoctrine()->getRepository(\App\Entity\Classement::class);
        $repositorySaison = $this->getDoctrine()->getRepository(\App\Entity\Saison::class);
        $saison = $repositorySaison->findBy(["actuelle"=>"Oui"]);
        //var_dump($saison);
        $lastJournee = $repositoryJournee->findLastJourneePlayed($saison[0]->getSaison());
        //var_dump($lastJournee);
        if(empty($lastJournee)){
            $saisonB = $repositorySaison->findBy(["actuelle"=>"Non"],['id'=>'desc']);
            $lastJournee =  $repositoryJournee->findLastJourneePlayed($saisonB[0]->getSaison());
            //var_dump($saison[0]->getSaison());
        }
       // var_dump($lastJournee);
        $lastClassementA = $repositoryClassement->findLastClassementPlayedByConf($saison[0]->getSaison(),'A');
        //var_dump($lastClassementA);
        if(empty($lastClassementA)){
            $saisonB = $repositorySaison->findBy(["actuelle"=>"Non"],['id'=>'desc']);
            $lastClassementA =  $repositoryClassement->findLastClassementPlayedByConf($saisonB[0]->getSaison(),'A');
        }
        $lastClassementB = $repositoryClassement->findLastClassementPlayedByConf($saison[0]->getSaison(),'B');
        if(empty($lastClassementB)){
            $saisonB = $repositorySaison->findBy(["actuelle"=>"Non"],['id'=>'desc']);
            $lastClassementB =  $repositoryClassement->findLastClassementPlayedByConf($saisonB[0]->getSaison(),'B');
        }
        
        $repositoryArticle = $this->getDoctrine()->getRepository(\App\Entity\Article::class);
        $lastArticle = $repositoryArticle->findLastFive();
        //var_dump($lastClassementA);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        $today = date('Y/m/d');
        $data = array();
        $i =  0;
        while(count($data)<=6){
            $date = date('Y/m/d', strtotime('-'.$i.' days', strtotime($today)));
            $url = "https://www.pro14rugby.org/".$date."/rss";
            $xml = simplexml_load_file($url);
            foreach ($xml->channel->item as $element){
                $data[$element->title->__toString()] = $element->link->__toString();
            }
            $i++;
        }
        //var_dump($xml);
        return $this->render('accueil/accueil.html.twig', [
            'selected' => "Accueil",
            'equipes'=>$lesEquipes,
            'lastJournee' => $lastJournee,
            'classementA' => $lastClassementA,
            'classementB' => $lastClassementB,
            'articles' => $lastArticle,
            'presse'=>$data,
        ]);
    }
    public function getPresentation(){
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        return $this->render('accueil/presentation.html.twig', [
            'selected' => "Accueil",
            'equipes'=>$lesEquipes,
        ]);
    }
}
