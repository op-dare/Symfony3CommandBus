<?php

namespace AppBundle\Command;

use AppBundle\Entity\Register;

class RegisterAddCommand
{
    private $name;

    private $surname;

    public function __construct($name, $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }
}
