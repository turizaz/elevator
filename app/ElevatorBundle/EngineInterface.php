<?php namespace ElevatorBundle;

/**
 * Interface EngineInterface
 * @package ElevatorBundle
 */
interface EngineInterface
{
    public function moveToTheFloor($currentFloor, $destinationFloor);
}