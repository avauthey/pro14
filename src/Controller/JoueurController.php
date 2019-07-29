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
            'active'=>"",
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
