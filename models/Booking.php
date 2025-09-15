<?php
require_once __DIR__ . '/../Connection.php';

class Booking 
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = new Connection;
    }

    // checking if booking is available 
    public function isAvailable($bookableId, $startDate, $endDate)
    {
        // we take the bookings which are CONFIRMED and check the dates for the specific item
        $this->pdo->query('SELECT * FROM booking WHERE bookable_id = :bookable_id AND status = "Confirmed"
        AND (booking_start <= :end_date AND booking_end >= :start_date)');

         $this -> pdo -> bind(':bookable_id', $bookableId);
         $this -> pdo -> bind(':start_date', $startDate);
         $this -> pdo -> bind(':end_date', $endDate);

         // if any bookings already found
         $result = $this -> pdo ->resultSet();
         return empty($result);  
    }

    // making the booking so business can accept or reject
    public function makeBooking($data)
    {
        // inserting data into db
        $this->pdo->query('INSERT INTO booking (user_id,bookable_id,bookable_type,num_of_adults,num_of_children,total_cost,booking_start,booking_end,status)
        VALUES (:user_id,:bookable_id,:bookable_type,:num_of_adults,:num_of_children,:total_cost,:booking_start,:booking_end,:status)');

       // binding values
    $this->pdo->bind(':user_id', $data['user_id']);
    $this->pdo->bind(':bookable_id', $data['bookable_id']);
    $this->pdo->bind(':bookable_type', $data['bookable_type']);
    $this->pdo->bind(':num_of_adults', $data['num_of_adults']);
    $this->pdo->bind(':num_of_children', $data['num_of_children']);
    $this->pdo->bind(':total_cost', $data['total_cost']);
    $this->pdo->bind(':booking_start', $data['booking_start']);
    $this->pdo->bind(':booking_end', $data['booking_end']);
    $this->pdo->bind(':status', $data['status']);

    // executing
         if ( $this -> pdo -> execute())
         { return true;}
         else { return false;}
    }

    // business approves booking
    public function approveBooking($bookingId)
    {
    $this->pdo->query('UPDATE booking SET status = :status WHERE booking_id = :booking_id');
    $this->pdo->bind(':status', 'Confirmed');
    $this->pdo->bind(':booking_id', $bookingId);
    return $this->pdo->execute();
    }

      // business rejects booking
    public function rejectBooking($bookingId)
    {
    $this->pdo->query('UPDATE booking SET status = :status WHERE booking_id = :booking_id');
    $this->pdo->bind(':status', 'Rejected');
    $this->pdo->bind(':booking_id', $bookingId);
    return $this->pdo->execute();
    }

    // get a booking by its Id
    public function getBookingById($bookingId)
    {
    $this->pdo->query("SELECT * FROM booking WHERE booking_id = :booking_id");
    $this->pdo->bind(':booking_id', $bookingId);
    return $this->pdo->single();  
    }

   // get user's email through their booking ID by using JOIN 
    public function getUserEmailByBookingId($bookingId) {
    $this->pdo->query('SELECT u.email FROM booking b JOIN user u ON b.user_id = u.user_id WHERE b.booking_id = :booking_id');
    $this->pdo->bind(':booking_id', $bookingId);
    return $this->pdo->single();  }
    
    public function getBookingsForBusiness($businessId) {
    $this->pdo->query("
        SELECT b.*, 
               u.user_id AS customer_id,
               u.name AS customer_name, 
               u.email AS customer_email,
               l.listable_type,
               CASE 
                   WHEN l.listable_type = 'stay' THEN s.name
                   WHEN l.listable_type = 'tour' THEN t.name
                   WHEN l.listable_type = 'restaurant' THEN r.name
                   ELSE 'Unknown'
               END AS service,
               rt.type AS room_type
        FROM booking b
        JOIN user u ON b.user_id = u.user_id
        LEFT JOIN room rt ON b.bookable_id = rt.room_id AND b.bookable_type = 'room'
        LEFT JOIN stay s ON rt.stay_id = s.stay_id
        LEFT JOIN listings l ON (
            (b.bookable_type = 'room' AND l.listable_type = 'stay' AND l.listable_id = s.stay_id)
            OR
            (b.bookable_type = 'tour' AND l.listable_type = 'tour' AND b.bookable_id = l.listable_id)
            OR
            (b.bookable_type = 'restaurant' AND l.listable_type = 'restaurant' AND b.bookable_id = l.listable_id)
        )
        LEFT JOIN tour t ON b.bookable_type = 'tour' AND b.bookable_id = t.tour_id
        LEFT JOIN restaurant r ON b.bookable_type = 'restaurant' AND b.bookable_id = r.restaurant_id
        WHERE l.business_id = :businessId
        ORDER BY b.booking_start DESC
    ");
    
    $this->pdo->bind(':businessId', $businessId);
    return $this->pdo->resultSet();
}

   // get business' email through booking ID by using JOIN 
public function getBusinessEmailByBookingId($bookingId) {
    $this->pdo->query("
        SELECT u.email, u.name
        FROM booking b
        JOIN room r ON b.bookable_id = r.room_id AND b.bookable_type = 'room'
        JOIN stay s ON r.stay_id = s.stay_id
        JOIN listings l ON l.listable_id = s.stay_id AND l.listable_type = 'stay'
        JOIN user u ON l.business_id = u.user_id
        WHERE b.booking_id = :booking_id
    ");
    $this->pdo->bind(':booking_id', $bookingId);
    return $this->pdo->single();
}


// view one booking's details
   public function viewBookingDetails($bookingId)
   {
    $this->pdo->query('
    SELECT b.*, u.name AS customer_name, u.email AS customer_email 
    FROM booking b
    JOIN user u ON b.user_id = u.user_id
    WHERE b.booking_id = :id');
    $this->pdo->bind(':id', $bookingId);
    $booking = $this->pdo->single();


    if (!$booking) return null;

     $type = $booking->bookable_type;
     $bookableId = $booking->bookable_id;
    // now that we know what type and id it is, we can get its details

     if ($type === 'stay') 
    {
        $this->pdo->query("SELECT * FROM stay WHERE stay_id = :id");
    } 
    elseif ($type === 'tour') 
    {
        $this->pdo->query("SELECT * FROM tour WHERE tour_id = :id");
    } 
    elseif ($type === 'restaurant') 
    {
        $this->pdo->query("SELECT * FROM restaurant WHERE restaurant_id = :id");
    } 
    elseif ($type == 'room')
    {
                $this->pdo->query("
                    SELECT s.*, r.type AS room_type 
                    FROM room r
                    JOIN stay s ON s.stay_id = r.stay_id
                    WHERE r.room_id = :id
                ");
    }
    else {
        return $booking; 
    }
    
    // binding
    $this->pdo->bind(':id', $bookableId);
    $details= $this->pdo->single();
    $booking->details = $details;

    return $booking;  
   }


   // get bookings for a user with diff status
   public function getBookingsByStatusForUser($userId)
   {
    $this->pdo->query('SELECT status, COUNT(*) AS bookingCount FROM booking  WHERE user_id = :user_id GROUP BY status');
    $this->pdo->bind(':user_id', $userId);
    $results= $this->pdo->resultSet();

    // convert the resuts into an array
    $counts = [];
    foreach ($results as $row) {
        $counts[$row->status] = $row->bookingCount;
    }

    return $counts;

}

// get booking details for a user
public function getBookingsForUser($userId)
{
   
    $this->pdo->query("
        SELECT * 
        FROM booking 
        WHERE user_id = :user_id
        ORDER BY booking_start DESC
    ");
    $this->pdo->bind(':user_id', $userId);
    $bookings = $this->pdo->resultSet();

    if (!$bookings) return [];

    foreach ($bookings as $booking) {
        $type = $booking->bookable_type;
        $bookableId = $booking->bookable_id;

        switch ($type) {
            case 'stay':
                $this->pdo->query("SELECT * FROM stay WHERE stay_id = :id");
                break;
            case 'tour':
                $this->pdo->query("SELECT * FROM tour WHERE tour_id = :id");
                break;
            case 'restaurant':
                $this->pdo->query("SELECT * FROM restaurant WHERE restaurant_id = :id");
                break;
            case 'room':
                $this->pdo->query("
                    SELECT s.*, r.type AS room_type 
                    FROM room r
                    JOIN stay s ON s.stay_id = r.stay_id
                    WHERE r.room_id = :id
                ");
                break;
            default:
                $booking->item_name = 'Unknown Type';
                continue 2; 
        }

        $this->pdo->bind(':id', $bookableId);
        $details = $this->pdo->single();

        if ($details) {
            $booking->item_name = $details->name ?? 'Unnamed';
            $booking->destination_id = $details->destination_id ?? null;
            $booking->details = $details;

            // Get destination name
            if (!empty($details->destination_id)) {
                $this->pdo->query("SELECT name FROM destination WHERE destination_id = :id");
                $this->pdo->bind(':id', $details->destination_id);
                $dest = $this->pdo->single();
                $booking->destination_name = $dest->name ?? 'Unknown Destination';
            } else {
                $booking->destination_name = 'No Destination';
            }
        } else {
            $booking->item_name = 'Not Found';
            $booking->destination_name = 'N/A';
        }
    }

    return $bookings;
}

}
?>