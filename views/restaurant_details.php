<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="/tripzly_test/views/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($restaurant->name) ?> – Tripzly</title>
  <style>
    /* Styles identical to previous pages */
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #f9f9f9;
      color: #333;
    }

    .container {
      max-width: 1100px;
      margin: auto;
      padding: 20px;
    }

    .restaurant-header {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .restaurant-image {
      flex: 1 1 400px;
      height: 350px;
      background-image: url('images/Res4.jpeg');
      background-size: cover;
      background-position: center;
      border-radius: 12px;
    }

    .restaurant-info {
      flex: 1 1 400px;
    }

    h1 {
      font-size: 2.5rem;
      color: #000266;
      margin-bottom: 10px;
    }

    .location, .contact {
      font-style: italic;
      margin-bottom: 10px;
      color: #777;
    }

    .description {
      margin-top: 15px;
      font-size: 1rem;
    }

    .booking-section {
      margin-top: 40px;
      background-color: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .booking-section h2 {
      font-size: 1.8rem;
      color: #000266;
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: 600;
      margin: 10px 0 5px;
    }

    input {
      padding: 8px 12px;
      font-size: 1rem;
      width: 100%;
      max-width: 300px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .reserve-btn {
      margin-top: 20px;
      background-color: #000266;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
    }

    .reserve-btn:hover {
      background-color: #0022aa;
    }

    @media screen and (max-width: 768px) {
      .restaurant-header {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
   <?php include 'navbar.php'; ?>  

  <div class="container">
    <div class="restaurant-header">
      <div class="restaurant-image">
      <img src="/tripzly_test/<?= htmlspecialchars($restaurant->image ?? 'default-image.jpg') ?>"
     alt="<?= htmlspecialchars($restaurant->name ?? 'Restaurant Image') ?>"
     style="max-width: 400px; width: 100%; height: 400px; object-fit: cover;" />
 </div>
      <div class="restaurant-info">
        <h1><?= htmlspecialchars($restaurant->name ?? 'Restaurant Name') ?></h1>
        <div class="location"><?= htmlspecialchars($restaurant->address ?? 'Location not available') ?></div>
        <div class="contact">Call us: <?= htmlspecialchars($restaurant->contacts ?? 'N/A') ?></div>
        <p class="description">
          <?= htmlspecialchars($restaurant->description ?? 'No description available.') ?>
        </p>
      </div>
    </div>
</div>

    <div class="booking-section">
      <h2>Check Availability & Reserve</h2>
      <?php flash('reservation'); ?><br>
       <form action="/tripzly_test/make_reservation" method="POST" id="reservationForm">
      <label for="res-date">Select Date:</label>
      <input type="date" id="date" name="date" required />

      <label for="res-time">Select Time:</label>
      <input type="time" id="time" name="time" min="10:00" max="23:00" required />

      <label for="guests">Number of Guests:</label>
      <input type="number" id="guests" name="guests" min="1" max="12" placeholder="e.g. 2" />

       <input type="hidden" name="restaurantId" value="<?= htmlspecialchars($restaurant->restaurant_id) ?>">

      <div id="availability-result"></div>
      <button class="reserve-btn" id="check-avalibility">Check Availability</button>
      <button type="submit" class="reserve-btn" id="reserve-now" style="display:none;">Reserve Now</button>
    </div>
  </div>

  <script>

// this is to ensure the check availiblity btn doesnt accidentally submit the form to make reservation
document.getElementById('check-avalibility').addEventListener('click', function(event) {
    event.preventDefault();
    checkAvailability();
  });

// reservation availibilty
    function checkAvailability() {
  const dateInput = document.getElementById("date").value;  // single date input
  const timeInput = document.getElementById("time").value;  // time input
  const guests = parseInt(document.getElementById("guests").value);
  const restaurantContact = <?= json_encode($restaurant->contacts ?? 'N/A') ?>;  // getting restaurants contact
  const restaurantId= <?= json_encode($restaurant->restaurant_id) ?>;
  const availabilityResult = document.getElementById("availability-result");


  // validation
  if (!dateInput) {
    availabilityResult.style.color = "red";
    availabilityResult.textContent = "Please select a reservation date.";
    return;
  }

  if (!timeInput) {
    availabilityResult.style.color = "red";
    availabilityResult.textContent = "Please select a reservation time.";
    return;
  }

  if (isNaN(guests) || guests < 1) {
    availabilityResult.style.color = "red";
    availabilityResult.textContent = "Please enter the number of guests.";
    return;
  }

  // if guests > 12, we will ask user to call instead because its too many guests for a table
  if (guests > 12) {
    availabilityResult.style.color = "red";
    availabilityResult.innerHTML = `For reservations with more than 12 guests, please call us at <a href="tel:${restaurantContact}">${restaurantContact}</a>.`;
    return;
  }

  // joining date and time into one string value
   const datetime = dateInput + ' ' + timeInput + ':00'; 

  // if all valid and guests <= 12, check availibilty
  fetch("/tripzly_test/reservation/check", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `date=${encodeURIComponent(dateInput)}&time=${encodeURIComponent(timeInput)}&guests=${encodeURIComponent(guests)}&restaurantId=${encodeURIComponent(restaurantId)}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.available) {
      availabilityResult.style.color = "green";
      availabilityResult.textContent = `Table available at ${timeInput} on ${dateInput} for ${guests} guest(s).`;
      document.querySelector('#check-avalibility').style.display = 'inline-block';

      // this is for reservation

       document.querySelector('#reserve-now').style.display = 'inline-block';
      
    } else {
      availabilityResult.style.color = "red";
      availabilityResult.textContent = "We apologize. There are no tables available at the selected time and date.";
    }
  })
  .catch(err => {
    availabilityResult.style.color = "red";
    availabilityResult.textContent = "There was an error checking availability. Please try again.";
    console.error(err);
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
</body>
</html>
