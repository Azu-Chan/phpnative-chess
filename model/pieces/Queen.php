<?php

class Queen extends Piece
{
    public function __construct(int $color, int $xPosition, int $yPosition)
    {
        parent::__construct($color, $xPosition, $yPosition);

        $this->value = 9;

        $this->char = ($this->color === 0) ? '♕' : '♛';
    }

    public function canMove(int $toX, int $toY, Board $board): bool
    {
        return $this->canLinearMove($toX, $toY, $board) || $this->canDiagonalMove($toX, $toY, $board);
    }
}