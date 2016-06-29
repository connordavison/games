<?php

namespace Game\Matrix;

class Board extends \Game\Board
{
    /**
     * @var double In the range 0 - getRandMax() (inclusive).
     */
    protected $spawn_rate;

    /**
     * @var double In the range 0 - getRandMax() (inclusive).
     */
    protected $decay_rate;

    /**
     * {@inheritdoc}
     */
    protected $blank = 0;

    /**
     * @param double $spawn_rate
     * @param double $decay_rate
     */
    public function seed($spawn_rate, $decay_rate)
    {
        $this->spawn_rate = $spawn_rate * getrandmax();
        $this->decay_rate = $decay_rate * getrandmax();
    }

    /**
     * {@inheritdoc}
     */
    public function step()
    {
        array_pop($this->cells);

        $row = [];

        foreach ($this->cells[0] as $cell) {
            $rand = rand();

            if ($rand < $this->spawn_rate) {
                $row[] = 2;
            } elseif ($cell) {
                $row[] = $rand < $this->decay_rate ? $cell - 1 : $cell;
            } else {
                $row[] = 0;
            }
        }

        array_unshift($this->cells, $row);
    }
}
