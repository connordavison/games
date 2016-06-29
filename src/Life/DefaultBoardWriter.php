<?php

namespace Game\Life;

class DefaultBoardWriter implements BoardWriterInterface
{
    public $primary_colour = "\033[1;32m";
    public $secondary_colour = "\033[0;32m";
    public $reset_colour = "\033[0m";
    public $whitespace = " ";
    public $cell = "o";

    /**
     * {@inheritdoc}
     */
    public function writeBoard(Board $board)
    {
        echo $this->boardToString($board);
    }

    /**
     * @param Board $board
     * @return string
     */
    public function boardToString(Board $board)
    {
        $output = "";

        for ($y = 0; $y < $board->getHeight(); $y++) {
            for ($x = 0; $x < $board->getWidth(); $x++) {
                $output .= $this->cellToString($board, $x, $y);
            }

            $output .= "\n";
        }

        return $output
            . $this->getCursorUp($board->getHeight())
            . $this->reset_colour;
    }

    /**
     * @param Board $board
     * @param $x
     * @param $y
     * @return string
     */
    public function cellToString(Board $board, $x, $y)
    {
        $cell = $board->getCell($x, $y);

        if (!$cell) {
            return $this->whitespace;
        }

        $alive_neighbours = $board->getAliveNeighbourCount($x, $y);

        if (in_array($alive_neighbours, [2, 3])) {
            return $this->primary_colour . $this->cell;
        }

        return $this->secondary_colour . $this->cell;
    }

    public function getCursorUp($height)
    {
        return "\033[" . $height . "A";
    }
}
