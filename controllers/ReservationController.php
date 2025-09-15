<?php
require_once __DIR__ . '/../helpers/session_helper.php';

class ReservationController {
  private $reservationModel;
  private $restaurantModel;
    
  public function __construct(){
        $this->reservationModel = new Reservation;
        $this->restaurantModel = new Restaurant;
    }
    
      // making a reservation
    public function makeReservation()  
    {
        $restaurantId = filter_var(trim($_POST['restaurantId']), FILTER_SANITIZE_NUMBER_INT);

        if (!isset($_SESSION['userId']))
    {
        flash('reservation', 'You need to login to make a reservation. Please create an account, or login into your account.', 'form-message form-message-red');
        redirect ('/tripzly_test/restaurant/' . $restaurantId);
         return;  // so now, if user isnt logged in, they cant make a booking
    }

    if (($_SERVER['REQUEST_METHOD'] == 'POST'))
    {
        try 
        {
            // sanitzation
         $numberOfGuests = filter_var(trim($_POST['guests']), FILTER_SANITIZE_NUMBER_INT);
         $date = preg_replace("([^0-9/])", "", $_POST['date']);
         $userId = $_SESSION['userId'];
         $rawTime = $_POST['time'] ?? '';

         // validation
         $validatedTime = DateTime::createFromFormat('H:i', $rawTime);
         if ($validatedTime && $validatedTime->format('H:i') === $rawTime) {
             $sanitizedTime = $validatedTime->format('H:i'); } 
             else {
                echo json_encode(['available' => false, 'message' => 'Invalid time format.']);
                exit;
            }

         if (!$restaurantId || !$date || !$numberOfGuests)
         {
             throw new Exception("Please select a valid restaurant and date and number of guests.");
         }

         // format date
         $reservationDate = new DateTime($date);
         $today = new DateTime();
         if ($reservationDate < $today)
         {
            throw new Exception("The date of reservation cannot be in the past.");
         }

         // now we combine the date and time into one string
         $dateTimeString = $reservationDate->format('Y-m-d') . ' ' . $sanitizedTime . ':00';

            // initalize data
            $data = [
               'restaurant_id' => $restaurantId,
                'user_id' => $userId,
                'date' => $dateTimeString,
                'number_guests' => $numberOfGuests,
                'status' => 'pending'
            ];

            var_dump($data);

            // calling the method and make reservation
             if ($this->reservationModel->makeReservation($data)) {
             flash('reservation', 'Reservation was made successfully! You will be notified once it is confirmed!', 'form-message form-message-green');
             redirect('/tripzly_test/restaurant/' . $restaurantId);

        } else {  flash('reservation', 'There was an error. Please try again.');}
        }
        catch (Exception $ex)
        {
              echo "There was an error: " . $ex->getMessage();
        }
    }
}

}


?>