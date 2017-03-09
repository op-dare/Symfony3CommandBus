<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Register;
use Doctrine\ORM\EntityRepository;

class RegisterRepository extends EntityRepository
{
    public function save(Register $register)
    {
        if ($register->getId() == null) {
            $this->getEntityManager()->persist($register);
        }

        $this->getEntityManager()->flush();
    }

    public function update($registerId, $data)
    {
        $register = $this->find($registerId);

        if (isset($data['name'])) {
            $register->setName($data['name']);
        }

        if (isset($data['surname'])) {
            $register->setSurname($data['surname']);
        }

        $this->getEntityManager()->flush();
    }

    public function remove($registerId)
    {
        $register = $this->find($registerId);

        $this->getEntityManager()->remove($register);
        $this->getEntityManager()->flush();
    }
}
