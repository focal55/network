<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

class UserRepository extends EntityRepository
{
    /**
     * @return User
     */
    public function findOneByEmail($email)
    {
        return $this->createQueryBuilder('users')
            ->andWhere('users.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
