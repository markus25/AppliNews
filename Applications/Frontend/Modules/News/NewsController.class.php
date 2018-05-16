<?php
namespace Applications\Frontend\Modules\News;
/**
 * Description of NewsController
 *
 * @author Markus-Strike
 */
class NewsController extends \Library\BackController 
{
  public function executeIndex(\Library\HTTPRequest $request)
   {
    $nombreNews = $this->app->config()->get('nombre_news');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');
// On ajoute une définition pour le titre.
$this->page->addVar('title', 'Liste des '.$nombreNews.'dernières news');
// On récupère le manager des news.
$manager = $this->managers->getManagerOf('News');
// Cette ligne, vous ne pouviez pas la deviner sachant qu'on n'a pas encore touché au modèle.
// Contentez-vous donc d'écrire cette instruction, nous implémenterons la méthode ensuite.
$listeNews = $manager->getList(0, $nombreNews);
foreach ($listeNews as $news)
{
if (strlen($news->contenu()) > $nombreCaracteres)
{
$debut = substr($news->contenu(), 0, $nombreCaracteres);
$debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
$news->setContenu($debut);
}
}
// On ajoute la variable $listeNews à la vue.
$this->page->addVar('listeNews', $listeNews);
}   
  public function executeShow(\Library\HTTPRequest $request)
   {
$news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
   if (empty($news))
   {
    $this->app->httpResponse()->redirect404();
   }
   $this->page->addVar('title', $news->titre());
   $this->page->addVar('news', $news);
   $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
   }
   
   public function executeInsertComment(\Library\HTTPRequest $request)
    {
      // Si le formulaire a été envoyé.
if ($request->method() == 'POST')
{
$comment = new \Library\Entities\Comment(array(
'news' => $request->getData('news'),
'auteur' => $request->postData('auteur'),
'contenu' => $request->postData('contenu')
));
}
else
{
$comment = new \Library\Entities\Comment;
}
$formBuilder = new \Library\FormBuilder\CommentFormBuilder($comment);
$formBuilder->build();
$form = $formBuilder->form();
if($request->method() == 'POST' && $form->isValid())
{
$this->managers->getManagerOf('Comments')->save($comment);
$this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
$this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
}
$this->page->addVar('comment', $comment);
$this->page->addVar('form', $form->createView());
$this->page->addVar('title', 'Ajout d\'un commentaire');
}
   
    }

