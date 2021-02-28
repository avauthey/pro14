<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController {
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $repositoryPalmares = $this->getDoctrine()->getRepository(\App\Entity\Palmares::class);
        $lesPalmares = $repositoryPalmares->findAll();
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        return $this->render('about/accueil.html.twig', [
            'selected' => "APropos",
            'equipes'=> $lesEquipes,
            'palmares'=>$lesPalmares,
            'active' => "Présentation",
        ]);
    }
}
