<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{

    public function getProjects()
    {
        
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        
        return $this->json($projects);
        
    }
    
    public function getProjectById(int $id)
    {
        
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($id);
        
        if(!$project) {
            throw $this->createNotFoundException(sprintf('Es existiert kein Projekt mit der ID %s', $id));
        }
        
         return $this->json($project);
        
    }
    
}
