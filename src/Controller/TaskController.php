<?php

namespace App\Controller;

use App\Entity\Task;
use App\Exceptions\HTTPException;
use App\Factory\ResponseFactory;
use App\Service\ProjectService;
use App\Service\TaskService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends BaseController
{

    public function getTasks() : Response
    {
        return ResponseFactory::createSuccessResponse(
            '',
            $this->getDoctrine()
                ->getRepository(Task::class)
                ->findAll()
        );
    }
    
    public function getTaskById(int $id, TaskService $service) : Response
    {
        try {
            return ResponseFactory::createJsonResponse(200, '', $service->getTaskById($id));
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
    }
    
    public function createTask(Request $request, TaskService $service) : Response
    {
        try {
            $task = $service->createTaskFromRequest($request);
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($task);
        $manager->flush();
        return ResponseFactory::createSuccessResponse(
            sprintf('Das Arbeitspaket %s wurde erstellt.', $task->getTitle()),
            $task->toArray()
        );
    }
    
    public function updateTask(int $id, Request $request, TaskService $service) : Response
    {
        try {
            $task = $service->updateTaskFromRequest($id, $request);
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
        $this->getDoctrine()->getManager()->flush();
        return ResponseFactory::createSuccessResponse(
            'Das Arbeitspaket wurde erfolgreich aktualisiert.',
            $task->toArray()
        );
    }
    
    public function deleteTask(int $id, TaskService $service) : Response
    {
        try {
            $task = $service->getTaskById($id);
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($task);
            $manager->flush();
            return ResponseFactory::createSuccessResponse(sprintf('Das Arbeitspaket %s wurde gelöscht.', $task->getName()));
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
    }

}
