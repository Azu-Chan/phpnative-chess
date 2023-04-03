<?php

class King extends Piece
{
    public function __construct(int $color, int $xPosition, int $yPosition)
    {
        parent::__construct($color, $xPosition, $yPosition);

        $this->value = 0;

        $this->char = ($this->color === 0) ? '♔' : '♚';
    }

    public function canMove(int $toX, int $toY, Board $board): bool
    {
        if ($this->color === Piece::BLACK) {
            if ($board->getBoard()[$toX][$toY] instanceof Piece && $board->getBoard()[$toX][$toY]->color === Piece::BLACK) {
                return false;
            }

            // Le roi ne peut pas bouger sur une case qui le met en echec
            for ($x=1; $x <= Board::DIMENSION; $x++) {
                for ($y=1; $y <= Board::DIMENSION; $y++) {
                    if ($board->getBoard()[$x][$y] instanceof Piece && ! $board->getBoard()[$x][$y] instanceof King
                    && $board->getBoard()[$x][$y]->color === Piece::WHITE && $board->getBoard()[$x][$y]->canMove($toX, $toY, $board)) {
                        return false;
                    }
                }
            }
        }
        if ($this->color === Piece::WHITE) {
            if ($board->getBoard()[$toX][$toY] instanceof Piece && $board->getBoard()[$toX][$toY]->color === Piece::WHITE) {
                return false;
            }

            // Le roi ne peut pas bouger sur une case qui le met en echec
            for ($x=1; $x <= Board::DIMENSION; $x++) {
                for ($y=1; $y <= Board::DIMENSION; $y++) {
                    if ($board->getBoard()[$x][$y] instanceof Piece && ! $board->getBoard()[$x][$y] instanceof King
                    && $board->getBoard()[$x][$y]->color === Piece::BLACK && $board->getBoard()[$x][$y]->canMove($toX, $toY, $board)) {
                        return false;
                    }
                }
            }
        }

        if (($toX <= $this->xPosition + 1 && $toX >= $this->xPosition - 1)
        && ($toY <= $this->yPosition + 1 && $toY >= $this->yPosition - 1)) {
            return true;
        }

        if ($this->canCastle($toX, $toY, $board)) {
            return true;
        }

        return false;
    }

    public function canCastle(int $toX, int $toY, Board $board): bool
    {
        if ($this->color === Piece::WHITE && $this->moved === false && $this->xPosition === 1 && $this->yPosition === 5) {
            if ($toX === 1 && $toY === 7 && $board->getBoard()[1][6] === null
            && $board->getBoard()[1][7] === null && $board->getBoard()[1][8] instanceof Rook
            && $board->getBoard()[1][8]->color === Piece::WHITE && $board->getBoard()[1][8]->moved === false) {
                return true;
            }

            if ($toX === 1 && $toY === 3 && $board->getBoard()[1][4] === null
            && $board->getBoard()[1][3] === null && $board->getBoard()[1][2] === null 
            && $board->getBoard()[1][1] instanceof Rook && $board->getBoard()[1][1]->color === Piece::WHITE
            && $board->getBoard()[1][1]->moved === false) {
                return true;
            }
        }

        if ($this->color === Piece::BLACK && $this->moved === false && $this->xPosition === 8 && $this->yPosition === 5) {
            if ($toX === 8 && $toY === 7 && $board->getBoard()[8][6] === null
            && $board->getBoard()[8][7] === null && $board->getBoard()[8][8] instanceof Rook
            && $board->getBoard()[8][8]->color === Piece::BLACK && $board->getBoard()[8][8]->moved === false) {
                return true;
            }

            if ($toX === 8 && $toY === 3 && $board->getBoard()[8][4] === null
            && $board->getBoard()[8][3] === null && $board->getBoard()[8][2] === null 
            && $board->getBoard()[8][1] instanceof Rook && $board->getBoard()[8][1]->color === Piece::BLACK
            && $board->getBoard()[8][1]->moved === false) {
                return true;
            }
        }

        return false;
    }
}