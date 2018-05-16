<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Library;

/**
 * Description of Field
 *
 * @author Markus-Strike
 */
abstract  class Field {
   protected $errorMessage;
   protected $label;
   protected $name;
   protected $validators = array();
   protected $value;
  public function __construct(array $options = array())
   {
    if (!empty($options))
    {
     $this->hydrate($options);
    }
   }
abstract public function buildWidget();
  public function hydrate($options)
  {
  foreach ($options as $type => $value)
   {
   $method = 'set'.ucfirst($type);
   if (is_callable(array($this, $method)))
    {
     $this->$method($value);
    }
    }
  }
public function isValid()
{
foreach ($this->validators as $validator)
{
if (!$validator->isValid($this->value))
{
$this->errorMessage = $validator->errorMessage();
return false;
}
}
return true;
}
public function label()
{
return $this->label;
}
public function length()
{
return $this->length;
}
public function name()
{
return $this->name;
}
public function validators()
{
return $this->validators;
}
public function value()
{
return $this->value;
}
public function setLabel($label)
{
if (is_string($label))
{
$this->label = $label;
}
}
public function setLength($length)
{
$length = (int) $length;
if ($length > 0)
{
$this->length = $length;
}
}
public function setName($name)
{
if (is_string($name))
{
$this->name = $name;
}
}
public function setValidators(array $validators)
{
foreach ($validators as $validator)
{
if ($validator instanceof Validator && !in_array($validator,
$this->validators))
{
$this->validators[] = $validator;
}
}
}
public function setValue($value)
{
if (is_string($value))
{
 $this->value = $value;
}
}    

}
