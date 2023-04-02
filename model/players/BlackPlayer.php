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
            new Pawn(Piece::BLACK, 7, 1),
            new Pawn(Piece::BLACK, 7, 2),
            new Pawn(Piece::BLACK, 7, 3),
            new Pawn(Piece::BLACK, 7, 4),
            new Pawn(Piece::BLACK, 7, 5),
            new Pawn(Piece::BLACK, 7, 6),
            new Pawn(Piece::BLACK, 7, 7),
            new Pawn(Piece::BLACK, 7, 8),
            new Rook(Piece::BLACK, 8, 1),
            new Rook(Piece::BLACK, 8, 8),
            new Bishop(Piece::BLACK, 8, 2),
            new Bishop(Piece::BLACK, 8, 7),
            new Queen(Piece::BLACK, 8, 4),
            new King(Piece::BLACK, 8, 5),
            new Knight(Piece::BLACK, 8, 3),
            new Knight(Piece::BLACK, 8, 6),
        ];
    }
}