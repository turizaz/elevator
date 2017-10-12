<?php namespace ElevatorBundle\Services;

use ElevatorBundle\Models\RequestModel;
use ElevatorBundle\QueueServiceInterface;
use ElevatorBundle\RequestInterface;
use InvalidArgumentException;

/**
 * Class which responsible for handling queue
 *
 * Class QueueService
 * @package ElevatorBundle\Services
 */
class QueueService implements RequestInterface, QueueServiceInterface
{

    private $requestQueue = [];
    private $currentFloor = 0;
    private $direction;

    /**
     * Handle incoming requests
     *
     * @param RequestModel $request
     * @return $this
     */
    public function addRequest(RequestModel $request)
    {
        $this->requestQueue[] = $request;
        return $this;
    }

    /**
     * Decide in which direction lift should goes
     */
    public function handleQueue()
    {
        $above = [];
        $below = [];
        array_walk($this->requestQueue, function ($request) use (&$above, &$below){
           if($request->getFloor() > $this->currentFloor) {
               $above[] = $request;
           } else {
               $below[] = $request;
           }
        });
        if(count($above) >= count($below)) {
            $this->direction = RequestModel::DIRECTION_UP;
        } else {
            $this->direction = RequestModel::DIRECTION_DOWN;
        }
    }

    /**
     * Getter for direction
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Getter for current floor
     * @return int
     */
    public function getCurrentFloor()
    {
        return $this->currentFloor;
    }

    /**
     * Print explanatory message
     */
    public function printFloorMessage()
    {
        echo sprintf("<br/>we are on %d floor", $this->currentFloor);
    }

    /**
     * Get next floor from queue
     * @return null
     */
    public function getNextFloor()
    {
        $next = null;
        array_walk($this->requestQueue, function ($request) use (&$next) {
            if ($request->getDirection() === $this->getDirection() || is_null($request->getDirection()) || count($this->requestQueue) === 1) {
                switch ($this->getDirection()) {
                    case RequestModel::DIRECTION_UP:
                        if ($request->getFloor() >= $this->currentFloor ) {
                            if (is_null($next)) {
                                $next = $request->getFloor();
                            } elseif ($request->getFloor() < $next) {
                                $next = $request->getFloor();
                            }
                        }
                        break;
                    case RequestModel::DIRECTION_DOWN:
                        if ($request->getFloor() < $this->currentFloor) {
                            if(is_null($next)) {
                                $next = $request->getFloor();
                            } elseif($request->getFloor() > $next) {
                                $next = $request->getFloor();
                            }
                        }
                        break;
                }
            }
        });
        return $next;
    }

    /**
     * Remove floor from queue
     * @param $floor
     *
     */
    public function removeFromQueue($floor)
    {
        $this->requestQueue = array_filter($this->requestQueue, function ($request) use ($floor) {
            return $request->getFloor() !== $floor;
        });
        $this->assignCurrentFloor($floor);
    }

    /**
     * AssignCurrent Floor
     * @param $floor
     * @throws InvalidArgumentException
     *
     */
    private function assignCurrentFloor($floor)
    {
        if (!is_int($floor)) {
            throw new InvalidArgumentException('Number of floor could be only integers. Input was: '.$floor);
        }
        $this->currentFloor = $floor;
    }

    /**
     * Getter for queue
     * @return array
     */
    public function getRequestQueue()
    {
        return $this->requestQueue;
    }
}