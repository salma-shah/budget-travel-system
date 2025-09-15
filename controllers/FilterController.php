<?php
require_once __DIR__ . '/../helpers/session_helper.php';

class FilterController 
{
 private $filterModel;
    public function __construct(){
        $this->filterModel = new Filter();
    }

      public function filterAvailableStays()
     {
      // getting the json data
        $data = json_decode(file_get_contents('php://input'), true);

        $budget = $data['budget'] ?? null;
        $amenities = $data['amenities'] ?? [];
        $checkin = $data['checkin'] ?? null;
        $checkout = $data['checkout'] ?? null;
        // validationg
         if (!$checkin || !$checkout) {
           echo json_encode([]);
           exit;
          }
          //  call model
           $stays = $this->filterModel->filterAvailableStays([
             'budget' => $budget,
             'amenities' => $amenities,
             'checkin' => $checkin,
             'checkout' => $checkout,
            ]);
            
            // return the stays to js
            echo json_encode($stays);

     }
   
}