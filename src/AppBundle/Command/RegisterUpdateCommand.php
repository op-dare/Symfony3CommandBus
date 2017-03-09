<?php

namespace AppBundle\Command;

use AppBundle\Entity\Register;

class RegisterUpdateCommand
{
    private $name;

    private $surname;

    private $register;

    public function __construct($name, $surname, Register $register)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->register = $register;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getRegister()
    {
        return $this->register;
    }

}
