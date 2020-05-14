<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task implements EntityInterface, Validatable
{

    public const STATUS_OPEN = 1;
    public const STATUS_FINISHED = 2;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=TimeRecord::class, mappedBy="task")
     */
    private $timeRecords;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="tasks")
     */
    private $users;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\Column(type="bigint")
     */
    private $guideTime;

    public function __construct()
    {
        $this->timeRecords = new ArrayCollection();
        $this->users = new ArrayCollection();
    }
    
    public static function fromRequestValues(ParameterBag $input) : Task
    {
        $task = new self();
        $task->setStatus(self::STATUS_OPEN);
        return $task->applyRequestValues($input);
    }
    
    public function applyRequestValues(ParameterBag $input) : Task
    {
        $this->setTitle($input->get('title'));
        $this->setDescription($input->get('description'));
        $this->setGuideTime($input->get('guide_time'));
        return $this;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|TimeRecord[]
     */
    public function getTimeRecords(): Collection
    {
        return $this->timeRecords;
    }

    public function addTimeRecord(TimeRecord $timeRecord): self
    {
        if (!$this->timeRecords->contains($timeRecord)) {
            $this->timeRecords[] = $timeRecord;
            $timeRecord->setTask($this);
        }

        return $this;
    }

    public function removeTimeRecord(TimeRecord $timeRecord): self
    {
        if ($this->timeRecords->contains($timeRecord)) {
            $this->timeRecords->removeElement($timeRecord);
            // set the owning side to null (unless already changed)
            if ($timeRecord->getTask() === $this) {
                $timeRecord->setTask(null);
            }
        }

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addTask($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeTask($this);
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getGuideTime(): ?string
    {
        return $this->guideTime;
    }

    public function setGuideTime(string $guideTime): self
    {
        $this->guideTime = $guideTime;

        return $this;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata) : void
    {
        $metadata->addPropertyConstraints('title', [
            new NotBlank([
                'message' => 'Der Arbeitspaket Titel darf nicht leer sein.'
            ]),
            new Length([
                'min' => 3,
                'max' => 255,
                'maxMessage' => 'Der Arbeitspaket Name {{ value }} ist zu lang. Er darf maximal {{ limit }} Zeichen enthalten.',
                'minMessage' => 'Der Arbeitspaket Name {{ value }} ist zu kurz. Er muss mindestens {{ limit }} Zeichen enthalten.'
            ])
        ]);
        $metadata->addPropertyConstraints('guideTime', [
            new NotBlank([
                'message' => 'Die Richtzeit darf nicht leer sein.'
            ]),
            new GreaterThan([
                'value' => 1,
                'message' => 'Die Richtzeit muss grösser als 0 sein.'
            ])
        ]);
    }
    
    public function toArray() : array
    {
        return [
            'id' => $this->getId(),
            'description' => $this->getDescription(),
            'guide_time' => $this->getGuideTime(),
            'status' => $this->getStatus(),
            'users' => $this->getUsers()->map(fn(User $user) => $user->toArray())->toArray(),
            'records' => $this->getTimeRecords()->map(fn(TimeRecord $record) => $record->toArray())->toArray()
        ];
    }
    
}
