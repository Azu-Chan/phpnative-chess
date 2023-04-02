<?php

class Bishop extends Piece
{
    public function __construct(int $color, int $xPosition, int $yPosition)
    {
        parent::__construct($color, $xPosition, $yPosition);

        $this->value = 3;

        $this->char = ($this->color === 0) ? '♗' : '♝';
    }

    public function canMove(int $toX, int $toY, Board $board): bool
    {
        return $this->canDiagonalMove($toX, $toY, $board);
    }
}