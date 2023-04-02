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
            new Pawn(Piece::WHITE, 7, 1),
            new Pawn(Piece::WHITE, 7, 2),
            new Pawn(Piece::WHITE, 7, 3),
            new Pawn(Piece::WHITE, 7, 4),
            new Pawn(Piece::WHITE, 7, 5),
            new Pawn(Piece::WHITE, 7, 6),
            new Pawn(Piece::WHITE, 7, 7),
            new Pawn(Piece::WHITE, 7, 8),
            new Rook(Piece::WHITE, 8, 1),
            new Rook(Piece::WHITE, 8, 8),
            new Bishop(Piece::WHITE, 8, 2),
            new Bishop(Piece::WHITE, 8, 7),
            new Queen(Piece::WHITE, 8, 4),
            new King(Piece::WHITE, 8, 5),
            new Knight(Piece::WHITE, 8, 3),
            new Knight(Piece::WHITE, 8, 6),
        ];
    }
}