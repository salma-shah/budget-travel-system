<?php
require_once __DIR__ . '/../Connection.php';

class DietaryRestriction 
{
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    // viewing all stays
    public function viewAllDietaryRestrictions()
    {
        $this->pdo->query('SELECT * FROM dietary_restriction');  // adjust it accordingly
        $results = $this->pdo->resultSet();
        return $results;
    }
}