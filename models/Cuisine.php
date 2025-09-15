<?php
require_once __DIR__ . '/../Connection.php';

class Cuisine 
{
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    // viewing all stays
    public function viewAllCuisines()
    {
        $this->pdo->query('SELECT * FROM cuisine');  // adjust it accordingly
        $results = $this->pdo->resultSet();
        return $results;
    }
}