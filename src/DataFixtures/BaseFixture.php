<?php

namespace App\DataFixtures;


use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

abstract class BaseFixture extends Fixture
{
    
    private ObjectManager $manager;
    
    abstract protected function loadData(ObjectManager $manager);
    
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadData($manager);
    }
    
    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);
            $this->manager->persist($entity);
            $this->addReference($className . '_' . $i, $entity);
        }
    }
    
    /**
     * @param int $i
     *
     * @return User|object
     */
    protected function getUser(int $i) : User
    {
        return $this->getReference(sprintf('%s_%s', User::class, $i));
    }
    
    /**
     * @param int $i
     *
     * @return Project|object
     */
    protected function getProject(int $i) : Project
    {
        return $this->getReference(sprintf('%s_%s', Project::class, $i));
    }
    
    /**
     * @param int $i
     *
     * @return Task|object
     */
    protected function getTask(int $i) : Task
    {
        return $this->getReference(sprintf('%s_%s', Task::class, $i));
    }
    
    protected function getRandomDate() : \DateTime
    {
        return \DateTime::createFromFormat(
            'd.m.Y',
            date('d.m.Y', mt_rand(strtotime('01.01.2020'), time()))
        );
    }
    
}
