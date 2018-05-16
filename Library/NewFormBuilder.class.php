<?php
namespace Library\FormBuilder;

/**
 * Description of NewFormBuilder
 *
 * @author Markus-Strike
 */
class NewFormBuilder extends \Library\FormBuilder 
 {
    public function build()
    {
     $this->form->add(new \Library\StringField(array(
     'label' => 'Auteur',
     'name' => 'auteur',
     'maxLength' => 20,
     'validators' => array( new \Library\MaxLengthValidator('L\'auteur spécifié esttrop long (20 caractères maximum)', 20),
  new \Library\NotNullValidator('Merci de spécifier l\'auteur de la news'),), )))
->add(new \Library\StringField(array(
'label' => 'Titre',
'name' => 'titre',
'maxLength' => 100,
'validators' => array( new \Library\MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
new \Library\NotNullValidator('Merci de spécifier le titre de la news'),
),
)))
->add(new \Library\TextField(array(
'label' => 'Contenu',
'name' => 'contenu',
'rows' => 8,
'cols' => 60,
'validators' => array(
new \Library\NotNullValidator('Merci de spécifier le contenu de la news'),
),
)));
}
}
