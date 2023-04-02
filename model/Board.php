<?php

class Board
{
    public const DIMENSION = 8;

    /**
     * @var array<int, array<int, ?Piece>> &$board
     */
    private array $board;

    private BlackPlayer $blackPlayer;

    private WhitePlayer $whitePlayer;

    private ?Player $currentPlayer;

    /**
     * @var array<int, string>
     */
    private array $historic;

    public static function init(): self
    {
        $blackPlayer = new BlackPlayer();

        $whitePlayer = new WhitePlayer();

        $pieces = array_merge($blackPlayer->getInitialPieces(), $whitePlayer->getInitialPieces());

        $board = new Board($pieces);

        $board->blackPlayer = $blackPlayer;

        $board->whitePlayer = $whitePlayer;

        $board->currentPlayer = $board->whitePlayer;

        $board->historic = [];

        return $board;
    }

    public function __construct(array &$pieces)
    {
        $this->board = [];
        for ($x=1; $x <= self::DIMENSION; $x++) {
            $this->board[$x] = [];
            for ($y=1; $y <= self::DIMENSION; $y++) {
                $this->board[$x][$y] = null;
            }
        }

        foreach ($pieces as &$piece) {
            $this->board[$piece->xPosition][$piece->yPosition] = &$piece;
        }
    }

    /**
     * @return array<int, array<int, ?Piece>> &$board
     */
    public function getBoard(): array
    {
        return $this->board;
    }

    /**
     * @return array<int, string>
     */
    public function getHistoric(): array
    {
        return $this->historic;
    }

    public function getCurrentPlayer(): ?Player
    {
        return $this->currentPlayer;
    }

    public function getBlackPlayer(): Player
    {
        return $this->blackPlayer;
    }


    public function getWhitePlayer(): Player
    {
        return $this->whitePlayer;
    }


    public function move(int $fromX, int $fromY, int $toX, int $toY): void
    {
        if ($this->currentPlayer === null) {
            throw new \Exception('La partie est terminée.');
        }

        if ($fromX < 1 || $fromX > self::DIMENSION || $fromY < 1 || $fromY > self::DIMENSION) {
            throw new \Exception('Case de départ invalide.');
        }

        if ($toX < 1 || $toX > Board::DIMENSION || $toY < 1 || $toY > Board::DIMENSION) {
            throw new \Exception('Case d\'arrivée invalide.');
        }

        $piece = $this->board[$fromX][$fromY];

        if ($piece === null) {
            throw new \Exception('Il n\'y a pas de pièce sur la case ' . $this->getPrintableCoordinate($fromX, $fromY) . '.');
        }

        if ($piece->color !== $this->currentPlayer->getColor()) {
            throw new \Exception('Ce n\'est pas au joueur ' . (($piece->color === Piece::WHITE) ? 'blanc' : 'noir') . ' de jouer.');
        }

        if ($piece->canMove($toX, $toY, $this)) {
            if ($piece instanceof King && $piece->canCastle($toX, $toY, $this)) {
                $this->doCastle($piece, $toX, $toY);

                $this->currentPlayer = ($this->currentPlayer->getColor() === Piece::WHITE) ? $this->blackPlayer : $this->whitePlayer;
    
                $this->historic[] = $piece->char . ' roqué de ' . $this->getPrintableCoordinate($fromX, $fromY) . ' à ' . $this->getPrintableCoordinate($toX, $toY) . '.';
            } else {
                $this->board[$fromX][$fromY] = null;

                $this->takePiece($this->board[$toX][$toY]);
    
                $piece->xPosition = $toX;
                $piece->yPosition = $toY;
    
                $this->board[$toX][$toY] = $piece;
                $piece->moved = true;
    
                $this->currentPlayer = ($this->currentPlayer->getColor() === Piece::WHITE) ? $this->blackPlayer : $this->whitePlayer;
    
                $this->historic[] = $piece->char . ' déplacé de ' . $this->getPrintableCoordinate($fromX, $fromY) . ' à ' . $this->getPrintableCoordinate($toX, $toY) . '.';
            }
            
            $this->checkVictory();
        } else {
            throw new \Exception('Impossible de bouger la pièce de la case ' . $this->getPrintableCoordinate($fromX, $fromY) 
            . ' à la case ' . $this->getPrintableCoordinate($toX, $toY) . '.');
        }
    }

    /**
     * @return array<int, array<int, bool>
     */
    public function movePreview(int $fromX, int $fromY): array
    {
        if ($fromX < 1 || $fromX > self::DIMENSION || $fromY < 1 || $fromY > self::DIMENSION) {
            throw new \Exception('Case de départ invalide.');
        }

        $piece = $this->board[$fromX][$fromY];

        if ($piece === null) {
            throw new \Exception('Il n\'y a pas de pièce sur la case ' . $this->getPrintableCoordinate($fromX, $fromY) . '.');
        }

        return $piece->movePreview($this);
    }

