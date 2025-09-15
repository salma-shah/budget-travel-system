<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($tour->name) ?> – Tripzly</title>
  <link rel="stylesheet" href="/tripzly_test/views/style.css">
  <style>
    <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: #f5f5f5;
    }

    .content {
      max-width: 1000px;
      margin: 30px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .content img {
      width: 100%;
      height: 600px;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .details h2 {
      color: #003366;
      margin-top: 30px;
      border-bottom: 2px solid #007acc;
      padding-bottom: 5px;
    }

    .details p, .details li {
      line-height: 1.8;
      color: #333;
    }

    .details ul {
      padding-left: 20px;
    }

    .details ul li::marker {
      color: #007acc;
    }

    .info-box {
      background: #e6f2ff;
      padding: 15px 20px;
      border-left: 5px solid #007acc;
      border-radius: 6px;
      margin-top: 20px;
    }

    .itinerary {
      background-color: #f0f8ff;
      padding: 20px;
      margin-top: 30px;
      border-radius: 6px;
    }

    .itinerary h3 {
      color: #005fa3;
      margin-bottom: 15px;
    }

    .book-btn {
      display: inline-block;
      background: #007acc;
      color: white;
      padding: 14px 24px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 16px;
      margin-top: 25px;
    }

    .book-btn:hover {
      background: #005fa3;
    }

    .map-placeholder {
      margin-top: 30px;
      background: #d9eaff;
      height: 250px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #003366;
      font-weight: bold;
      border-radius: 6px;
    }
  </style>
</head>
<body>
   <?php include 'navbar.php'; ?>  
    <div class="content">
   <img src="/tripzly_test/<?= htmlspecialchars($tour->image ?? 'images/default-tour.jpg') ?>" alt="<?= htmlspecialchars($tour->alt_text ?? 'Tour Image') ?>">

<div class="details">
  <h2>Tour Overview</h2>
  <p><?= nl2br(htmlspecialchars(str_replace('/', '.', $tour->description))) ?></p>

  <h2>What's Included</h2>
  <ul>
    <?php 
      $includedItems = explode('/', $tour->included);
      foreach ($includedItems as $item): 
        $clean = trim($item);
        if ($clean): ?>
          <li><?= htmlspecialchars($clean) ?></li>
    <?php endif; endforeach; ?>
  </ul>

  <h2>Highlights</h2>
  <ul>
    <?php 
      $highlights = explode('/', $tour->highlights);
      foreach ($highlights as $highlight): 
        $clean = trim($highlight);
        if ($clean): ?>
          <li><?= htmlspecialchars($clean) ?></li>
    <?php endif; endforeach; ?>
  </ul>

  <div class="info-box">
    <p><strong>Duration:</strong> <?= htmlspecialchars($tour->duration) ?></p>
    <p><strong>Price:</strong> LKR <?= number_format($tour->price_per_adult) ?> per person</p>
    <p><strong>Contact:</strong> <?= htmlspecialchars($tour->contacts) ?></p>
  </div>

  <!-- gotta do this-->
  <section class="main-content">
  <div class="availability-check">
     <?php flash('booking'); ?>
     <br>
    <h3>Check Availability</h3>
    <form action="/tripzly_test/make_tour_booking" method="POST" id="bookingForm">
    <label for="checkin">Date:</label>
    <input type="date" name="date" id="date" />

    <label for="guests">Number of Adults:</label>
    <input type="number" name="numAdults" id="numAdults" step="1" min="0" value="0" required>
    
    <!-- hidden input for totalprice and ids -->
    <input type="hidden" name="totalPrice" id="totalPrice">
    <input type="hidden" name="bookableType" value="tour">
    <input type="hidden" name="tourId" value="<?= htmlspecialchars($tour->tour_id) ?>">

    <button type="button" onclick="checkAvailability()">Check Availability</button>

    <div id="availability-result"></div>
    <div id="price-result"></div>
    <button type="submit" class="book-now" style="display:none;">Book Now</button>
</form>
  </div></div>


    <script>
    function checkAvailability() {
  const dateInput = document.getElementById("date").value;
  const numAdults = parseInt(document.getElementById("numAdults").value) || 0;
  const tourId = document.querySelector('input[name="tourId"]').value;

  const availabilityResult = document.getElementById("availability-result");
  const priceResult = document.getElementById("price-result");
  
  
  if (!dateInput) {
    availabilityResult.style.color = "red";
    availabilityResult.textContent = "Please select a date.";
    priceResult.textContent = "";
    return;
  }

      if (numAdults < 1) {
        availabilityResult.style.color = "red";
        availabilityResult.textContent = "Please select at least one adult guest.";
        priceResult.textContent = "";
        return;
      }

      if (numAdults > 10) {
        availabilityResult.style.color = "red";
        availabilityResult.textContent = "One tour guide can only guide 10 adults per tour. Please contact the business organization for group bookings, so they can accomodate you.";
        priceResult.textContent = "";
        return;
      }
 
  fetch("/tripzly_test/tour/check", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
   body: `tourId=${encodeURIComponent(tourId)}&date=${encodeURIComponent(dateInput)}&numAdults=${encodeURIComponent(numAdults)}`
  })
    .then(response => response.json())
    .then(data => {
      const availabilityResult = document.getElementById("availability-result");
      const priceResult = document.getElementById("price-result");

      if (data.available) {
        availabilityResult.style.color = "green";
        availabilityResult.textContent = `Available for ${numAdults} adult(s) on ${dateInput}.`;
        
        // finding total cost based on number of adults 
       priceResult.textContent = `Total Price: LKR ${Number(data.totalPrice).toLocaleString()}`;
       document.getElementById('totalPrice').value = data.totalPrice;
       document.querySelector('.book-now').style.display = 'inline-block';

        // these are for booking
         document.getElementById('totalPrice').value = Number(data.totalPrice).toFixed(2);
         document.querySelector('.book-now').style.display = 'inline-block';
 
      } 
      else {
        availabilityResult.style.color = "red";
        availabilityResult.textContent = "No tours available for the selected dates. Please check later.";
        priceResult.textContent = "";
      }
    });
}

    document.getElementById('loginBtn').addEventListener('click', function () {
      const dropdown = document.getElementById('loginDropdown');
      dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', function (e) {
      if (!e.target.matches('#loginBtn')) {
        const dropdown = document.getElementById('loginDropdown');
        if (dropdown.style.display === 'block') dropdown.style.display = 'none';
      }
    });
  </script>
  
  </div>
</body>

    <!-- Footer -->
  <footer>
    <div class="footer-container">
      <div class="footer-section">
        <h4>Company</h4>
        <ul>
          <li><a href="about.php">About Tripzly</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Newsroom</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Explore</h4>
        <ul>
          <li><a href="stays.php">Stays</a></li>
          <li><a href="attractions.php">Attractions</a></li>
          <li><a href="restaurants.php">Restaurants</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Help</h4>
        <ul>
          <li><a href="contact.php">Customer Support</a></li>
          <li><a href="about.php">Terms & Conditions</a></li>
          <li><a href="about.php#">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Connect With Us</h4>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Instagram</a></li>
          <li><a href="#">YouTube</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2025 Tripzly. All rights reserved.
    </div>
  </footer>
</html>