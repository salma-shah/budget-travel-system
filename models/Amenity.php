<?php
require_once __DIR__ . '/../Connection.php';

class Amenity 
{
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    // viewing all stays
    public function viewAllAmenities()
    {
        $this->pdo->query('SELECT * FROM amenity');  
        $results = $this->pdo->resultSet();
        return $results;
    }
}