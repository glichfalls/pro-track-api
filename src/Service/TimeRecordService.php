<?php

namespace App\Service;


use App\Entity\TimeRecord;
use App\Entity\User;
use App\Exceptions\BadRequestException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Factory\AbstractService;
use App\Repository\TimeRecordRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TimeRecordService extends AbstractService
{
    
    private TimeRecordRepository $recordRepository;
    
    public function __construct(ValidatorInterface $validator, TimeRecordRepository $repository)
    {
        parent::__construct($validator);
        $this->recordRepository = $repository;
    }
    
    /**
     * @param int $id
     *
     * @return TimeRecord
     * @throws NotFoundException
     */
    public function getTimeRecordById(int $id) : TimeRecord
    {
        $record = $this->recordRepository->find($id);
        if(!$record) {
            throw new NotFoundException(sprintf('Es existiert kein Arbeitspaket mit der ID %s', $id));
        }
        return $record;
    }
    
    /**
     * @param User        $user
     * @param int         $taskId
     * @param TaskService $taskService
     * @param Request     $request
     *
     * @return TimeRecord
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function createTimeRecordFromRequest(
        User $user,
        int $taskId,
        TaskService $taskService,
        Request $request
    ) : TimeRecord
    {
        $record = TimeRecord::fromRequestValues($request->request);
        $record->setTask($taskService->getTaskById($taskId));
        $this->validateEntity($record);
        return $record->setUser($user);
    }
    
    /**
     * @param int     $id
     * @param Request $request
     *
     * @return TimeRecord
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function updateTimeRecordFromRequest(int $id, Request $request) : TimeRecord
    {
        $record = $this->getTimeRecordById($id);
        $record->applyRequestValues($request->request);
        $this->validateEntity($record);
        return $record;
    }
    
}
