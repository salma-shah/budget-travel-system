<?php

require_once __DIR__ . '/../helpers/session_helper.php';

class FoodTypeController 
{
    private $foodTypeModel;
    public function __construct(){
        $this->foodTypeModel = new FoodType;
    }

    public function viewAllFoodTypes(){
       $foodTypes= $this->foodTypeModel->viewAllFoodTypes();
        // require_once '../views/welome.php';
    }
}