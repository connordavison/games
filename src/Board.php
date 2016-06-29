<?php

namespace Game;

abstract class Board
{
    /**
     * @var array The cells on this board.
     */
    protected $cells;

    /**
     * @var mixed The default value for cells.
     */
    protected $blank = false;

    /**
     * Create a Board with given width and height.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct($width, $height)
    {
        $cells = [];

        $this->width = $width;
        $this->height = $height;

        for ($i = 0; $i < $height; $i++) {
            for ($j = 0; $j < $width; $j++) {
                $cells[$i][$j] = false;
            }
        }

        $this->cells = $cells;
    }

    /**
     * Advance this board to its next generation.
     */
    abstract public function step();

    /**
     * Set the value of a cell on this board.
     *
     * @param int $x
     * @param int $y
     * @param mixed $val
     */
    public function setCell($x, $y, $val)
    {
        $this->checkCoords($x, $y);

        $this->cells[$y][$x] = $val;
    }

    /**
     * Obtain the value of a cell on this board.
     *
     * @param int $x
     * @param int $y
     * @return mixed
     */
    public function getCell($x, $y)
    {
        $this->checkCoords($x, $y);

        return $this->cells[$y][$x];
    }

    /**
     * Determine if the cell with given co-ordinates exists on this board.
     *
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function hasCell($x, $y)
    {
        return isset($this->cells[$y][$x]);
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $x
     * @param int $y
     * @throws \OutOfRangeException If given co-ordinates are out of range.
     */
    protected function checkCoords($x, $y)
    {
        if (!$this->hasCell($x, $y)) {
            throw new \OutOfRangeException("Cell does not exist at ($x, $y)");
        }
    }
}
