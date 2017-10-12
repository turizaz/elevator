<?php namespace ElevatorBundle;

/**
 * Interface QueueServiceInterface
 * @package ElevatorBundle
 */
interface QueueServiceInterface
{
    public function removeFromQueue($id);
    public function printFloorMessage();
    public function getRequestQueue();
    public function getNextFloor();
    public function getCurrentFloor();
    public function getDirection();
}