<?php

class WhitePlayer extends Player
{
    public function getColor(): int
    {
        return Piece::WHITE;
    }

    /**
     * @return Piece[] 
     */
    public function getInitialPieces(): array
    {
        return [
            new Pawn(Piece::WHITE, 2, 1),
            new Pawn(Piece::WHITE, 2, 2),
            new Pawn(Piece::WHITE, 2, 3),
            new Pawn(Piece::WHITE, 2, 4),
            new Pawn(Piece::WHITE, 2, 5),
            new Pawn(Piece::WHITE, 2, 6),
            new Pawn(Piece::WHITE, 2, 7),
            new Pawn(Piece::WHITE, 2, 8),
            new Rook(Piece::WHITE, 1, 1),
            new Rook(Piece::WHITE, 1, 8),
            new Bishop(Piece::WHITE, 1, 2),
            new Bishop(Piece::WHITE, 1, 7),
            new Queen(Piece::WHITE, 1, 4),
            new King(Piece::WHITE, 1, 5),
            new Knight(Piece::WHITE, 1, 3),
            new Knight(Piece::WHITE, 1, 6),
        ];
    }
}