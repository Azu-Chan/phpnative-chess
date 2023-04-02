<?php

class Knight extends Piece
{
    public function __construct(int $color, int $xPosition, int $yPosition)
    {
        parent::__construct($color, $xPosition, $yPosition);

        $this->value = 3;

        $this->char = ($this->color === 0) ? '♘' : '♞';
    }

    public function canMove(int $toX, int $toY, Board $board): bool
    {
        if ($this->color === Piece::BLACK) {
            if ($board->getBoard()[$toX][$toY] instanceof Piece && $board->getBoard()[$toX][$toY]->color === Piece::BLACK) {
                return false;
            }
        }
        if ($this->color === Piece::WHITE) {
            if ($board->getBoard()[$toX][$toY] instanceof Piece && $board->getBoard()[$toX][$toY]->color === Piece::WHITE) {
                return false;
            }
        }

        if (($toX === $this->xPosition + 2 || $toX === $this->xPosition - 2) 
        && ($toY === $this->yPosition + 1 || $toY === $this->yPosition - 1)) {
            return true;
        }

        if (($toX === $this->xPosition + 1 || $toX === $this->xPosition - 1) 
        && ($toY === $this->yPosition + 2 || $toY === $this->yPosition - 2)) {
            return true;
        }

        return false;
    }
}