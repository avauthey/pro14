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
    public function number()
    {
        $number = random_int(0, 100);

        return $this->render('competition/accueil.html.twig', [
            'selected' => "Competition",
            'number' => $number,
        ]);
    }
}
