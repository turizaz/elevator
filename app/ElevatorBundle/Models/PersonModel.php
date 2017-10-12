<?php namespace ElevatorBundle\Models;

use ElevatorBundle\RequestInterface;

/**
 * Class PersonModel
 * @package ElevatorBundle\Models
 */
class PersonModel implements RequestInterface
{

    private $requests = [];

    /**
     * @param RequestModel $requestModel
     */
    public function addRequest(RequestModel $requestModel)
    {
        $this->requests[] = $requestModel;
    }

    /**
     * @return array
     */
    public function getRequests()
    {
        return $this->requests;
    }

}