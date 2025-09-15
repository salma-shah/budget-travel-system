<?php
require_once '../models/Destination.php';
require_once __DIR__ . '/../helpers/session_helper.php';

class DestinationController 
{
    private $destinationModel;
    public function __construct(){
        $this->destinationModel = new Destination;
    }

    public function viewAllDestinations(){
       return $this->destinationModel->viewAllDestinations();
       // $destinations = $this->destinationModel->viewAllDestinations();
        // require_once '../views/welome.php';
    }

     public function showAllDestinationNames()
     {
       return $this->destinationModel->showAllDestinationNames();
     }
}
?>