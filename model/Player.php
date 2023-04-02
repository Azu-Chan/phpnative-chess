<?php

abstract class Player
{
    /**
     * @var Piece[]
     */
    private array $graveyard;

    private int $points;

    public function __construct()
    {
        $this->graveyard = [];
        $this->points = 39;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function subPoints(int $pointsToRemove): void
    {
        $this->points -= $pointsToRemove;
    }

    /**
     * @return Piece[]
     */
    public function getGraveyard(): array
    {
        return $this->graveyard;
    }

    public function addPieceToGraveyard(Piece $piece): void
    {
        $this->graveyard[] = $piece;
    }

    abstract public function getColor(): int;

    /**
     * @return Piece[] 
     */
    abstract public function getInitialPieces(): array;
}