    private function takePiece(?Piece $piece): void
    {
        if ($piece === null) {
            return;
        }

        if ($piece->color !== $this->currentPlayer->getColor()) {
            if ($this->currentPlayer->getColor() === Piece::WHITE) {
                $this->blackPlayer->subPoints($piece->value);
            } else if ($this->currentPlayer->getColor() === Piece::BLACK) {
                $this->whitePlayer->subPoints($piece->value);
            }
            $this->currentPlayer->addPieceToGraveyard($piece);

            $this->historic[] = $piece->char . ' en ' . $this->getPrintableCoordinate($piece->xPosition, $piece->yPosition) . ' a été capturé.';
        }
    }

    private function getPrintableCoordinate(int $x, int $y): string
    {
        return str_replace(
                ['1', '2', '3', '4', '5', '6', '7', '8'], 
                ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'], 
                (string) $y
            ) . (string) $x;
    }

    private function checkVictory(): void
    {
        foreach ($this->whitePlayer->getGraveyard() as $piece) {
            if ($piece instanceof King) {
                $this->historic[] = 'Le joueur blanc a gagné !';
                $this->currentPlayer = null;
                return;
            }
        }

        foreach ($this->blackPlayer->getGraveyard() as $piece) {
            if ($piece instanceof King) {
                $this->historic[] = 'Le joueur noir a gagné !';
                $this->currentPlayer = null;
                return;
            }
        }
    }

    private function doCastle(King $king, int $toX, int $toY): void
    {
        if ($king->color === Piece::WHITE && $king->moved === false && $king->xPosition === 1 && $king->yPosition === 5) {
            if ($toX === 1 && $toY === 7 && $this->board[1][6] === null
            && $this->board[1][7] === null && $this->board[1][8] instanceof Rook
            && $this->board[1][8]->color === Piece::WHITE && $this->board[1][8]->moved === false) {
                $rook = $this->board[1][8];
                $king->xPosition = 1;
                $king->yPosition = 7;
                $rook->xPosition = 1;
                $rook->yPosition = 6;
    
                $this->board[1][7] = $king;
                $this->board[1][6] = $rook;
                $this->board[1][5] = null;
                $this->board[1][8] = null;

                $king->moved = true;
                $this->board[1][6]->moved = true;
            }

            if ($toX === 1 && $toY === 3 && $this->board[1][4] === null
            && $this->board[1][3] === null && $this->board[1][2] === null 
            && $this->board[1][1] instanceof Rook && $this->board[1][1]->color === Piece::WHITE
            && $this->board[1][1]->moved === false) {
                $rook = $this->board[1][1];
                $king->xPosition = 1;
                $king->yPosition = 3;
                $rook->xPosition = 1;
                $rook->yPosition = 4;
    
                $this->board[1][3] = $king;
                $this->board[1][4] = $rook;
                $this->board[1][5] = null;
                $this->board[1][1] = null;

                $king->moved = true;
                $this->board[1][4]->moved = true;
            }
        }

        if ($king->color === Piece::BLACK && $king->moved === false && $king->xPosition === 8 && $king->yPosition === 5) {
            if ($toX === 8 && $toY === 7 && $this->board[8][6] === null
            && $this->board[8][7] === null && $this->board[8][8] instanceof Rook
            && $this->board[8][8]->color === Piece::BLACK && $this->board[8][8]->moved === false) {
                $rook = $this->board[8][8];
                $king->xPosition = 8;
                $king->yPosition = 7;
                $rook->xPosition = 8;
                $rook->yPosition = 6;
    
                $this->board[8][7] = $king;
                $this->board[8][6] = $rook;
                $this->board[8][5] = null;
                $this->board[8][8] = null;

                $king->moved = true;
                $this->board[8][6]->moved = true;
            }

            if ($toX === 8 && $toY === 3 && $this->board[8][4] === null
            && $this->board[8][3] === null && $this->board[8][2] === null 
            && $this->board[8][1] instanceof Rook && $this->board[8][1]->color === Piece::BLACK
            && $this->board[8][1]->moved === false) {
                $rook = $this->board[8][1];
                $king->xPosition = 8;
                $king->yPosition = 3;
                $rook->xPosition = 8;
                $rook->yPosition = 4;
    
                $this->board[8][3] = $king;
                $this->board[8][4] = $rook;
                $this->board[8][5] = null;
                $this->board[8][1] = null;

                $king->moved = true;
                $this->board[8][4]->moved = true;
            }
        }
    }
}