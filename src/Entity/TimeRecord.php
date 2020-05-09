<?php

namespace App\Entity;

use App\Repository\TimeRecordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=TimeRecordRepository::class)
 */
class TimeRecord implements EntityInterface, Validatable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="bigint")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="timeRecords")
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public static function fromRequestValues(
        ParameterBag $input
    ) : TimeRecord
    {
        $record = new self();
        return $record->applyRequestValues($input);
    }
    
    public function applyRequestValues(ParameterBag $input) : TimeRecord
    {
        $this->setDescription($input->get('description'));
        $this->setTime($input->get('time'));
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

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata) : void
    {
        $metadata->addPropertyConstraints('description', [
            new NotBlank([
                'message' => 'Die Zeiterfassungs Beschreibung darf nicht leer sein.'
            ]),
        ]);
        $metadata->addPropertyConstraints('time', [
            new NotBlank([
                'message' => 'Die erfasste Zeit darf nicht leer sein.'
            ]),
            new Positive([
                'message' => 'Die erfasste Zeit muss eine Positive Zahl sein.'
            ]),
            new GreaterThan([
                'message' => 'Die erfasste Zeit muss grösser als 0 sein.',
                'value' => 1
            ])
        ]);
    }
    
}
