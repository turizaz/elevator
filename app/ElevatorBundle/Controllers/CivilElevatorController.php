<?php namespace ElevatorBundle\Controllers;

use ElevatorBundle\ChecksInterface;
use ElevatorBundle\DoorsInterface;
use ElevatorBundle\EngineInterface;
use ElevatorBundle\Models\PersonModel;
use ElevatorBundle\Models\RequestModel;
use ElevatorBundle\QueueServiceInterface;


/**
 * Civil Elevator Controller class
 *
 * Class CivilElevatorController
 * @package ElevatorBundle\Controllers
 */
class CivilElevatorController extends AbstractElevatorController
{

    const PEOPLE_LIMIT = 10;

    /**
     * AbstractElevatorController constructor.
     *
     * @param QueueServiceInterface $queueService
     * @param DoorsInterface $doorsController
     * @param ChecksInterface $checksController
     * @param EngineInterface $engineController
     *
     */
    public function __construct(QueueServiceInterface $queueService, DoorsInterface $doorsController, ChecksInterface $checksController, EngineInterface $engineController)
    {
        $this->queueService = $queueService;
        $this->doorsController = $doorsController;
        $this->checksController = $checksController;
        $this->checksController->setPeopleLimit(self::PEOPLE_LIMIT);
        $this->engineController = $engineController;
    }

    /**
     * Add request
     *
     * @param PersonModel $personModel
     * @return $this
     */
    public function addRequest(PersonModel $personModel)
    {

        foreach ($personModel->getRequests() as $requestModel) {
            $this->queueService->addRequest($requestModel);
        }

        return $this;
    }

    /**
     * Handle incoming requests
     *
     * @return CivilElevatorController $this
     */
    public function handleRequest()
    {
       $this->queueService->handleQueue();
       if($this->queueService->getDirection() === RequestModel::DIRECTION_UP) {
           for($i = $this->queueService->getCurrentFloor(); $i <= $this->queueService->getNextFloor(); $i++) {
               if ($i === $this->queueService->getNextFloor()) {
                   $this->engineController->moveToTheFloor($this->queueService->getCurrentFloor(), $this->queueService->getNextFloor());
                   $this->doorsController->open();
                   $this->queueService->removeFromQueue($i);
                   $this->queueService->printFloorMessage();
                   if ($this->checksController->runChecks()) {
                       $this->doorsController->close();
                   }
               }
               if(!$this->queueService->getNextFloor()) {
                   break;
               }
           }
       } elseif ($this->queueService->getDirection() === RequestModel::DIRECTION_DOWN) {
           for($i = $this->queueService->getCurrentFloor(); $i >= $this->queueService->getNextFloor(); $i--) {
               if ($i === $this->queueService->getNextFloor()) {
                   $this->engineController->moveToTheFloor($this->queueService->getCurrentFloor(), $this->queueService->getNextFloor());
                   $this->doorsController->open();
                   $this->queueService->removeFromQueue($i);
                   $this->queueService->printFloorMessage();
                   if ($this->checksController->runChecks()) {
                       $this->doorsController->close();
                   }
                   if(!$this->queueService->getNextFloor()) {
                        break;
                   }
               }
           }
       }

       // check if we have have something in queue make a recursion call
       if (count($this->queueService->getRequestQueue())) {
           $this->handleRequest();
       }
       return $this;
    }
}