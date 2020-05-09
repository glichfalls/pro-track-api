<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    
    /**
     * @param string $username
     *
     * @return bool
     */
    public function userNameExist(string $username) : bool
    {
        try {
            $this->findByUserName($username);
            return true;
        } catch(NoResultException $exception) {
            return false;
        } catch(NonUniqueResultException $exception) {
            return true;
        }
    }
    
    /**
     * @param string $username
     *
     * @return User
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findByUserName(string $username) : User
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name = :name')
            ->setParameter('name', $username)
            ->getQuery()
            ->getSingleResult();
    }
    
}
