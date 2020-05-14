<?php

namespace App\Service;


use App\Entity\Task;
use App\Exceptions\BadRequestException;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Factory\AbstractService;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskService extends AbstractService
{
    
    private TaskRepository $taskRepository;
    
    public function __construct(ValidatorInterface $validator, TaskRepository $repository)
    {
        parent::__construct($validator);
        $this->taskRepository = $repository;
    }
    
    /**
     * @param int $id
     *
     * @return Task
     * @throws NotFoundException
     */
    public function getTaskById(int $id) : Task
    {
        $task = $this->taskRepository->find($id);
        if(!$task) {
            throw new NotFoundException(sprintf('Es existiert kein Arbeitspaket mit der ID %s', $id));
        }
        return $task;
    }
    
    /**
     * @param int            $projectId
     * @param ProjectService $projectService
     * @param Request        $request
     *
     * @return Task
     * @throws BadRequestException
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function createTaskFromRequest(int $projectId, ProjectService $projectService, Request $request) : Task
    {

        $task = Task::fromRequestValues($request->request);
        $this->validateEntity($task);
        $project = $projectService->getProjectById($projectId);
        if(!$project) {
            throw new BadRequestException(
                'Es wurde kein Projekt ausgewählt. Das Arbeitspaket kann nicht erstellt werden.'
            );
        }
        if($project->getTasks()->exists(fn(int $key, Task $cmp) => $cmp->getTitle() === $task->getTitle())) {
            throw new ConflictException(sprintf(
                'Es existiert bereits ein Arbeitspaket mit dem Namen %s.',
                $task->getTitle()
            ));
        }
        return $task->setProject($project);
    }
    
    /**
     * @param int     $id
     * @param Request $request
     *
     * @return Task
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function updateTaskFromRequest(int $id, Request $request) : Task
    {
        $task = $this->getTaskById($id);
        $task->applyRequestValues($request->request);
        $this->validateEntity($task);
        return $task;
    }
    
    /**
     * @param Task $task
     * @param Request $request
     *
     * @return Task
     * @throws BadRequestException
     */
    public function patchTaskStatusFromRequest(Task $task, Request $request) : Task
    {
        $status = $request->request->get('status');
        if(!$status) {
            throw new BadRequestException('Es wurde kein Status angegeben.');
        }
        if(!in_array($status, [Task::STATUS_OPEN, Task::STATUS_FINISHED])) {
            throw new BadRequestException(sprintf('Es existiert kein Status mit dem code %s.', $status));
        }
        return $task->setStatus($status);
    }
    
}
