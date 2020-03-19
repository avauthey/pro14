<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\EmailValidator;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Mapping\ClassMetadata;
/**
 * Description of Contact
 *
 * @author Antoine
 */
class Contact {
    /**
     * 
     */
    protected $email;
    /**
     * 
     */
    protected $message;
    /**
     * 
     */
    protected $robot;
    
    /**
     * 
     * @return string
     */
    function getEmail() {
        return $this->email;
    }

    /**
     * 
     * @return string
     */
    function getMessage() {
        return $this->message;
    }
    
    /**
     * 
     * @return boolean
     */
    function getRobot() {
        return $this->robot;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setRobot($robot) {
        $this->robot = $robot;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('email', new Assert\Email([
            'message' => 'L\'adresse "{{ value }}" n\'est pas correcte.',
            'checkMX' => true,
        ]));
        $metadata->addPropertyConstraint('message', new NotBlank([
            'message' => 'Le message ne peut pas $etre vide.',
        ]));
        $metadata->addPropertyConstraint('robot', new IsTrue([
            'message' => 'Veuillez cocher cette case.',
        ]));
    }
}
