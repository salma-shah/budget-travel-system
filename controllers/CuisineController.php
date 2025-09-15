<?php
require_once '../models/Cuisine.php';
require_once __DIR__ . '/../helpers/session_helper.php';

class CuisineController 
{
    private $cuisineModel;
    public function __construct(){
        $this->cuisineModel = new Cuisine;
    }

    public function viewAllCuisines(){
       return $this->cuisineModel->viewAllCuisines();
       // $destinations = $this->destinationModel->viewAllDestinations();
        // require_once '../views/welome.php';
    }
}

$init = new CuisineController;
$init->viewAllCuisines();