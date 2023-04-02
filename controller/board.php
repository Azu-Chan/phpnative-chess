<?php

require '../config/autoload.php';

session_start();

$boardController = new class {
    public function get()
    {
        echo json_encode(unserialize($_SESSION['board'])->getBoard());
    }
};

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $boardController->get();
}