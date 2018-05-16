<?php
namespace Library\Models;
use Library\Entities\News;
/**
 * Description of NewsManager_PDO
 *
 * @author Markus-Strike
 */
class NewsManager_PDO extends NewsManager 
{
 public function getList($debut = -1, $limite = -1)
  {
   $sql = 'SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news ORDER BY id DESC';
 if ($debut != -1 || $limite != -1)
  {
   $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
  }
$requete = $this->dao->query($sql);
$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\News');
$listeNews = $requete->fetchAll();   
 foreach ($listeNews as $news)
{
$news->setDateAjout(new \DateTime($news->dateAjout()));
$news->setDateModif(new \DateTime($news->dateModif()));
}
$requete->closeCursor();
return $listeNews;
}
  public function getUnique($id)
{
$requete = $this->dao->prepare('SELECT id, auteur, titre,
contenu, dateAjout, dateModif FROM news WHERE id = :id');
$requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
$requete->execute();
$requete->setFetchMode(\PDO::FETCH_CLASS |\PDO::FETCH_PROPS_LATE, '\Library\Entities\News');
if ($news = $requete->fetch())
{
$news->setDateAjout(new \DateTime($news->dateAjout()));
$news->setDateModif(new \DateTime($news->dateModif()));
return $news;
}
return null;
}
public function count()
{
return $this->dao->query('SELECT COUNT(*) FROM news')->fetchColumn();
}
 public function delete($id)
{
$this->dao->exec('DELETE FROM news WHERE id = '.(int) $id);
}
}
