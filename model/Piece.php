<?php

abstract class Piece
{
    public const WHITE = 0;
    public const BLACK = 1;

    public int $value;
    public int $color;
    public string $char;

    public int $xPosition;
    public int $yPosition;

    public function __construct(int $color, int $xPosition, int $yPosition)
    {
        if ($color !== self::BLACK && $color !== self::WHITE) {
            throw new \Exception('Bad piece color.');
        }

        $this->color = $color;
        $this->xPosition = $xPosition;
        $this->yPosition = $yPosition;
    }

    public abstract function canMove(int $toX, int $toY, Board $board): bool;

    /**
     * @return array<int, array<int, bool>
     */
    public function movePreview(Board $board): array
    {
        $preview = [];
        for ($x=1; $x <= Board::DIMENSION; $x++) {
            $preview[$x] = [];
            for ($y=1; $y <= Board::DIMENSION; $y++) {
                $preview[$x][$y] = $this->canMove($x, $y, $board);
            }
        }

        return $preview;
    }

    protected function canLinearMove(int $toX, int $toY, Board $board): bool
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

        if ($toX === $this->xPosition && $toY !== $this->yPosition) {
            if ($toY > $this->yPosition) {
                for ($y = $this->yPosition + 1; $y < $toY; $y++) {
                    if ($board->getBoard()[$toX][$y] !== null) {
                        return false;
                    }
                }
            } else {
                for ($y = $this->yPosition - 1; $y > $toY; $y--) {
                    if ($board->getBoard()[$toX][$y] !== null) {
                        return false;
                    }
                }
            }
            return true;
        }
        if ($toX !== $this->xPosition && $toY === $this->yPosition) {
            if ($toX > $this->xPosition) {
                for ($x = $this->xPosition + 1; $x < $toX; $x++) {
                    if ($board->getBoard()[$x][$toY] !== null) {
                        return false;
                    }
                }
            } else {
                for ($x = $this->xPosition - 1; $x > $toX; $x--) {
                    if ($board->getBoard()[$x][$toY] !== null) {
                        return false;
                    }
                }
            }
            return true;
        }

        return false;
    }

    protected function canDiagonalMove(int $toX, int $toY, Board $board): bool
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

        if (abs($this->yPosition - $toY) !== abs($this->xPosition - $toX)) {
            return false;
        }

        if ($toX > $this->xPosition && $toY > $this->yPosition) {
            for ($i = 1; $i < abs($this->yPosition - $toY); $i++) {
                if ($board->getBoard()[$this->xPosition + $i][$this->yPosition + $i] !== null) {
                    return false;
                }
            }
            return true;
        }

        if ($toX > $this->xPosition && $toY < $this->yPosition) {
            for ($i = 1; $i < abs($this->yPosition - $toY); $i++) {
                if ($board->getBoard()[$this->xPosition + $i][$this->yPosition - $i] !== null) {
                    return false;
                }
            }
            return true;
        }

        if ($toX < $this->xPosition && $toY > $this->yPosition) {
            for ($i = 1; $i < abs($this->yPosition - $toY); $i++) {
                if ($board->getBoard()[$this->xPosition - $i][$this->yPosition + $i] !== null) {
                    return false;
                }
            }
            return true;
        }

        if ($toX < $this->xPosition && $toY < $this->yPosition) {
            for ($i = 1; $i < abs($this->yPosition - $toY); $i++) {
                if ($board->getBoard()[$this->xPosition - $i][$this->yPosition - $i] !== null) {
                    return false;
                }
            }
            return true;
        }

        return false;
    }
}