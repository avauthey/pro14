<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Contact;
use App\Form\Type\ContactType;
use Symfony\Component\HttpFoundation\Request;

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
    
    public function getContact(Request $request){
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        $contact = new Contact();
        
        $contact->setEmail('');
        $contact->setMessage('');
        $contact->setRobot(false);
        
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $contact = $form->getData();
            //var_dump($contact);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            //return $this->redirectToRoute('task_success');
        }
        return $this->render('accueil/contact.html.twig', [
            'selected' => "Accueil",
            'equipes'=>$lesEquipes,
            'form' => $form->createView(),
        ]);
    }
}
