<?php
require_once __DIR__ . '/../helpers/session_helper.php';

class PaymentController {

    private $paymentModel;
     private $bookingModel;

      public function __construct(){
        $this->bookingModel = new Booking();
          $this->paymentModel = new Payment();
      }
       public function showPaymentForm()
     {
        $bookingId = $_GET['booking_id'] ?? null;
        $amount = $_GET['amount'] ?? null;
        if (!$bookingId || !$amount) { die("Invalid request"); }

        require_once __DIR__ . '/../views/payment.php';
     }

public function makePayment() {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // sanitize
        $bookingId = filter_var(trim($_POST['bookingId']), FILTER_SANITIZE_NUMBER_INT);
        $method = filter_var(trim($_POST['paymentMethod']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     
        $booking = $this->bookingModel->getBookingById($bookingId);
        if (!$booking) {
           flash('payment', 'Invalid booking ID.');
          redirect('/tripzly_test/payment_form');
        }

         $amount = (float) trim($_POST['amount']);

        // Prepare data array
        $data = [
            'booking_id' => $bookingId,
            'amount' => $amount,
            'method' => $method,
            'status' => 'Paid'
        ];

        // validation
        if (empty($method) || empty($bookingId) || empty($amount )) {
            flash('payment', 'All fields are required.');
            redirect('/tripzly_test/payment_form');
        }

        // calling payment model
        if ($this->paymentModel->makePayment($data)) {
            $this->paymentModel->updateBookingPaymentStatus($bookingId);
            flash('payment', 'The payment was made successfully.', 'form-message form-message-green');
        } else {
            flash('payment', 'Something went wrong. Please try again.');
        }
        redirect('/tripzly_test/payment_form');
    }
}
}
