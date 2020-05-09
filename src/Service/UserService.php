<?php

namespace App\Service;


use App\Entity\User;
use App\Exceptions\NotFoundException;
use App\Factory\AbstractService;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService extends AbstractService
{
    
    private UserRepository $repository;
    
    public function __construct(ValidatorInterface $validator, UserRepository $repository)
    {
        parent::__construct($validator);
        $this->repository = $repository;
    }
    
    /**
     * @param int $id
     *
     * @return User
     * @throws NotFoundException
     */
    public function getUserById(int $id) : User
    {
        $user = $this->repository->find($id);
        if(!$user) {
            throw new NotFoundException(sprintf('Es existiert kein Arbeitspaket mit der ID %s', $id));
        }
        return $user;
    }
    
}
