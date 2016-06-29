<?php

namespace Game\Matrix;

class DefaultBoardWriter implements BoardWriterInterface
{
    public $primary_colour = "\033[1;32m";
    public $secondary_colour = "\033[0;32m";
    public $reset_colour = "\033[0m";
    public $whitespace = " ";
    public $cell = "o";

    const KATAKANA_MIN = 0x30a0;
    const KATAKANA_MAX = 0x30ff;

    const ASCII_MIN = 33;
    const ASCII_MAX = 126;


    public function writeBoard(Board $board)
    {
        echo $this->boardToString($board);
    }

    public function boardToString(Board $board)
    {
        $output = "";

        for ($y = 0; $y < $board->getHeight(); $y++) {
            for ($x = 0; $x < $board->getWidth(); $x++) {
                $output .= $this->cellToString($board->getCell($x, $y));
            }

            $output .= "\n";
        }

        return $output
            . $this->getCursorUp($board->getHeight())
            . $this->reset_colour;
    }

    public function cellToString($cell)
    {
        $output = "";

        if ($cell) {
            if (2 === $cell) {
                $output .= $this->primary_colour;
            } elseif (1 === $cell) {
                $output .= $this->secondary_colour;
            }

            $output .= $this->getCharacter();
        } else {
            $output .= " ";
        }

        return $output;
    }

    public function getCharacter()
    {
        return chr(rand(self::ASCII_MIN, self::ASCII_MAX));
    }
    
    public function getCursorUp($height)
    {
        return "\033[" . $height . "A";
    }
}
