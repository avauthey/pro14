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
        $repositoryJoueur = $this->getDoctrine()->getRepository(\App\Entity\Joueur::class);
        $joueurs = $repositoryJoueur->findAll();
        $datasPlayer = array_map(function(\App\Entity\Joueur $joueur){
            return [
                'id' => $joueur->getId(),
                'nom' => $joueur->getNom(),
                'prenom' => $joueur->getPrenom(),
                'dateNaissance' => $joueur->getDateNaissance(),
                'dateNaissance' => $joueur->getDateNaissance()->format('d/m/Y'),
                'villeNaissance' => $joueur->getVilleNaissance(),
                'paysNaissance' => $joueur->getPaysNaissance()
            ];
        }, $joueurs);
        return $this->render('joueur/accueilJoueur.html.twig', [
            'selected' =>"Competition",
            'active' => "Joueurs",
            'joueurs'=>$datasPlayer,
            'activeSubMenu'=>'Nom',
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
                if(array_key_exists($uneJournee->getJournee()->getSaison(), $allJournees) && array_key_exists($uneJournee->getEquipe()->getId(), $allJournees[$uneJournee->getJournee()->getSaison()])){
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['saison'] =  $uneJournee->getJournee()->getSaison();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['equipe'] =  $uneJournee->getEquipe();
                    if($uneJournee->getNumero()<16){
                        $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['titulaire'] = $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['titulaire'] + 1;
                    }else{
                        $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['remplacent'] = $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['remplacent'] + 1;
                    }
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['essai'] = $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['essai'] + $uneJournee->getEssais();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['transformation'] = $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['transformation'] + $uneJournee->getTransformation();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['penalite'] = $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['penalite'] + $uneJournee->getPenalite();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['drops'] = $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['drops'] + $uneJournee->getDrops();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['placageReussi'] = $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['placageReussi'] + $uneJournee->getPlacagesReussis();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['placageManque'] = $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['placageManque'] + $uneJournee->getPlacagesManques();
                }else{
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['saison'] =  $uneJournee->getJournee()->getSaison();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['equipe'] =  $uneJournee->getEquipe();
                    if($uneJournee->getNumero()<16){
                        $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['titulaire'] = 1;
                        $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['remplacent'] = 0;
                    }else{
                        $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['remplacent'] = 1;
                        $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['titulaire'] = 0;
                    }
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['essai'] = $uneJournee->getEssais();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['transformation'] = $uneJournee->getTransformation();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['penalite'] = $uneJournee->getPenalite();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['drops'] = $uneJournee->getDrops();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['placageReussi'] = $uneJournee->getPlacagesReussis();
                    $allJournees[$uneJournee->getJournee()->getSaison()][$uneJournee->getEquipe()->getId()]['placageManque'] = $uneJournee->getPlacagesManques();
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
        return $this->render('joueur/ficheJoueur.html.twig', [
            'selected' => "Competition",
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
            'selected' => "Competition",
            'equipes'=>$lesEquipes,
            'active'=>'Joueurs',
            'activeSubMenu'=>'Equipes'
        ]);
    }
    public function getNationalite() {
        $repositoryJoueur = $this->getDoctrine()->getRepository(\App\Entity\Joueur::class);
        $nationalites = $repositoryJoueur->getNationalites();
        //var_dump($nationalites);
        return $this->render('joueur/listeNationalite.html.twig', [
            'selected' => "Competition",
            'active'=>'Joueurs',
            'activeSubMenu'=>'Nationalité',
            'nationalites'=>$nationalites,
        ]);
    }
    public function getByNationalite($nationalite) {
        $repositoryJoueur = $this->getDoctrine()->getRepository(\App\Entity\Joueur::class);
        $joueurs = $repositoryJoueur->findBy(["paysNaissance"=>$nationalite],['nom'=>'ASC']);
        //var_dump($nationalites);
        return $this->render('joueur/joueurNationalite.html.twig', [
            'selected' => "Competition",
            'active'=>'Joueurs',
            'activeSubMenu'=>'Nationalité',
            'joueurs'=>$joueurs,
            'nationalite'=>$nationalite,
        ]);
    }
}
