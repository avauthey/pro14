<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Contact;
use App\Form\Type\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $json = false;
        //$filename = "dsfhjs";
        /*$xml = simplexml_load_file("http://feeds.bbci.co.uk/sport/rugby-union/rss.xml",'SimpleXMLElement', LIBXML_NOCDATA);
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


        }*/
        $filename = "https://www.pro14.rugby/api/v1/newsfeed/latestnews";        
        $file_headers = @get_headers($filename);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $exists = false;
        }
        else {
            $exists = true;
        }
        if($filename != false){
            $json = file_get_contents($filename);
            if($json != false){
                $tmp = json_decode($json,true);
                $articles = $tmp['articles'];
                
                for($i =0;$i<8;$i++){
                    $lien = $articles[$i]['url'];
                    $article = $articles[$i]['heroMedia']['title'];
                    $data["$lien"] = $article;
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
    
    public function getRss()
    {
        $repositoryArticle = $this->getDoctrine()->getRepository(\App\Entity\Article::class);
        $posts = $repositoryArticle->findBy(array(), array('dateDerniereModification'=>'desc'));

        $response = new Response();
        $response->headers->set("Content-type", "text/xml");
        $response->setContent(self::generate($posts));
        return $response;

    }
    
    private static function generate(array $posts)
    {
        $xml = <<<xml
<?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>
<channel>
<title>Pro14fr</title>
<link>https://pro14fr.com</link>
<description>Pro14fr rss feed</description>
<language>fr</language>
xml;
        foreach ($posts as $post) {

            $title = self::xmlEscape($post->getTitre());
            if($post->getType()==1){
                $url = "scottish-rugby/".$post->getId();
            }else{
                $url = "competition/article/".$post->getId();
            }
            $slug = self::xmlEscape(mb_substr($post->getContenu(), 3, 100).'...');
            if($post->getDateDerniereModification() != null){
                $pubDate = $post->getDateDerniereModification()->format('Y-m-d');
            }else{
                $pubDate = $post->getDateCreation()->format('Y-m-d');
            }            
            $xml .= <<<xml
<item>
<title>{$title}</title>
<link>https://pro14fr.com/{$url}</link>
<description>{$slug}</description>
<pubDate>{$pubDate}</pubDate>
</item>
xml;
        }
        $xml .= "</channel></rss>";

        return $xml;
    }

    private static function xmlEscape($string) {
        return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
    }
}
