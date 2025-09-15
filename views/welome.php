<?php
// session_start();
include_once __DIR__ . '/../helpers/session_helper.php';
require_once __DIR__ . '/../controllers/TourController.php';
// redirect to login if user is not logged in to ensure security
if (!isset($_SESSION['userId']) || !isset($_SESSION['name'])) {
    header("Location: ../views/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome everyone!</title>
</head>
<body>

    <h1>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</h1>
    <a href="../controllers/UserController.php?q=logout" class="logout-btn">Logout</a>

    <!-- <?php flash('booking'); ?>

<h2>Make a Booking</h2>

<form action="../controllers/BookingController.php" method="POST">

    <input type="hidden" name="bookableId" value=1>
    <label for="numOfAdults">Number of Adults:</label>
    <input type="number" name="numOfAdults" id="numOfAdults" min="1" required>
    <label for="numOfChildren">Number of Children:</label>
    <input type="number" name="numOfChildren" id="numOfChildren" min="0" required>
    <label for="bookingStart">Start Date:</label>
    <input type="date" name="bookingStart" id="bookingStart" required>
    <label for="bookingEnd">End Date:</label>
    <input type="date" name="bookingEnd" id="bookingEnd" required>
    <button type="submit">Book Now</button>
</form> -->

<form action="../controllers/ReservationController.php" method="POST" class="p-4 border rounded shadow" style="max-width: 600px; margin: auto;">
  <h2 class="text-center mb-4">Reserve</h2>
<input type="hidden"  name = "restaurantId" value=1>
  <div class="form-group mb-3">
    <label for="date">Reservation Date</label>
    <input type="date" class="form-control" name="date" id="date" required min="<?= date('Y-m-d') ?>">
  </div>

  <button type="submit" class="btn btn-primary">Reserve</button>
</form>

                <form action="../controllers/BookingController.php" method="POST">
                    <input type="hidden" name="bookingId" value=5>
                    <input type="hidden" name="action" value="approve">
                    <button type="submit">Approve</button>
                </form>

                
                <?php
// You can display flash messages or errors here
if (isset($_SESSION['form_message'])) {
    echo '<p>' . $_SESSION['form_message'] . '</p>';
    unset($_SESSION['form_message']);
}
?>

<form action="../controllers/TourController.php" method="POST">
    <label for="destinationId">Destination ID:</label>
    <input type="number" name="destinationId" id="destinationId" required>

    <label for="name">Tour Name:</label>
    <input type="text" name="name" id="name" required>

    <label for="address">Address:</label>
    <input type="text" name="address" id="address" required>

    <label for="type">Type:</label>
    <input type="text" name="type" id="type" required>

    <label for="pricePerAdult">Price per Adult (Rs):</label>
    <input type="number" name="pricePerAdult" id="pricePerAdult" step="0.01" required>

    <label for="pricePerChild">Price per Child (Rs):</label>
    <input type="number" name="pricePerChild" id="pricePerChild" step="0.01" required>

    <label for="duration">Duration (hours/days):</label>
    <input type="number" name="duration" id="duration" required>

    <label for="contacts">Contact Info:</label>
    <input type="text" name="contacts" id="contacts" required>

    <label for="avgRating">Average Rating:</label>
    <input type="number" name="avgRating" id="avgRating" step="0.1" min="0" max="5" value="0" required>

    <label for="freeCancellation">Free Cancellation:</label>
    <select name="freeCancellation" id="freeCancellation" required>
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select>

    <label for="isAvailable">Is Available:</label>
    <select name="isAvailable" id="isAvailable" required>
        <option value="1">Available</option>
        <option value="0">Not Available</option>
    </select>

    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="Pending">Pending</option>
        <option value="Approved">Approved</option>
        <option value="Rejected">Rejected</option>
    </select>

    <button type="submit">Add Tour</button>
</form>

</body>
</html>

