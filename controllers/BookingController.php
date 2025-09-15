<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
include_once __DIR__ . '/../helpers/session_helper.php';

class BookingController 
{
  private $bookingModel;
  
     private $tourModel;
    public function __construct(){
        $this->bookingModel = new Booking;
        $this->tourModel = new Tour;
    }

    
public function makeBooking()  
{
    $stayId = filter_var($_POST['stayId'], FILTER_SANITIZE_NUMBER_INT);

    if (!isset($_SESSION['userId']))
    {
        flash('booking', 'You need to login to make a booking. Please create an account, or login into your account.', 'form-message form-message-red');
        redirect ('/tripzly_test/stay/' . $stayId);
         return;  // so now, if user isnt logged in, they cant make a booking
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            // sanitization data
            $roomIds = is_array($_POST['roomIds']) ? $_POST['roomIds'] : explode(',', $_POST['roomIds']);
            $bookableType = filter_var(trim($_POST['bookableType']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $numOfAdults = filter_var(trim($_POST['guestsAdults']), FILTER_SANITIZE_NUMBER_INT);
            $numOfChildren = filter_var(trim($_POST['guestsChildren']), FILTER_SANITIZE_NUMBER_INT);
            $bookingStart = trim($_POST['checkin']);
            $bookingEnd = trim($_POST['checkout']);
            $totalPrice = $_POST['totalPrice'];

            // validation
            $bookingDate = new DateTime();
            $startDate = new DateTime($bookingStart);
            $endDate = new DateTime($bookingEnd);

            if ($startDate < $bookingDate) {
                throw new Exception("Booking start date cannot be in the past.");
            }
            if ($endDate <= $startDate) {
                throw new Exception("Booking end date must be after the start date.");
            }

            // loop through rooms and make booking if rooms are avialable
            $roomCount = count($roomIds);
            $pricePerRoom = $totalPrice / $roomCount;
            $successCount = 0;

            foreach ($roomIds as $roomId) {
                $roomId = filter_var(trim($roomId), FILTER_SANITIZE_NUMBER_INT);

                $isAvailable = $this->bookingModel->isAvailable($roomId, $startDate->format('Y-m-d'), $endDate->format('Y-m-d'));
                if (!$isAvailable) {
                    continue;
                }

                $data = [
                    'user_id' => $_SESSION['userId'],
                    'bookable_id' => $roomId,
                    'bookable_type' => 'room',
                    'num_of_adults' => $numOfAdults,
                    'num_of_children' => $numOfChildren,
                    'total_cost' => $pricePerRoom,
                    'booking_start' => $startDate->format('Y-m-d'),
                    'booking_end' => $endDate->format('Y-m-d'),
                    'status' => 'pending'
                ];

                if ($this->bookingModel->makeBooking($data)) {
                    $successCount++;
                }
            }

            if ($successCount > 0) {
               flash('booking', "Booking was made successfully for $successCount room(s)! You will receive an email with your booking details soon!", 'form-message form-message-green');
               redirect('/tripzly_test/stay/' . $stayId);
            } else {
                flash('booking', 'There was an error. Please try again.', 'form-message form-message-red');
            }
        } catch (Exception $ex) {
            echo "There was an error: " . $ex->getMessage();
        }
    }
}

public function makeTourBooking()  
{
    $tourId = filter_var($_POST['tourId'], FILTER_SANITIZE_NUMBER_INT);

    if (!isset($_SESSION['userId']))
    {
        flash('booking', 'You need to login to make a booking. Please create an account, or login into your account.', 'form-message form-message-red');
        redirect ('/tripzly_test/tour/' . $tourId);
        return;  // so now, if user isnt logged in, they cant make a booking
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            

            // sanitization data
            $bookableType = filter_var(trim($_POST['bookableType']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $numOfAdults = filter_var(trim($_POST['numAdults']), FILTER_SANITIZE_NUMBER_INT);
            $dateTour = trim($_POST['date']);
            $totalPrice = $_POST['totalPrice'];

            // validation
            $bookingDate = new DateTime();
            $date = new DateTime($dateTour);
            
            $isAvailable = $this->bookingModel->isAvailable($tourId, $date->format('Y-m-d'), $date->format('Y-m-d'));
                if ($isAvailable) {               

                    // ifroom is available , we intiialize the data array
                $data = [
                    'user_id' => $_SESSION['userId'],
                    'bookable_id' => $tourId,
                    'bookable_type' => 'tour',
                    'num_of_adults' => $numOfAdults,
                    'num_of_children' => 0,
                    'total_cost' => $totalPrice,
                    'booking_start' => $date->format('Y-m-d'),
                    'booking_end' => $date->format('Y-m-d'),
                    'status' => 'Pending'
                ];

                if ($this->bookingModel->makeBooking($data)) {
                    flash('booking', "Booking was made successfully for the tour! You will receive an email with your booking details soon!", 'form-message form-message-green');
                    redirect('/tripzly_test/tour/' . $tourId);
                }
                else 
                {
                flash('booking', 'There was an error. Please try again.');
                 }
            }
        } catch (Exception $ex) {
            echo "There was an error: " . $ex->getMessage();
        }
    }
}



// getting bookings for particular booking
public function viewBookingsForBusiness()
{
    // user should be logged in and a business
    if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'Business') {
        redirect ('/tripzly_test/home');
    }

    // business' id is logged in user's id from session 
    // we return the bookings to be displayed
    $businessId = $_SESSION['userId'];
    $bookings= $this->bookingModel->getBookingsForBusiness($businessId);
    require_once __DIR__ . '/../views/manage_bookings.php';
}

// business approves and confirms booking then sends email to user and business
public function approveBooking($bookingId)
{
    if (($_SERVER['REQUEST_METHOD'] == 'POST'))
  {
    try 
    {
        // first we validate bookingId
        $bookingId = filter_var($bookingId, FILTER_SANITIZE_NUMBER_INT);
        if (!$bookingId || $bookingId <= 0) 
        {
            throw new Exception("The booking ID is invalid.");
        }

        // if valid id, we can approve makeBooking
        if ($this->bookingModel->approveBooking($bookingId))
        { 
            // get the booking details through booking id
            $booking = $this->bookingModel->getBookingById($bookingId);
            if (!$booking) { throw new Exception("Booking details could not be found."); }

            // now we set up sending email to user, by getting user's abd business' email first through PHPMailer 
            $user = $this->bookingModel->getUserEmailByBookingId($bookingId);
            $business = $this->bookingModel->getBusinessEmailByBookingId($bookingId);

            if ($user && isset($user->email) && $business && isset($business->email)) 
        {
            $mail = new PHPMailer(true);

            // mail settings
            try 
            {
                // server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Port = 587;
                $mail->Username = // put your email here;
                $mail->Password = // put the app password which was generated here
                $mail->SMTPSecure = 'tls';

                // recipitents
                 $mail->setFrom($business->email, 'Tripzly Bookings');
                 $mail->addAddress($user->email);

                // content of the email
                $mail->isHTML(true);
                $mail->Subject = "Your booking has been confirmed!";
                $mail->Body = "
                <h3>Your booking is confirmed!</h3>
                <p>Your booking details:</p>
                <p>Booking ID: <strong>{$booking->booking_id}</strong></p>
                <p>Start Date: {$booking->booking_start}</p>
                <p>End Date: {$booking->booking_end}</p>
                <p>Total Cost: Rs. {$booking->total_cost}</p>

                <p>Please have a screenshot of these details for future references.</p>
                <p>Thank you for booking with us!</p>";
                $mail->send();

                // now we will send to the business by resetting PHP Mailer

                $mail->clearAllRecipients();
                $mail->setFrom('dummyemail@gmail.com');
                $mail->addAddress($business->email);
                $mail->Subject = "New booking accepted and confirmed!";
                $mail->Body = "
                <h3>You have received a new booking</h3>
                <p>Details are as follows: </p>
                <p>Booking ID: <strong>{$booking->booking_id}</strong></p>
                <p>Booked by: {$user->email}</p>
                <p>Start Date: {$booking->booking_start}</p>
                <p>End Date: {$booking->booking_end}</p>
                <p>Total Cost: Rs. {$booking->total_cost}</p>
                <p>Please review the booking in your dashboard.</p>";
                $mail->send(); // email send
                
            }
            catch (Exception $ex)
            {  echo "There was an error: " . $ex->getMessage(); }
             flash('booking', 'Booking is approved and booking confirmation details has been sent to your email!', 'form-message form-message-green');
        } 

        else { flash('booking_approval', 'Failed to approve booking.', 'form-message form-message-red');}
    }
    }

    catch (Exception $ex)
    {
        echo "There was an error in approving the booking: " . $ex->getMessage();
    }
}

}


// business rejects and declines booking then sends email to user and business
public function rejectBooking($bookingId)
{
    if (($_SERVER['REQUEST_METHOD'] == 'POST'))
  {
    try 
    {
        // first we validate bookingId
        $bookingId = filter_var($bookingId, FILTER_SANITIZE_NUMBER_INT);
        if (!$bookingId || $bookingId <= 0) 
        {
            throw new Exception("The booking ID is invalid.");
        }

        // if valid id, we can approve makeBooking
        if ($this->bookingModel->rejectBooking($bookingId))
        { 
            // get the booking details through booking id
            $booking = $this->bookingModel->getBookingById($bookingId);
            if (!$booking) { throw new Exception("Booking details could not be found."); }

            // now we set up sending email to user, by getting user's abd business' email first through PHPMailer 
            $user = $this->bookingModel->getUserEmailByBookingId($bookingId);
            $business = $this->bookingModel->getBusinessEmailByBookingId($bookingId);

            if ($user && isset($user->email) && $business && isset($business->email)) 
        {
            $mail = new PHPMailer(true);

            // mail settings
            try 
            {
                // server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Port = 587;
                $mail->Username = // put your email here;
                $mail->Password = // put your password generated here;
                $mail->SMTPSecure = 'tls';

                // recipitents
                 $mail->setFrom($business->email);
                 $mail->addAddress($user->email);

                // content of the email
                $mail->isHTML(true);
                $mail->Subject = "Your booking has been rejected!";
                $mail->Body = "
                <h3>Your booking is rejected!</h3>
                <p>Your booking details:</p>
                <p>Booking ID: <strong>{$booking->booking_id}</strong></p>
                <p>Start Date: {$booking->booking_start}</p>
                <p>End Date: {$booking->booking_end}</p>
                <p>We're sorry, but your booking request was not approved.</p>
                <p>Please contact the business for more details.</p>
                <p>Thank you for using our service.</p>";
                $mail->send();

                // now we will send to the business by resetting PHP Mailer
                $mail->clearAllRecipients();
                $mail->setFrom('dummyemail@gmail.com'); 
                $mail->addAddress($business->email);
                $mail->Subject = "A booking request was just rejected!";
                $mail->Body = "
                <h3>You have declined a new booking</h3>
                <p>The following booking has been rejected:</p>
                <p>Booking ID: <strong>{$booking->booking_id}</strong></p>
                <p>Booked by: {$user->email}</p>
                <p>Start Date: {$booking->booking_start}</p>
                <p>End Date: {$booking->booking_end}</p>
                <p>Total Cost: Rs. {$booking->total_cost}</p>
                <p>Please review the details of the booking in your dashboard.</p>";
                $mail->send(); // email send
                
            }
            catch (Exception $ex)
            {  echo "There was an error: " . $ex->getMessage(); }
             flash('booking', 'Booking is rejected and email has been sent to you!', 'form-message form-message-green');
        } 

        else { flash('booking_rejected', 'Failed to decline booking.', 'form-message form-message-red');}
    }
    }

    catch (Exception $ex)
    {
        echo "There was an error in rejecting the booking: " . $ex->getMessage();
    }
}
}

// viewing one booking's details
public function viewBookingDetails($bookingId)
   {
     
    // mkaing sure we have a booking id
     $bookingId = $_POST['bookingID'] ?? null;

    if (!$bookingId) {
        echo json_encode(['error' => 'Booking ID not provided.']);
        return;
    }

    // getting the booking then passing to frontend jscript
    $booking = $this->bookingModel->viewBookingDetails($bookingId);
   if ($booking) 
    {
        echo json_encode($booking);
    } 
    else 
    {
        echo json_encode(['error' => 'Booking not found.']);
    }
   }


}
?>