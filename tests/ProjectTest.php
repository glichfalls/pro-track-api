<?php


namespace App\Tests;


use App\Entity\Project;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

class ProjectTest extends TestCase
{
    
    public function testFromRequestValues() : void
    {
        $project = Project::fromRequestValues(new ParameterBag([
            'name' => 'Projekt A',
            'description' => 'Beschreibung Projekt A.'
        ]));
        $this->assertEquals('Projekt A', $project->getName());
        $this->assertEquals('Beschreibung Projekt A.', $project->getDescription());
    }
    
}
