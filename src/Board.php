<?php

namespace Life;

class Board
{
    /**
     * @see setWriter
     * @see draw
     * @var BoardWriterInterface
     */
    protected $writer;

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
        $this->setWriter(new DefaultBoardWriter);

        for ($i = 0; $i < $height; $i++) {
            for ($j = 0; $j < $width; $j++) {
                $cells[$i][$j] = false;
            }
        }

        $this->cells = $cells;
    }

    /**
     * Seed this board with live cells.
     *
     * @param int[][] $seeds An array of co-ordinate pairs, f.e. [[1,2], [3,4]]
     * @throws \OutOfRangeException If a given pair of co-ordinates doesn't
     *     exist on the board.
     */
    public function seed($seeds)
    {
        foreach ($seeds as $seed) {
            list($x, $y) = $seed;

            if (!isset($this->cells[$y][$x])) {
                throw new \OutOfRangeException(
                    "Cell does not exist at ($x, $y)"
                );
            }

            $this->cells[$y][$x] = true;
        }
    }

    /**
     * Advance this board to its next generation.
     */
    public function step()
    {
        $next_cells = [];

        for ($x = 0; $x < $this->width; $x++) {
            for ($y = 0; $y < $this->height; $y++) {
                $old_cell = $this->cells[$y][$x];
                $alive_neighbours = $this->getAliveNeighbourCount($x, $y);

                if (2 === $alive_neighbours) {
                    $next_cells[$y][$x] = $old_cell;
                } elseif (3 === $alive_neighbours) {
                    $next_cells[$y][$x] = true;
                } else {
                    $next_cells[$y][$x] = false;
                }
            }
        }

        $this->cells = $next_cells;
    }

    /**
     * Get the value of the cell at given co-ordinates.
     *
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function getCell($x, $y)
    {
        return $this->cells[$y][$x];
    }

    /**
     * Identifies how many alive neighbours are in the neighbourhood of a given
     * point on this board.
     *
     * @param int $x
     * @param int $y
     * @return int
     */
    public function getAliveNeighbourCount($x, $y)
    {
        if (!isset($this->cells[$y][$x])) {
            throw new \OutOfRangeException(
                "Cell does not exist at ($x, $y)"
            );
        }

        $count = 0;

        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                if (0 === $i && 0 === $j) {
                    continue;
                }

                if (isset($this->cells[$y + $i][$x + $j])) {
                    if ($this->cells[$y + $i][$x + $j]) {
                        $count++;
                    }
                }
            }
        }

        return $count;
    }

    /**
     * Get the width of this board.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Get the height of this board.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set a BoardWriterInterface for this Board to use.
     *
     * @see draw
     * @param BoardWriterInterface $writer
     */
    public function setWriter(BoardWriterInterface $writer)
    {
        $this->writer = $writer;
    }

    /**
     * Output this board using this board's BoardWriterInterface.
     *
     * @see setWriter
     * @return void
     */
    public function draw()
    {
        $this->writer->writeBoard($this);
    }
}
