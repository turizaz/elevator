<?php namespace ElevatorBundle\Controllers;

use ElevatorBundle\EngineInterface;

/**
 * Controller For Elevator Engine
 *
 * Class EngineController
 * @package ElevatorBundle\Controllers
 */
class EngineController implements EngineInterface
{

    protected function rotateEngine($diff)
    {
        // some logic like rotate $diff * timeOfRotating for 1 floor, also considered a sign for choose side of rotating
    }

    public function moveToTheFloor($currentFloor, $destinationFloor)
    {
        $this->rotateEngine($currentFloor-$destinationFloor);
    }
}