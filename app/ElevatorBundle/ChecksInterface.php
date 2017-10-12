<?php namespace ElevatorBundle;

/**
 * Interface checksInterface
 * @package ElevatorBundle
 */
interface ChecksInterface
{
    public function setPeopleLimit($limit);
    public function runChecks();
}