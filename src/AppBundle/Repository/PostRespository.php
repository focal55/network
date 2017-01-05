<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PostRespository extends EntityRepository
{
    /**
     * @param User $user
     * @return Post[]
     */
    public function findAllForUser(User $user)
    {
        return $this->findBy(array('user' => $user));
    }
}