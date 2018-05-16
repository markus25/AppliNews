<?php
namespace Applications\Backend\Modules\News;
/**
 * Description of NewsController
 *
 * @author Markus-Strike
 */
class NewsController extends \Library\BackController
  {
  public function executeIndex(\Library\HTTPRequest $request)
   {
    $this->page->addVar('title', 'Gestion des news');
    $manager = $this->managers->getManagerOf('News');
    $this->page->addVar('listeNews', $manager->getList());
    $this->page->addVar('nombreNews', $manager->count());
   }
   public function executeInsert(\Library\HTTPRequest $request)
    {
     $this->processForm($request);
     $this->page->addVar('title', 'Ajout d\'une news');
    }
   public function processForm(\Library\HTTPRequest $request)
    {
     if ($request->method() == 'POST')
      { 
       $news = new \Library\Entities\News( array(
       'auteur' => $request->postData('auteur'),
       'titre' => $request->postData('titre'),
       'contenu' => $request->postData('contenu')
       ));
   if ($request->getExists('id'))
    {
     $news->setId($request->getData('id'));
    }
   }
   else
    {
// L'identifiant de la news est transmis si on veut la modifier.
   if ($request->getExists('id')) 
    {
  $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
     }
   else
    {
     $news = new \Library\Entities\News;
    }
    }
    $formBuilder = new \Library\FormBuilder\NewsFormBuilder($news);
    $formBuilder->build();
    $form = $formBuilder->form();
    if ($request->method() == 'POST' && $form->isValid())
     {
    $this->managers->getManagerOf('News')->save($news);
    $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');
    $this->app->httpResponse()->redirect('/admin/');
       }
      $this->page->addVar('form', $form->createView());
      }
  public function executeDelete(\Library\HTTPRequest $request)
   {
    $this->managers->getManagerOf('News')->delete($request->getData('id'));
    $this->app->user()->setFlash('La news a bien été supprimée !');
    $this->app->httpResponse()->redirect('.');
   } 
   public function executeUpdate(\Library\HTTPRequest $request)
    {
     $this->processForm($request);
     $this->page->addVar('title', 'Modification d\'une news');
    }
   public function executeUpdateComment(\Library\HTTPRequest $request)
    {
     $this->page->addVar('title', 'Modification d\'un commentaire');
     if ($request->method() == 'POST')
      {
       $comment = new \Library\Entities\Comment(array(
       'id' => $request->getData('id'),
       'auteur' => $request->postData('auteur'),
       'contenu' => $request->postData('contenu')
));
}
else
{
$comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
}
$formBuilder = new \Library\FormBuilder\CommentFormBuilder($comment);
$formBuilder->build();
$form = $formBuilder->form();
if ($request->method() == 'POST' && $form->isValid())
{
$this->managers->getManagerOf('Comments')->save($comment);
$this->app->user()->setFlash('Le commentaire a bien été modifié');
$this->app->httpResponse()->redirect('/admin/');
}
$this->page->addVar('form', $form->createView());
}
    public function executeDeleteComment(\Library\HTTPRequest $request)
     {
$this->managers->getManagerOf('Comments')->delete($request->getData('id'));
$this->app->user()->setFlash('Le commentaire a bien été supprimé!');
$this->app->httpResponse()->redirect('.');
}
  public function executeInsertComment(\Library\HTTPRequest $request)
    {
     $this->page->addVar('title', 'Ajout d\'un commentaire');
     if ($request->postExists('pseudo'))
      {
       $comment = new \Library\Entities\Comment(array('news' => $request->getData('news'),
       'auteur' => $request->postData('pseudo'),
       'contenu' => $request->postData('contenu')
     ));
     if ($comment->isValid())
      {
       $this->managers->getManagerOf('Comments')->save($comment);
       $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
$this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
      }
     else
      {
       $this->page->addVar('erreurs', $comment->erreurs());
      }
     $this->page->addVar('comment', $comment);
   }
   }
}

