<?php
require_once '../db/connect.php';
require_once '../controller/BookController.php';

$BookController = new BookController($conn);

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

   $books = $BookController->getNewBooks();
   echo json_encode($books);
}