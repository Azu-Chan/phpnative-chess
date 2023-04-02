<?php

require '../config/autoload.php';

session_start();

$initController = new class {
    public function get()
    {
        try {
            if (! isset($_GET['fromX']) || ! filter_input(INPUT_GET, 'fromX', FILTER_VALIDATE_INT) || (int) $_GET['fromX'] < 1 || (int) $_GET['fromX'] > Board::DIMENSION
            || ! isset($_GET['fromY']) || ! filter_input(INPUT_GET, 'fromY', FILTER_VALIDATE_INT) || (int) $_GET['fromY'] < 1 || (int) $_GET['fromY'] > Board::DIMENSION) {
                throw new \Exception('Case invalide.');
            }

            echo json_encode(unserialize($_SESSION['board'])->movePreview((int) $_GET['fromX'], (int) $_GET['fromY']));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
};

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $initController->get();
}