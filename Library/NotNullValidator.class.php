<?php
namespace Library;

/**
 * Description of NotNullValidator
 *
 * @author Markus-Strike
 */
class NotNullValidator extends Validator {
    public function isValid($value)
     {
      return $value != '';
     }
}
