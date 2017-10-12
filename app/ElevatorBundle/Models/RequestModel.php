<?php namespace ElevatorBundle\Models;

use InvalidArgumentException;

/**
 * Class of request
 *
 * Class RequestModel
 * @package ElevatorBundle\Models
 */
class RequestModel
{

    private $floor;
    private $direction = null;

    const DIRECTION_UP = 'UP';
    const DIRECTION_DOWN = 'DOWN';

    /**
     * RequestModel constructor.
     * @param $floor
     * @throws InvalidArgumentException
     * @param null $direction
     */
    public function __construct($floor, $direction = null)
    {
        if (!is_int($floor)) {
            throw new InvalidArgumentException('Number of floor could be only integers. Input was: '.$floor);
        }

        if(!in_array($direction, [RequestModel::DIRECTION_DOWN, RequestModel::DIRECTION_UP, null])) {
            throw new InvalidArgumentException('Direction could be only '.RequestModel::DIRECTION_DOWN.', '.RequestModel::DIRECTION_UP.' or NULL. Input was:'. $direction);
        }

        $this->floor = $floor;
        $this->direction = $direction;
    }

    /**
     * Getter for floor
     * @return int
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Getter for direction
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }
}