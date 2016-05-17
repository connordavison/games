<?php

namespace Life;

class DefaultBoardWriter implements BoardWriterInterface
{
    /**
     * {@inheritdoc}
     */
    public function writeBoard(Board $board)
    {
        $output = "";
        $green = "\033[1;32m";
        $dark_green = "\033[0;32m";
        $cursor_up = "\033[" . $board->getHeight() . "A";

        for ($y = 0; $y < $board->getHeight(); $y++) {
            for ($x = 0; $x < $board->getWidth(); $x++) {
                $cell = $board->getCell($x, $y);

                if ($cell) {
                    $alive_neighbours = $board->getAliveNeighbourCount($x, $y);

                    if (in_array($alive_neighbours, [2, 3])) {
                        $output .= $green;
                    } else {
                        $output .= $dark_green;
                    }

                    $output .= "o";
                } else {
                    $output .= " ";
                }
            }

            $output .= "\n";
        }

        echo $output . $cursor_up;
    }
}
