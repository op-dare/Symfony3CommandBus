<?php

namespace AppBundle\CommandHandler;

use AppBundle\Command\RegisterUpdateCommand;
use AppBundle\Entity\Register;
use AppBundle\Repository\RegisterRepository;
use Symfony\Component\Security\Core\Exception;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class RegisterUpdateCommandHandler
{
    private $registerRepository;
    private $validator;

    public function __construct(RegisterRepository $registerRepository, RecursiveValidator $validator)
    {
        $this->registerRepository = $registerRepository;
        $this->validator = $validator;
    }

    public function handle(RegisterUpdateCommand $command)
    {
        $register = $command->getRegister();

        $register->update(
            $command->getName(),
            $command->getSurname()
        );

        $this->validate($register);

        $this->registerRepository->save($register);
    }

    public function validate(Register $register)
    {
        $errors = $this->validator->validate($register);
        if (count($errors) > 0) {
            echo('Validation Error ');
        }
    }
}
