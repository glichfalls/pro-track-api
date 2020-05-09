<?php

namespace App\Controller;


use App\Entity\TimeRecord;
use App\Exceptions\HTTPException;
use App\Factory\ResponseFactory;
use App\Service\TaskService;
use App\Service\TimeRecordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TimeRecordController extends BaseController
{
    
    public function getRecordById(int $id, TimeRecordService $service) : Response
    {
        try {
            return ResponseFactory::createJsonResponse(200, '', $service->getTimeRecordById($id));
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
    }
    
    public function createRecord(int $id, Request $request, TimeRecordService $service, TaskService $taskService) : Response
    {
        try {
            $record = $service->createTimeRecordFromRequest(
                $this->getAuthenticatedUser($request),
                $id,
                $taskService,
                $request
            );
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($record);
        $manager->flush();
        return ResponseFactory::createSuccessResponse(
            'Die erfasste Zeit wurde erstellt.',
            $record
        );
    }
    
    public function updateRecord(int $id, Request $request, TimeRecordService $projectService) : Response
    {
        try {
            $project = $projectService->updateTimeRecordFromRequest($id, $request);
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
        $this->getDoctrine()->getManager()->flush();
        return ResponseFactory::createSuccessResponse(
            'Die erfasste Zeit wurde erfolgreich aktualisiert.',
            $project
        );
    }
    
    public function deleteRecord(int $id, TimeRecordService $service) : Response
    {
        try {
            $project = $service->getTimeRecordById($id);
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($project);
            $manager->flush();
            return ResponseFactory::createSuccessResponse('Die erfasste Zeit wurde gelöscht.');
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
    }
    
}
