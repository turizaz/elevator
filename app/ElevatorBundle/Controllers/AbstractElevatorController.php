<?php namespace ElevatorBundle\Controllers;

use ElevatorBundle\Models\PersonModel;


/**
 * Class AbstractElevatorController
 * @package ElevatorBundle\Controllers
 */
abstract class AbstractElevatorController
{

    protected $queueService;
    protected $doorsController;
    protected $checksController;
    protected $engineController;


    /**
     * Handle incoming requests
     *
     * @param PersonModel $personModel
     * @return mixed
     *
     */
    abstract public function addRequest(PersonModel $personModel);

    /**
     *
     * @return mixed
     */
    abstract public function handleRequest();
}