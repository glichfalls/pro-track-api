<?php


namespace App\Service;


use App\Entity\Project;
use App\Exceptions\BadRequestException;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Factory\AbstractService;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectService extends AbstractService
{
    
    private ProjectRepository $projectRepository;
    
    public function __construct(ValidatorInterface $validator, ProjectRepository $projectRepository)
    {
        parent::__construct($validator);
        $this->projectRepository = $projectRepository;
        $this->validator = $validator;
    }
    
    /**
     * @param int $id
     *
     * @return Project
     * @throws NotFoundException
     */
    public function getProjectById(int $id) : Project
    {
        $project = $this->projectRepository->find($id);
        if(!$project) {
            throw new NotFoundException(sprintf('Es existiert kein Projekt mit der ID %s', $id));
        }
        return $project;
    }
    
    /**
     * @param Request $request
     *
     * @return Project
     * @throws BadRequestException
     * @throws ConflictException
     */
    public function createProjectFromRequest(Request $request) : Project
    {
        $project = Project::fromRequestValues($request->request);
        $this->validateEntity($project);
        if($this->projectRepository->projectNameExists($project->getName())) {
            throw new ConflictException(sprintf('Es existiert bereits ein Projekt mit dem Namen %s.', $project->getName()));
        }
        return $project;
    }
    
    /**
     * @param int     $id
     * @param Request $request
     *
     * @return Project
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function updateProjectFromRequest(int $id, Request $request) : Project
    {
        $project = $this->getProjectById($id);
        $project->applyRequestValues($request->request);
        $this->validateEntity($project);
        return $project;
    }
    
}
