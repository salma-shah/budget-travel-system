
<?php

require_once __DIR__ . '/../Connection.php';

class Payment {
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;}

public function makePayment($data) 
    {
        // query to insert data
        $this -> pdo -> query('INSERT INTO payment( booking_id,  amount, status, method )
        VALUES ( :booking_id, :amount, :status, :method)');
        
         $this -> pdo -> bind(':booking_id', $data['booking_id']);
         $this -> pdo -> bind(':amount', $data['amount']);
         $this -> pdo -> bind(':status', $data['status']);
         $this -> pdo -> bind(':method', $data['method']);

           if ( $this -> pdo -> execute())
         {
            return true;
         }
         else { return false;}
    }

    public function updateBookingPaymentStatus($bookingId)
    {
        $this->pdo->query('UPDATE booking SET payment_status = :payment_status WHERE booking_id = :booking_id');
        $this->pdo->bind('booking_id', $bookingId);
        $this->pdo->bind('payment_status', 'Paid');
          if ( $this -> pdo -> execute())
         {
            return true;
         }
         else { return false;}
    }
}