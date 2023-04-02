<?php

require '../config/autoload.php';

session_start();

$initController = new class {
    public function post()
    {
        try {
            if (! isset($_POST['fromX']) || ! filter_input(INPUT_POST, 'fromX', FILTER_VALIDATE_INT) || (int) $_POST['fromX'] < 1 || (int) $_POST['fromX'] > Board::DIMENSION
            || ! isset($_POST['fromY']) || ! filter_input(INPUT_POST, 'fromY', FILTER_VALIDATE_INT) || (int) $_POST['fromY'] < 1 || (int) $_POST['fromY'] > Board::DIMENSION) {
                throw new \Exception('Case de départ invalide.');
            }

            if (! isset($_POST['toX']) || ! filter_input(INPUT_POST, 'toX', FILTER_VALIDATE_INT) || (int) $_POST['toX'] < 1 || (int) $_POST['toX'] > Board::DIMENSION
            || ! isset($_POST['toY']) || ! filter_input(INPUT_POST, 'toY', FILTER_VALIDATE_INT) || (int) $_POST['toY'] < 1 || (int) $_POST['toY'] > Board::DIMENSION) {
                throw new \Exception('Case d\'arrivée invalide.');
            }

            $board = unserialize($_SESSION['board']);

            $board->move((int) $_POST['fromX'], (int) $_POST['fromY'], (int) $_POST['toX'], (int) $_POST['toY']);
            
            $_SESSION['board'] = serialize($board);

            echo 'OK';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $initController->post();
}