<?php

namespace Game\Matrix;

interface BoardWriterInterface
{
    /**
     * Display a board
     *
     * @param Board $board
     * @return void
     */
    public function writeBoard(Board $board);
}
