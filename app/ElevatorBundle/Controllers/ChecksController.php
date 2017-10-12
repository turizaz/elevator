<?php namespace ElevatorBundle\Controllers;
use ElevatorBundle\checksInterface;
use Exception;
use InvalidArgumentException;

/**
 * Class which handle checks logic
 *
 * Class ChecksController
 * @package ElevatorBundle\Controllers
 */
class ChecksController implements checksInterface
{

    private $peopleLimit;

    /**
     * Accept people limit
     * @param $limit
     */
    public function setPeopleLimit($limit)
    {
        if (!is_int($limit)) {
            throw new InvalidArgumentException('Number of floor could be only integers. Input was: '.$limit);
        }
        $this->peopleLimit = $limit;
    }

    /**
     * Run sequence of checks
     *
     * @return bool
     */
    public function runChecks()
    {
        try {
            $this->countPeople();
            $this->checkSmoke();
        } catch (Exception $exception) {
            echo $exception->getMessage();
            return false;
        }
        return true;
    }

    /**
     * Count people check
     */
    private function countPeople()
    {

    }

    /**
     * Check smoke method
     */
    private function checkSmoke()
    {

    }

}