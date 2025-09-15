<?php
require_once __DIR__ . '/../helpers/session_helper.php';

class TourController 
{
    private $tourModel;
    public function __construct(){
        $this->tourModel = new Tour;
    }

    public function showAllToursPage(){
       $tours= $this->tourModel->viewAllTours();
       require_once __DIR__ . '/../views/tours.php';
    }

    // specfifc tour
    public function showTourDetails($tourId)
    {
        $tour= $this->tourModel->viewTourDetails($tourId);
        if (!$tour) {die('Tour not found.');}
        require_once __DIR__ . '/../views/tour_details.php';
    }

    public function viewAllToursByDestination()
    {
        $destinationId = $_SESSION['destination_id'];
        $tours = $this->tourModel->viewAllToursByDestination($destinationId);
        return $tours;
    }

    public function addTour()
    {
         if (($_SERVER['REQUEST_METHOD'] == 'POST'))
         {
            try 
            {
           $destinationId = filter_var(trim($_POST['destinationId']), FILTER_SANITIZE_NUMBER_INT);
           $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $type = filter_var(trim($_POST['type']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $address = filter_var(trim($_POST['address']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $contacts = filter_var(trim($_POST['contacts']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $duration = filter_var(trim($_POST['duration']), FILTER_SANITIZE_NUMBER_INT);
           $avgRating = filter_var(trim($_POST['avgRating']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
           $pricePerAdult = filter_var(trim($_POST['pricePerAdult']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
           $pricePerChild = filter_var(trim($_POST['pricePerChild']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
           $freeCancellationRaw = trim($_POST['freeCancellation']); 
           $isAvailableRaw = trim($_POST['isAvailable']);

           // validating
           if (empty($name) || empty($address) || empty($contacts || empty($type))) {throw new Exception("All fields are required.");}
           if ( !is_numeric($destinationId) || $destinationId < 0) { throw new Exception("Invalid destination."); }
           if ( !is_numeric($pricePerAdult) || $pricePerAdult < 0) { throw new Exception("Invalid price per adult."); }
           if ( !is_numeric($pricePerChild) || $pricePerChild < 0) { throw new Exception("Invalid price per child."); }
           if ( !is_numeric($duration) || (int)$duration <0 ) { throw new Exception("Invalid duration."); }
           if ( !is_numeric($avgRating) || $avgRating < 0 || $avgRating > 5 ) { throw new Exception("Invalid rating."); }
           $freeCancellation = ($freeCancellationRaw === '1' || strtolower($freeCancellationRaw) === 'yes') ? 1 : 0;
           $isAvailable = ($isAvailableRaw === '1' || strtolower($isAvailableRaw) === 'yes') ? 1 : 0;

           // data array
           $data = [
            'destination_id' => $destinationId,
            'name' => $name,
            'type' => $type,
            'address' => $address,
            'contacts' => $contacts,
            'price_per_adult' => $pricePerAdult,
            'price_per_child' => $pricePerChild,
            'duration' => (int)$duration,
            'avg_rating' => $avgRating,
            'free_cancellation' => $freeCancellation,
            'is_available' => $isAvailable,
            'status' => 'pending'
           ];

           // calling the method from model
            if ($this->tourModel->addTour($data))
            {
                 flash('tour', 'Tour was submitted successfully! It is pending for admin approval now!', 'form-message form-message-green');
            }
            else {  flash('tour', 'Something went wrong. Please try again.');}

            }
            catch(Exception $ex) { echo "Error: " . $ex->getMessage(); }
         }
    }

    public function checkTourAvailability()
{
    $tourId = $_POST['tourId'];
    $date = $_POST['date'];
    $guests = $_POST['numAdults'];

    $isAvailable = $this->tourModel->isTourAvailaible($tourId, $date);
    if ($isAvailable)
    {
        // calculate total cost
        $tourDetails = $this->tourModel->getTourPricesForAdult($tourId);
        $totalPrice = $guests * $tourDetails->price_per_adult;
        
        echo json_encode([
            'available' => true,
            'totalPrice' => $totalPrice
        ]);
    } 
    else 
    {
        echo json_encode(['available' => false]);
    }
}


}


?>

