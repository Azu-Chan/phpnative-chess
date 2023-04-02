<?php

require '../config/autoload.php';

session_start();

$boardController = new class {
    public function get()
    {
        /** @var Board $board */
        $board = unserialize($_SESSION['board']);
        $infos = [];

        $infos['turn'] = $board->getCurrentPlayer()?->getColor();

        $infos['white_points'] = $board->getWhitePlayer()->getPoints();
        $infos['black_points'] = $board->getBlackPlayer()->getPoints();

        $infos['white_graveyard'] = $board->getWhitePlayer()->getGraveyard();
        $infos['black_graveyard'] = $board->getBlackPlayer()->getGraveyard();

        $infos['historic'] = $board->getHistoric();

        echo json_encode($infos);
    }
};

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $boardController->get();
}