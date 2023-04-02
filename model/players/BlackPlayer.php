<?php

class BlackPlayer extends Player
{
    public function getColor(): int
    {
        return Piece::BLACK;
    }

    /**
     * @return Piece[] 
     */
    public function getInitialPieces(): array
    {
        return [
            new Pawn(Piece::BLACK, 2, 1),
            new Pawn(Piece::BLACK, 2, 2),
            new Pawn(Piece::BLACK, 2, 3),
            new Pawn(Piece::BLACK, 2, 4),
            new Pawn(Piece::BLACK, 2, 5),
            new Pawn(Piece::BLACK, 2, 6),
            new Pawn(Piece::BLACK, 2, 7),
            new Pawn(Piece::BLACK, 2, 8),
            new Rook(Piece::BLACK, 1, 1),
            new Rook(Piece::BLACK, 1, 8),
            new Bishop(Piece::BLACK, 1, 2),
            new Bishop(Piece::BLACK, 1, 7),
            new Queen(Piece::BLACK, 1, 4),
            new King(Piece::BLACK, 1, 5),
            new Knight(Piece::BLACK, 1, 3),
            new Knight(Piece::BLACK, 1, 6),
        ];
    }
}