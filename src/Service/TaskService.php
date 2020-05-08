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
        $project = $this->taskRepository->find($id);
        if(!$project) {
            throw new NotFoundException(sprintf('Es existiert kein Arbeitspaket mit der ID %s', $id));
        }
        return $project;
    }
    
    /**
     * @param Request $request
     *
     * @return Task
     * @throws BadRequestException
     * @throws ConflictException
     */
    public function createTaskFromRequest(Request $request) : Task
    {
        $task = Task::fromRequestValues($request->request);
        $this->validateEntity($task);
        if($task->getProject()->getTasks()->exists(fn(Task $cmp) => strcmp($cmp->getTitle(), $task->getTitle()))) {
            throw new ConflictException(sprintf('Es existiert bereits ein Arbeitspaket mit dem Namen %s.', $task->getTitle()));
        }
        return $task;
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
    
}
