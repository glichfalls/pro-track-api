<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectController extends BaseController
{

    public function getProjects() : Response
    {
        
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        
        return $this->getJsonResponse(200, '', $projects);
        
    }
    
    public function getProjectById(int $id) : Response
    {
        
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($id);
        
        if(!$project) {
            return $this->getJsonResponse(404, sprintf('Es existiert kein Projekt mit der ID %s', $id));
        }
        
         return $this->getJsonResponse(200, '', $project);
        
    }
    
    public function createProject(Request $request, ValidatorInterface $validator) : Response
    {
    
        $project = Project::fromRequestValues($request->request);
        
        $errors = $validator->validate($project);
        
        if(count($errors) > 0) {
            return $this->getJsonResponse(400, $errors->get(0)->getMessage());
        }
        
        $manager = $this->getDoctrine()->getManager();
        
        $manager->persist($project);
        
        $manager->flush();
        
        return $this->getJsonResponse(200, 'Das Projekt wurde erfolgreich erstellt.', $project);
    
    }
    
    public function updateProject(int $id, Request $request, ValidatorInterface $validator) : Response
    {
    
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($id);
        
        if(!$project) {
            return $this->json(404, sprintf('Es existiert kein Projekt mit der ID %s', $id));
        }
        
        $project->withRequestValues($request->request);
        
        $errors = $validator->validate($project);
        
        if(count($errors) > 0) {
            return $this->getJsonResponse(400, $errors->get(0)->getMessage());
        }
        
        $manager = $this->getDoctrine()->getManager();
        
        $manager->flush();
        
        return $this->getJsonResponse(200, 'Das Projekt wurde erfolgreich aktualisiert', $project);
        
    }
    
    public function deleteProject() : Response
    {
    
    
    
    }
    
}
