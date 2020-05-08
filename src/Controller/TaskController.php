<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends BaseController
{

    public function getTasks() : Response
    {

        $tasks = $this->getDoctrine()
            ->getRepository(Task::class)
            ->findAll();

        return $this->getJsonResponse(200, '', $tasks);

    }

}
