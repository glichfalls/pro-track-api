<?php

namespace App\DataFixtures;

use App\Entity\TimeRecord;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TimeRecordFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        # Aufgabe 1
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 1.');
        $record->setTime((string) 30);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(4));
        $record->setTask($this->getTask(1));
        $manager->persist($record);
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 1.');
        $record->setTime((string) 60);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(5));
        $record->setTask($this->getTask(1));
        $manager->persist($record);
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 1.');
        $record->setTime((string) 15);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(4));
        $record->setTask($this->getTask(1));
        $manager->persist($record);
        # Aufgabe 2
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 2.');
        $record->setTime((string) 60);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(5));
        $record->setTask($this->getTask(2));
        $manager->persist($record);
        # Aufgabe 3
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 3.');
        $record->setTime((string) 45);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(4));
        $record->setTask($this->getTask(3));
        $manager->persist($record);
        # Aufgabe 4
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 4.');
        $record->setTime((string) 90);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(3));
        $record->setTask($this->getTask(4));
        $manager->persist($record);
        $manager->flush();
        # Aufgabe 5
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 5.');
        $record->setTime((string) 30);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(5));
        $record->setTask($this->getTask(5));
        $manager->persist($record);
        $manager->flush();
        # Aufgabe 6
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 6.');
        $record->setTime((string) 15);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(3));
        $record->setTask($this->getTask(6));
        $manager->persist($record);
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 6.');
        $record->setTime((string) 90);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(3));
        $record->setTask($this->getTask(6));
        $manager->persist($record);
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 6.');
        $record->setTime((string) 30);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(4));
        $record->setTask($this->getTask(6));
        $manager->persist($record);
        $record = new TimeRecord();
        $record->setDescription('Zeit erfasst für Aufgabe 6.');
        $record->setTime((string) 45);
        $record->setDate($this->getRandomDate());
        $record->setUser($this->getUser(5));
        $record->setTask($this->getTask(6));
        $manager->persist($record);
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [
            UserFixture::class,
            ProjectFixture::class,
            TaskFixture::class
        ];
    }
    
}
