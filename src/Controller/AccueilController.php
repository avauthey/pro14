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
            $saison = $repositorySaison->findBy(["id"=>$saison[0]->getId()-1]);
            $lastJournee =  $repositoryJournee->findLastJourneePlayed($saison[0]->getSaison());
            //var_dump($saison[0]->getSaison());
        }
        $saison = $repositorySaison->findBy(["actuelle"=>"Oui"]);
       // var_dump($lastJournee);
        $lastClassementA = $repositoryClassement->findLastClassementPlayedByConf($saison[0]->getSaison(),'A');
        if(empty($lastClassementA)){
            $lastClassementA =  $repositoryClassement->findLastClassementPlayedByConf($saison[0]->getSaison(),'A');
        }
        $lastClassementB = $repositoryClassement->findLastClassementPlayedByConf($saison[0]->getSaison(),'B');
        if(empty($lastClassementB)){
            $lastClassementB =  $repositoryClassement->findLastClassementPlayedByConf($saison[0]->getSaison(),'B');
        }
        //var_dump($lastClassementA);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        return $this->render('accueil/accueil.html.twig', [
            'selected' => "Accueil",
            'equipes'=>$lesEquipes,
            'lastJournee' => $lastJournee,
            'classementA' => $lastClassementA,
            'classementB' => $lastClassementB,
        ]);
    }
}
