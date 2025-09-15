<?php

require_once __DIR__ . '/../helpers/session_helper.php';

class AmenityController 
{
    private $amenityModel;
    public function __construct(){
        $this->amenityModel = new Amenity;
    }

 
}

