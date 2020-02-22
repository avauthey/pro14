<?php

namespace App\Entity;

/**
 * Description of Contact
 *
 * @author Antoine
 */
class Contact {
    /**
     *
     * @var string 
     */
    protected $email;
    /**
     * @var string 
     */
    protected $message;
    /**
     *
     * @var boolean 
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


}
