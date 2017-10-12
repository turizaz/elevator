<?php

require_once 'app/start.php';


use ElevatorBundle\Models\RequestModel;
use ElevatorBundle\Controllers\CivilElevatorController;
use ElevatorBundle\Services\QueueService;
use ElevatorBundle\Controllers\DoorsController;
use ElevatorBundle\Controllers\ChecksController;
use ElevatorBundle\Controllers\EngineController;
use ElevatorBundle\Models\PersonModel;


$civilElevator = new CivilElevatorController(new QueueService, new DoorsController, new ChecksController, new EngineController);

$person = new PersonModel;
$person->addRequest(new RequestModel(12, RequestModel::DIRECTION_UP));
$person->addRequest(new RequestModel(7, RequestModel::DIRECTION_DOWN));

$person2 = new PersonModel;
$person2->addRequest(new RequestModel(0, RequestModel::DIRECTION_UP));
$person2->addRequest(new RequestModel(13));

$person3 = new PersonModel;
$person3->addRequest(new RequestModel(1,RequestModel::DIRECTION_UP));
$person3->addRequest(new RequestModel(8));


$civilElevator->addRequest($person)
                ->addRequest($person2)
                ->addRequest($person3)
                ->handleRequest();

