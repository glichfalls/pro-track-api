<?php

namespace App\Controller;

use App\Entity\Project;
use App\Exceptions\HTTPException;
use App\Factory\ResponseFactory;
use App\Service\ProjectService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends BaseController
{
    
    public function getProjects() : Response
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        return ResponseFactory::createSuccessResponse('', $projects);
    }
    
    public function getProjectById(int $id, ProjectService $service) : Response
    {
        try {
            return ResponseFactory::createJsonResponse(200, '', $service->getProjectById($id));
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
    }
    
    public function createProject(Request $request, ProjectService $service) : Response
    {
        try {
            $project = $service->createProjectFromRequest($request);
            $project->getUsers()->add($this->getAuthenticatedUser($request));
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($project);
        $manager->flush();
        return ResponseFactory::createSuccessResponse(
            sprintf('Das Projekt %s wurde erstellt.', $project->getName()),
            $project
        );
    }
    
    public function updateProject(int $id, Request $request, ProjectService $projectService) : Response
    {
        try {
            $project = $projectService->updateProjectFromRequest($id, $request);
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
        $this->getDoctrine()->getManager()->flush();
        return ResponseFactory::createSuccessResponse(
            'Das Projekt wurde erfolgreich aktualisiert.',
            $project
        );
    }
    
    public function deleteProject(int $id, ProjectService $service) : Response
    {
        try {
            $project = $service->getProjectById($id);
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($project);
            $manager->flush();
            return ResponseFactory::createSuccessResponse(sprintf('Das Projekt %s wurde gelöscht.', $project->getName()));
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
    }
    
    public function changeProjectStatus(Request $request, int $id, ProjectService $service) : Response
    {
        try {
            $project = $service->getProjectById($id);
            $project = $service->patchProjectStatusFromRequest($project, $request);
            $this->getDoctrine()->getManager()->flush();
            switch($project->getStatus()) {
                case Project::STATUS_OPEN:
                    return ResponseFactory::createSuccessResponse(
                        sprintf('Das Projekt %s wurde neu eröffnet.', $project->getName()),
                        $project
                    );
                case Project::STATUS_FINISHED:
                    return ResponseFactory::createSuccessResponse(
                        sprintf('Das Projekt %s wurde beendet.', $project->getName()),
                        $project
                    );
                default:
                    return ResponseFactory::createServerErrorResponse('Es ist ein Fehler beim ändern des Status aufgetreten.');
            }
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
    }
    
}
