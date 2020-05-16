<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixture extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $project = new Project();
        $project->setName('Projekt A');
        $project->setDescription('Test Projekt A.');
        $project->setStatus(Project::STATUS_OPEN);
        $project->addUser($this->getUser(1));
        $project->addUser($this->getUser(4));
        $project->addUser($this->getUser(5));
        $manager->persist($project);
        $this->addReference(Project::class . '_' . 1, $project);
        $project = new Project();
        $project->setName('Projekt B');
        $project->setDescription('Test Projekt B.');
        $project->setStatus(Project::STATUS_FINISHED);
        $project->addUser($this->getUser(2));
        $project->addUser($this->getUser(3));
        $manager->persist($project);
        $this->addReference(Project::class . '_' . 2, $project);
        $project = new Project();
        $project->setName('Projekt C');
        $project->setDescription('Test Projekt C.');
        $project->setStatus(Project::STATUS_OPEN);
        $project->addUser($this->getUser(2));
        $project->addUser($this->getUser(3));
        $project->addUser($this->getUser(4));
        $project->addUser($this->getUser(5));
        $manager->persist($project);
        $this->addReference(Project::class . '_' . 3, $project);
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [
            UserFixture::class
        ];
    }
    
}
