<?php

namespace App\Entity;

use App\Exceptions\ForbiddenException;
use App\Exceptions\InternalServerErrorException;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements EntityInterface, Validatable
{
    
    public const ROLE_USER = 1;
    public const ROLE_ADMIN = 2;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\Column(type="smallint")
     */
    private $role;
    
    /**
     * @ORM\Column(type="text")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, inversedBy="users")
     */
    private $projects;

    /**
     * @ORM\ManyToMany(targetEntity=Task::class, inversedBy="users")
     */
    private $tasks;
    
    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }
    
    public static function fromRequestValues(ParameterBag $input) : User
    {
        $user = new self();
        return $user->applyRequestValues($input);
    }
    
    public function applyRequestValues(ParameterBag $input) : User
    {
        $this->setRole($input->get('role'));
        $this->setName($input->get('name'));
        $this->setPassword($input->get('password'));
        return $this;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
        }

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;

        return $this;
    }
    
    public function isValidLogin(string $password) : bool
    {
        return password_verify($password, $this->password);
    }
    
    /**
     * @param int $authorization
     *
     * @throws ForbiddenException
     * @throws InternalServerErrorException
     */
    public function isAuthorized(int $authorization) : void
    {
        if(!in_array($authorization, [self::ROLE_USER, self::ROLE_ADMIN])) {
            throw new InternalServerErrorException('Unbekannte authorisierungsstufe.');
        }
        if($this->role < $authorization) {
            throw new ForbiddenException('Fehlende Berechtigungen.');
        }
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata) : void
    {
        $metadata->addPropertyConstraints('name', [
            new NotBlank([
                'message' => 'Der Benutzername darf nicht leer sein.'
            ]),
            new Length([
                'min' => 3,
                'max' => 255,
                'maxMessage' => 'Der Benutzername {{ value }} ist zu lang. Er darf maximal {{ limit }} Zeichen enthalten.',
                'minMessage' => 'Der Benutzername {{ value }} ist zu kurz. Er muss mindestens {{ limit }} Zeichen enthalten.'
            ])
        ]);
        $metadata->addPropertyConstraints('password', [
            new NotBlank([
                'message' => 'Das Passwort darf nicht leer sein.'
            ]),
            new Length([
                'min' => 8,
                'minMessage' => 'Das Passwort muss mindestens {{ limit }} Zeichen lang sein.'
            ])
        ]);
        $metadata->addPropertyConstraints('role', [
            new NotBlank([
                'message' => 'Der Benutzer braucht eine Rolle.'
            ]),
            new Range([
                'min' => self::ROLE_USER,
                'max' => self::ROLE_ADMIN,
                'invalidMessage' => 'Die gewählte Rolle existiert nicht.',
                'notInRangeMessage' => 'Die Rolle muss zwischen {{ min }} und {{ max }} liegen.'
            ])
        ]);
    }
    
    public function toArray() : array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'role' => $this->getRole()
        ];
    }
    
}
