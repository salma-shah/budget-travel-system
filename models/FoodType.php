<?php
require_once __DIR__ . '/../Connection.php';

class FoodType 
{
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    // viewing all types of food
    public function viewAllFoodTypes()
    {
        $this->pdo->query('SELECT * FROM food_type');  // adjust it accordingly
        $results = $this->pdo->resultSet();
        return $results;
    }
}