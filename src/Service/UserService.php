<?php

namespace App\Service;


use App\Entity\User;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Factory\AbstractService;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Request;
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
    
    /**
     * @param Request $request
     *
     * @return User
     * @throws BadRequestException
     */
    public function createUserFromRequest(Request $request) : User
    {
        $user = User::fromRequestValues($request->request);
        $this->validateEntity($user);
        if($this->repository->userNameExist($user->getName())) {
            throw new BadRequestException(sprintf(
                'Der Benutzername %s ist bereits vergeben.', $user->getName()
            ));
        }
        return $user;
    }
    
    /**
     * @param Request $request
     *
     * @return User
     * @throws UnauthorizedException
     */
    public function authenticateFromRequest(Request $request) : User
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        try {
            $user = $this->repository->findByUserName($username);
            if(!$user->isValidLogin($password)) {
                throw new UnauthorizedException('Das Passwort ist ungültig.');
            }
            return $user;
        } catch(NoResultException $noResultException) {
            throw new UnauthorizedException(sprintf('Der Benutzer %s existiert nicht.', $username));
        } catch(NonUniqueResultException $nonUniqueResultException) {
            throw new UnauthorizedException(
                sprintf('Es existieren mehrere Benutzer mit dem Namen %s. Login fehlgeschlagen.', $username)
            );
        }
    }
    
}
