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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Description of JoueurController
 *
 * @author Antoine
 */
class JoueurController extends AbstractController  {
    //put your code here
    public function getParNom() {
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        return $this->render('joueur/accueilJoueur.html.twig', [
            'selected' => "Joueurs",
            'equipes'=>$lesEquipes,
            'active'=>'Nom',
        ]);
    }
    
    public function displayList(Request $request){
        if ($request->isXmlHttpRequest()) {
            $nom= $request->get("test");
        }else{
            throw $this->createNotFoundException('Fuck off');
        }
        
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Joueur::class);
        $liste = $repository->findByPrenomNom($nom);
        //$vote = 1;
        return  $this->render('joueur/liste.html.twig', [
            'liste' => $liste,
            ]);
    }
    public function getJoueur($id){
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Joueur::class);
        $joueur = $repository->find($id);
        if (!$joueur) {
            throw $this->createNotFoundException(
                    'Fuck off! Pas de joueur pour l\'id '.$id
            );
        }
        $repositoryAssoJoueurEquipe = $this->getDoctrine()->getRepository(\App\Entity\AssoJoueurEquipe::class);
        $equipetmp = $repositoryAssoJoueurEquipe->findBy(['idJoueur'=>$joueur->getId()]);
        
        $repositorySaison = $this->getDoctrine()->getRepository(\App\Entity\Saison::class);
        $saisonActuelle = $repositorySaison->findBy(array("actuelle"=>"Oui"));
        
        $repositoryAssoJoueurJournee = $this->getDoctrine()->getRepository(\App\Entity\AssoJoueurJournee::class);
        /** @var AssoJoueurJournee[] $journeeJoueur */
        $journeeJoueur = $repositoryAssoJoueurJournee->findBy(array("joueur"=>$joueur->getId()));
       //var_dump($journeeJoueur);
        $journeesSaisonActuelle = array();
        $allJournees = array();
        if(!empty($journeeJoueur)){
            foreach($journeeJoueur as $uneJournee){
                if($uneJournee->getJournee()->getSaison()==$saisonActuelle[0]->getSaison()){
                    $journeesSaisonActuelle[] = $uneJournee;
                }
                //$allJournees[] = $uneJournee;
            }
            $j = 0;
            
            foreach($journeeJoueur as $uneJournee){
                if(array_key_exists($uneJournee->getJournee()->getSaison(), $allJournees)){
                    $allJournees[$uneJournee->getJournee()->getSaison()]['saison'] =  $uneJournee->getJournee()->getSaison();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['equipe'] =  $uneJournee->getEquipe();
                    if($uneJournee->getNumero()<16){
                        $allJournees[$uneJournee->getJournee()->getSaison()]['titulaire'] = $allJournees[$uneJournee->getJournee()->getSaison()]['titulaire'] + 1;
                    }else{
                        $allJournees[$uneJournee->getJournee()->getSaison()]['remplacent'] = $allJournees[$uneJournee->getJournee()->getSaison()]['remplacent'] + 1;
                    }
                    $allJournees[$uneJournee->getJournee()->getSaison()]['essai'] = $allJournees[$uneJournee->getJournee()->getSaison()]['essai'] + $uneJournee->getEssais();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['transformation'] = $allJournees[$uneJournee->getJournee()->getSaison()]['transformation'] + $uneJournee->getTransformation();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['penalite'] = $allJournees[$uneJournee->getJournee()->getSaison()]['penalite'] + $uneJournee->getPenalite();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['drops'] = $allJournees[$uneJournee->getJournee()->getSaison()]['drops'] + $uneJournee->getDrops();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['placageReussi'] = $allJournees[$uneJournee->getJournee()->getSaison()]['placageReussi'] + $uneJournee->getPlacagesReussis();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['placageManque'] = $allJournees[$uneJournee->getJournee()->getSaison()]['placageManque'] + $uneJournee->getPlacagesManques();
                }else{
                    $allJournees[$uneJournee->getJournee()->getSaison()]['saison'] =  $uneJournee->getJournee()->getSaison();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['equipe'] =  $uneJournee->getEquipe();
                    if($uneJournee->getNumero()<16){
                        $allJournees[$uneJournee->getJournee()->getSaison()]['titulaire'] = 1;
                        $allJournees[$uneJournee->getJournee()->getSaison()]['remplacent'] = 0;
                    }else{
                        $allJournees[$uneJournee->getJournee()->getSaison()]['remplacent'] = 1;
                        $allJournees[$uneJournee->getJournee()->getSaison()]['titulaire'] = 0;
                    }
                    $allJournees[$uneJournee->getJournee()->getSaison()]['essai'] = $uneJournee->getEssais();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['transformation'] = $uneJournee->getTransformation();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['penalite'] = $uneJournee->getPenalite();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['drops'] = $uneJournee->getDrops();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['placageReussi'] = $uneJournee->getPlacagesReussis();
                    $allJournees[$uneJournee->getJournee()->getSaison()]['placageManque'] = $uneJournee->getPlacagesManques();
                }
            }
            ksort($allJournees);
        }
        //var_dump($equipetmp);
        $previous = "";
        foreach ($equipetmp as $asso) {
            if($asso->getIdEquipe()->getId()!= $previous){
                $equipe[] = $asso;
            }
            $previous = $asso->getIdEquipe()->getId();
        }
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
    
        return $this->render('joueur/ficheJoueur.html.twig', [
            'selected' => "Joueurs",
            'equipes'=>$lesEquipes,
            'joueur'=>$joueur,
            'equipe'=>$equipe,
            'saisonActuelle'=>$journeesSaisonActuelle,
            'allSaisons'=>$allJournees,
        ]);
    }
    
    public function getByEquipe() {
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        return $this->render('joueur/joueurEquipe.html.twig', [
            'selected' => "Joueurs",
            'equipes'=>$lesEquipes,
            'active'=>'Equipe',
        ]);
    }
    public function getNationalite() {
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        $repositoryJoueur = $this->getDoctrine()->getRepository(\App\Entity\Joueur::class);
        $nationalites = $repositoryJoueur->getNationalites();
        //var_dump($nationalites);
        return $this->render('joueur/listeNationalite.html.twig', [
            'selected' => "Joueurs",
            'equipes'=>$lesEquipes,
            'active'=>'Nationalité',
            'nationalites'=>$nationalites,
        ]);
    }
    public function getByNationalite($nationalite) {
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        $repositoryJoueur = $this->getDoctrine()->getRepository(\App\Entity\Joueur::class);
        $joueurs = $repositoryJoueur->findBy(["paysNaissance"=>$nationalite],['nom'=>'ASC']);
        //var_dump($nationalites);
        return $this->render('joueur/joueurNationalite.html.twig', [
            'selected' => "Joueurs",
            'equipes'=>$lesEquipes,
            'active'=>'Nationalité',
            'joueurs'=>$joueurs,
            'nationalite'=>$nationalite,
        ]);
    }
}
