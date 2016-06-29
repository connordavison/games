<?php

namespace Game\Life;

class Board extends \Game\Board
{
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
            $this->setCell($x, $y, true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function step()
    {
        $next_cells = [];

        for ($x = 0; $x < $this->width; $x++) {
            for ($y = 0; $y < $this->height; $y++) {
                $old_cell = $this->getCell($x, $y);
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
     * Identifies how many alive neighbours are in the neighbourhood of a given
     * point on this board.
     *
     * @param int $x
     * @param int $y
     * @return int
     */
    public function getAliveNeighbourCount($x, $y)
    {
        $count = 0;

        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                if (0 === $i && 0 === $j) {
                    continue;
                }

                if ($this->hasCell($x + $j, $y + $i)
                    && $this->getCell($x + $j, $y + $i)
                ) {
                    $count++;
                }
            }
        }

        return $count;
    }
}
