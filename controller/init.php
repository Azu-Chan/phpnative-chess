<?php

require '../config/autoload.php';

session_start();

$initController = new class {
    public function post()
    {
        unset($_SESSION['board']);

        $board = Board::init();

        $_SESSION['board'] = serialize($board);

        echo 'OK';
    }
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $initController->post();
}