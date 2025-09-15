<?php
require_once __DIR__ . '/../helpers/session_helper.php';

class HomeController 
{
    private $destinationModel;
    private $stayModel;
    private $searchModel;
    private $amenityModel;
    private $filterModel;
    public function __construct(){
        $this->destinationModel = new Destination();
        $this->stayModel = new Stay();
        $this->searchModel = new Search();
        $this->amenityModel = new Amenity();
        $this->filterModel = new Filter();
    }

     public function showHomePage()
     {
          $destinations= $this->destinationModel->viewAllDestinations();
          $stays= $this->stayModel->viewAllStays();
          $amenities = $this->amenityModel->viewAllAmenities();
          require_once __DIR__ . '/../views/home.php';
     }

     public function showAboutPage()
     {
         require_once __DIR__ . '/../views/about.php';
     }

     public function showContactPage()
     {
        require_once __DIR__ . '/../views/contact.php';
     }

     // this function will do all filtering
      public function filterAvailableStaysByDestination()
     {
      // getting the json data
        $data = json_decode(file_get_contents('php://input'), true);

        $destination = $data['destination'] ?? null;
        $budget = $data['budget'] ?? null;
        $amenities = $data['amenities'] ?? [];
        $checkin = $data['checkin'] ?? null;
        $checkout = $data['checkout'] ?? null;
        
        // validationg
         if (!$checkin || !$checkout || $destination) {
           echo json_encode([]);
           exit;
          }
          
          //  call model
           $stays = $this->filterModel->filterAvailableStaysByDestination([
            'destination' => $destination,
             'budget' => $budget,
             'amenities' => $amenities,
             'checkin' => $checkin,
             'checkout' => $checkout,
            ]);
            
            // return the stays to js
            echo json_encode($stays);

     }
   


}
?>