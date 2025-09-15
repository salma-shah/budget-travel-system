<?php
require_once '../models/DietaryRestriction.php';
require_once __DIR__ . '/../helpers/session_helper.php';

class DietaryRestrictionController 
{
    private $dietRestrictModel;
    public function __construct(){
        $this->dietRestrictModel = new DietaryRestriction;
    }

    public function viewAllDietaryRestrictions(){
       return $this->dietRestrictModel->viewAllDietaryRestrictions();
       // $destinations = $this->destinationModel->viewAllDestinations();
        // require_once '../views/welome.php';
    }
}

$init = new DietaryRestrictionController;
$init->viewAllDietaryRestrictions();