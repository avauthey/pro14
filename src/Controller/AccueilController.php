<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Contact;
use App\Form\Type\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Description of AccueilController
 *
 * @author Antoine
 */
class AccueilController extends AbstractController {
    
    public function index()
    {
        $repositoryClassement = $this->getDoctrine()->getRepository(\App\Entity\Classement::class);
        $repositorySaison = $this->getDoctrine()->getRepository(\App\Entity\Saison::class);
        $saison = $repositorySaison->findBy(["actuelle"=>"Oui"]);
        
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
        $lastArticle = $repositoryArticle->findLast(10);
        $i = 0;
        foreach ($lastArticle as $article){
            if($i < 4){
                $lastFiveArticles[] = $article;
            }else{
                $othersArticles[] = $article;
            }
            $i++;
        }
        $data  = array();
        $json = false;
        $filename = "https://www.pro14.rugby/api/v1/newsfeed/latestnews";        
        $file_headers = @get_headers($filename);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.1 400 Bad Request') {
            $exists = false;
        }
        else {
            $exists = true;
        }
        if($exists != false){
            $json = file_get_contents($filename);
            if($json != false){
                $tmp = json_decode($json,true);
                $articles = $tmp['articles'];
                for($i =0;$i<10;$i++){
                    $lien = $articles[$i]['url'];
                    $article = $articles[$i]['heroMedia']['title'];
                    $data["$lien"] = $article;
                }
            }
        }
        //var_dump($xml);
        return $this->render('accueil/accueil.html.twig', [
            'selected' => "Accueil",
            'classementA' => $lastClassementA,
            'classementB' => $lastClassementB,
            'lastFiveArticles' => $lastFiveArticles,
            'othersArticles' => $othersArticles,
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
        $posts = $repositoryArticle->findBy(array('statut'=>'Publié'), array('dateCreation'=>'desc','dateDerniereModification'=>'desc'));

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

    public function getArticle($id){
        $repositoryArticle = $this->getDoctrine()->getRepository(\App\Entity\Article::class);
        /** @var Article $article */
        $article = $repositoryArticle->find($id);
        if (!$article || (is_object($article) && $article->getStatut()!='Publié')) {
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
        return $this->render('accueil/unArticle.html.twig', [
            'selected' => "Accueil",
            'equipes'=> $lesEquipes,
            'article' => $article,
            'tags'=>$lesTags,
        ]);
    }
    public function getArticles() {
        $repositoryArticle = $this->getDoctrine()->getRepository(\App\Entity\Article::class);
        $articles = $repositoryArticle->findByTypes('Publié',[0,1,2]);
        $repositoryEquipe = $this->getDoctrine()->getRepository(\App\Entity\Equipe::class);
        $lesEquipes = $repositoryEquipe->findAllByNomOrder('ASC');
        return $this->render('accueil/articles.html.twig', [
            'selected' => "Accueil",
            'equipes'=> $lesEquipes,
            'active' => "Article",
            'articles' => $articles,
        ]);
    }
}