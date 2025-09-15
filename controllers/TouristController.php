<?php
require_once __DIR__ . '/../helpers/session_helper.php';

class TouristController {

  private $touristModel;
    public function __construct(){
        $this->touristModel = new TouristAttraction;
    }

    public function addAttraction()
    {
        if (($_SERVER['REQUEST_METHOD'] == 'POST'))
        {
             // lets sanitize the data
           $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $location = filter_var(trim($_POST['location']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $openHours = filter_var(trim($_POST['openHours']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $destinationId = filter_var(trim($_POST['destinationId']), FILTER_SANITIZE_NUMBER_INT);

        //  if (!filter_var($destination_id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) 
        //  {

        //  }

        // initialize
        $data = [
                'name' => $name,
                'location' => $location,
                'description' => $description,
                'open_hours' => $openHours,
                'destination_id' => $destinationId
        ];

        if (empty($data['name']) || empty($data['location']) || empty($data['description']) || empty($data['open_hours'])) 
    {
       flash('attraction', 'All fields are required.');
       redirect('../views/add_attraction.php');
       exit(); 
    }

    if ($this->touristModel->addAttraction($data)) {
            flash('attraction', 'The tourist attraction was added successfully!', 'form-message form-message-green');
        } else {
            flash('attraction', 'Something went wrong. Please try again.');
        }

        redirect('../views/contact.php');

        }
    }
    
    // all attractions
    public function showAllAttractionsPage(){
       $attractions= $this->touristModel->viewAllTouristAttractions();
       require_once __DIR__ . '/../views/attractions.php';
    }

    // specfic attraction details
    public function showAttractionDetails($attractionId)
    {
        $attraction= $this->touristModel->viewAttractionDetails($attractionId);
        if (!$attraction) {die('Attraction was not found.');}
        require_once __DIR__ . '/../views/attraction_details.php';
    }
    
     public function viewAllTouristAttractionsByDestintion($destinationId)
    {
         return $this->touristModel->viewAllTouristAttractions($destinationId);
    }

}
?>