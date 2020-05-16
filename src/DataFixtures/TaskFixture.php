<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        # Projekt A
        $task = new Task();
        $task->setTitle(sprintf('Aufgabe 1.'));
        $task->setDescription('Aufgabe 1 für Projekt A.');
        $task->setGuideTime((string) 360);
        $task->setStatus(Task::STATUS_OPEN);
        $task->setProject($this->getProject(1));
        $task->getUsers()->add($this->getUser(1));
        $task->getUsers()->add($this->getUser(4));
        $task->getUsers()->add($this->getUser(5));
        $manager->persist($task);
        $this->addReference(Task::class . '_' . 1, $task);
        $task = new Task();
        $task->setTitle(sprintf('Aufgabe 2.'));
        $task->setDescription('Aufgabe 2 für Projekt A.');
        $task->setGuideTime((string) 60);
        $task->setStatus(Task::STATUS_FINISHED);
        $task->setProject($this->getProject(1));
        $task->getUsers()->add($this->getUser(1));
        $task->getUsers()->add($this->getUser(5));
        $manager->persist($task);
        $this->addReference(Task::class . '_' . 2, $task);
        $task = new Task();
        $task->setTitle(sprintf('Aufgabe 3.'));
        $task->setDescription('Aufgabe 3 für Projekt A.');
        $task->setGuideTime((string) 90);
        $task->setStatus(Task::STATUS_OPEN);
        $task->setProject($this->getProject(1));
        $task->getUsers()->add($this->getUser(1));
        $task->getUsers()->add($this->getUser(4));
        $manager->persist($task);
        $this->addReference(Task::class . '_' . 3, $task);
        # Projekt B
        $task = new Task();
        $task->setTitle(sprintf('Aufgabe 1.'));
        $task->setDescription('Aufgabe 1 für Projekt B.');
        $task->setGuideTime((string) 120);
        $task->setStatus(Task::STATUS_OPEN);
        $task->setProject($this->getProject(2));
        $task->getUsers()->add($this->getUser(2));
        $task->getUsers()->add($this->getUser(3));
        $manager->persist($task);
        $this->addReference(Task::class . '_' . 4, $task);
        # Projekt C
        $task = new Task();
        $task->setTitle(sprintf('Aufgabe 1.'));
        $task->setDescription('Aufgabe 1 für Projekt C.');
        $task->setGuideTime((string) 30);
        $task->setStatus(Task::STATUS_FINISHED);
        $task->setProject($this->getProject(3));
        $task->getUsers()->add($this->getUser(2));
        $task->getUsers()->add($this->getUser(5));
        $manager->persist($task);
        $this->addReference(Task::class . '_' . 5, $task);
        $task = new Task();
        $task->setTitle(sprintf('Aufgabe 2.'));
        $task->setDescription('Aufgabe 2 für Projekt C.');
        $task->setGuideTime((string) 480);
        $task->setStatus(Task::STATUS_OPEN);
        $task->setProject($this->getProject(3));
        $task->getUsers()->add($this->getUser(2));
        $task->getUsers()->add($this->getUser(3));
        $task->getUsers()->add($this->getUser(4));
        $task->getUsers()->add($this->getUser(5));
        $manager->persist($task);
        $this->addReference(Task::class . '_' . 6, $task);
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [
            UserFixture::class,
            ProjectFixture::class
        ];
    }
}
