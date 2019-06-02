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
        $number = random_int(100, 200);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        return $this->render('accueil/accueil.html.twig', [
            'selected' => "Accueil",
            'equipes'=>$lesEquipes,
            'number' => $number,
        ]);
    }
}
