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
        $data  = array();
        $xml = simplexml_load_file("http://feeds.bbci.co.uk/sport/rugby-union/rss.xml",'SimpleXMLElement', LIBXML_NOCDATA);
        foreach ($xml->channel->item as $element){
            //var_dump($element);
            if((strpos($element->title,"Pro14")!=false || strpos($element->description,"Pro14")!=false) && !in_array($element, $data)){
                $data[] = $element;
            }
            foreach ($lesEquipes as $uneEquipe){
                if((strpos($element->title,$uneEquipe['nom'])!=false || strpos($element->description,$uneEquipe['nom'])!=false) && !in_array($element, $data)){
                    $data[] = $element;
                }
            }
            
            
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
    
    public function getContact(Request $request, \Swift_Mailer $email){
        $repository = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repository->findAllByNomOrder('ASC');
        $contact = new Contact();
        
        $contact->setEmail('');
        $contact->setMessage('');
        $contact->setRobot(false);
        
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $errorMessage = '';
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            
            $contact = $form->getData();
            //var_dump($contact);
            if(filter_var($contact->getEmail(), FILTER_VALIDATE_EMAIL) && $contact->getMessage()!='' && $contact->getRobot()===true){
                //$email = new \Swift_Mailer('Nouveau contact');
                $content = (new \Swift_Message('Nouveau contact'))
                        ->setFrom("contact@pro14fr.com")
                        //->setFrom($contact->getEmail())
                        ->setTo("vauthey.antoine@gmail.com")
                        //->setBody($contact->getMessage(),'text/html');
                        ->setBody(
                            $this->renderView(
                                // templates/
                                'email.html.twig',
                                ['message' => $contact->getMessage(),
                                'expediteur' => $contact->getEmail()]
                            ),
                            'text/html'
                        );
                $array = array();
                $x = $email->send($content, $array);
                $this->addFlash('success', 'Message envoyé avec succès. L\'administrateur du site reviendra dès que possible');
            }else{
                $errorMessage .= " Une erreur 1 s'est produite. Veuillez réessayer plus tard.";
            }
        }/*else{
            $errorMessage .= " Une erreur 2 s'est produite. Veuillez réessayer plus tard.";
        }*/
        return $this->render('accueil/contact.html.twig', [
            'selected' => "Accueil",
            'equipes'=>$lesEquipes,
            'form' => $form->createView(),
            'error'=>$errorMessage,
        ]);
    }
}
