<?php namespace ElevatorBundle;

use ElevatorBundle\Models\RequestModel;

/**
 * Interface RequestInterface
 * @package ElevatorBundle
 */
interface RequestInterface
{
    public function addRequest(RequestModel $requestModel);
}
