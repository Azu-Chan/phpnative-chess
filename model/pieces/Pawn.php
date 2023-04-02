<?php

class Pawn extends Piece
{
    public function __construct(int $color, int $xPosition, int $yPosition)
    {
        parent::__construct($color, $xPosition, $yPosition);

        $this->value = 1;

        $this->char = ($this->color === 0) ? '♙' : '♟';
    }

    public function canMove(int $toX, int $toY, Board $board): bool
    {
        if ($this->color === Piece::WHITE) {
            if ($toX === ($this->xPosition + 1) && $toY === $this->yPosition && $board->getBoard()[$toX][$toY] === null) {
                return true;
            }
            if ($toX === ($this->xPosition + 1) 
            && ($toY === ($this->yPosition - 1) || $toY === ($this->yPosition + 1))
            && $board->getBoard()[$toX][$toY] instanceof Piece && $board->getBoard()[$toX][$toY]->color === Piece::BLACK) {
                return true;
            }
            if ($this->xPosition === 2 && $toX === ($this->xPosition + 2) && $toY === $this->yPosition && $board->getBoard()[$toX][$toY] === null) {
                return true;
            }

            return false;
        }

        // Piece::WHITE
        if ($toX === ($this->xPosition - 1) && $toY === $this->yPosition && $board->getBoard()[$toX][$toY] === null) {
            return true;
        }
        if ($toX === ($this->xPosition - 1) 
        && ($toY === ($this->yPosition - 1) || $toY === ($this->yPosition + 1))
        && $board->getBoard()[$toX][$toY] instanceof Piece && $board->getBoard()[$toX][$toY]->color === Piece::WHITE) {
            return true;
        }
        if ($this->xPosition === 7 && $toX === ($this->xPosition - 2) && $toY === $this->yPosition && $board->getBoard()[$toX][$toY] === null) {
            return true;
        }

        return false;
    }
}