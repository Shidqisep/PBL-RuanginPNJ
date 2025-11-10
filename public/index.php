<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // Path ke root
$dotenv->load(); // Load .env
require_once '../app/init.php';

$app = new App();