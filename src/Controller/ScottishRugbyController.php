<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * Description of ScottishRugbyController
 *
 * @author Antoine
 */
class ScottishRugbyController extends AbstractController {
    public function index(){
        $repositoryArticle = $this->getDoctrine()->getRepository(\App\Entity\Article::class);
        $articles = $repositoryArticle->findByTypes('Publié',[1,2]);
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        return $this->render('scottishRugby/articles.html.twig', [
            'selected' => "ScottishRugby",
            'equipes'=> $lesEquipes,
            'articles' => $articles,
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
        $session = new Session();
        $entityManager = $this->getDoctrine()->getManager();
        $read = $session->get("article".$article->getId(), null);
        if($read == null){
            $vues = $article->getVues();
            $article->setVues($vues+1);
            $entityManager->flush();
            $session->set("article".$article->getId(), true);
        }
        $repositoryTags = $this->getDoctrine()->getRepository(\App\Entity\Tags::class);
        $lesTags = $repositoryTags->findBy(array('article'=>$article->getId()));
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        return $this->render('ScottishRugby/unArticle.html.twig', [
            'selected' => "ScottishRugby",
            'equipes'=> $lesEquipes,
            'article' => $article,
            'tags'=>$lesTags,
        ]);
    }
}
