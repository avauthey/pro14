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
        //var_dump($saisonActuelle);
        //$repositoryJournee  = $this->getDoctrine()->getRepository(\App\Entity\Journee::class);
        /*$journeesSaisonActuelle = $repositoryJournee->findBy(array("saison"=>$saisonActuelle[0]->getSaison(),));
        $allJournee = $repositoryJournee-*/
        $repositoryAssoJoueurJournee = $this->getDoctrine()->getRepository(\App\Entity\AssoJoueurJournee::class);
        $journeeJoueur = $repositoryAssoJoueurJournee->findBy(array("joueur"=>$joueur->getId()));
       //var_dump($journeeJoueur);
        $journeesSaisonActuelle = array();
        $allJournees = array();
        foreach($journeeJoueur as $uneJournee){
            if($uneJournee->getJournee()->getSaison()==$saisonActuelle[0]->getSaison()){
                $journeesSaisonActuelle[] = $uneJournee;
            }
            //$allJournees[] = $uneJournee;
        }
        $j = 0;
        if(!empty($journeeJoueur)){
            $allJournees[$j]['saison'] =  $journeeJoueur[0]->getJournee()->getSaison();
            $allJournees[$j]['equipe'] =  $journeeJoueur[0]->getEquipe();
            if($journeeJoueur[0]->getNumero()<16){
                $allJournees[$j]['titulaire'] =  1;
                $allJournees[$j]['remplacent'] = 0;
            }else{
                $allJournees[$j]['titulaire'] =  0;
                $allJournees[$j]['remplacent'] = 1;
            }
            $allJournees[$j]['essai'] =  $journeeJoueur[0]->getEssais();
            $allJournees[$j]['transformation'] =  $journeeJoueur[0]->getTransformation();
            $allJournees[$j]['penalite'] =  $journeeJoueur[0]->getPenalite();
            $allJournees[$j]['drops'] =  $journeeJoueur[0]->getDrops();
            $allJournees[$j]['placageReussi'] =  $journeeJoueur[0]->getPlacagesReussis();
            $allJournees[$j]['placageManque'] =  $journeeJoueur[0]->getPlacagesManques();
            for($i = 1;$i<count($journeeJoueur);$i++){
                if($journeeJoueur[$i-1]->getJournee()->getSaison() == $journeeJoueur[$i]->getJournee()->getSaison() && $journeeJoueur[$i-1]->getEquipe()->getId() == $journeeJoueur[$i]->getEquipe()->getId()){
                    if($journeeJoueur[$i]->getNumero()<16){
                        $allJournees[$j]['titulaire'] = $allJournees[$j]['titulaire'] + 1;
                    }else{
                        $allJournees[$j]['remplacent'] = $allJournees[$j]['remplacent'] + 1;
                    }
                    $allJournees[$j]['essai'] =  $allJournees[$j]['essai'] + $journeeJoueur[$i]->getEssais();
                    $allJournees[$j]['transformation'] =  $allJournees[$j]['transformation'] + $journeeJoueur[$i]->getTransformation();
                    $allJournees[$j]['penalite'] =  $allJournees[$j]['penalite'] + $journeeJoueur[$i]->getPenalite();
                    $allJournees[$j]['drops'] =  $allJournees[$j]['drops'] + $journeeJoueur[$i]->getDrops();
                    $allJournees[$j]['placageReussi'] =  $allJournees[$j]['placageReussi'] + $journeeJoueur[$i]->getPlacagesReussis();
                    $allJournees[$j]['placageManque'] =  $allJournees[$j]['placageManque'] + $journeeJoueur[$i]->getPlacagesManques();
                }else{
                    $j++;
                    $allJournees[$j]['saison'] =  $journeeJoueur[$i]->getJournee()->getSaison();
                    $allJournees[$j]['equipe'] =  $journeeJoueur[$i]->getEquipe();
                    if($journeeJoueur[$i]->getNumero()<16){
                        $allJournees[$j]['titulaire'] =  1;
                        $allJournees[$j]['remplacent'] = 0;
                    }else{
                        $allJournees[$j]['titulaire'] =  0;
                        $allJournees[$j]['remplacent'] = 1;
                    }
                    $allJournees[$j]['essai'] =  $journeeJoueur[$i]->getEssais();
                    $allJournees[$j]['transformation'] =  $journeeJoueur[$i]->getTransformation();
                    $allJournees[$j]['penalite'] =  $journeeJoueur[$i]->getPenalite();
                    $allJournees[$j]['drops'] =  $journeeJoueur[$i]->getDrops();
                    $allJournees[$j]['placageReussi'] =  $journeeJoueur[$i]->getPlacagesReussis();
                    $allJournees[$j]['placageManque'] =  $journeeJoueur[$i]->getPlacagesManques();
                }
            }
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
