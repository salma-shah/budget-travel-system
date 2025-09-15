<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="/tripzly_test/views/style.css" />
  <title><?= htmlspecialchars($stay->name) ?> – Tripzly</title>
  <?php include_once __DIR__ . '/../helpers/session_helper.php'; ?>

  <style>
   body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #fff;
      color: #333;
    }

    .container {
      max-width: 1200px;
      margin: auto;
      padding: 20px;
    }

    h1 {
      color: #003366;
      font-size: 36px;
      margin-bottom: 0;
    }

    .carousel {
      display: flex;
      gap: 10px;
      overflow-x: auto;
      padding: 10px 0;
      margin-bottom: 20px;
    }

    .carousel img {
      height: 250px;
      border-radius: 10px;
      flex-shrink: 0;
      transition: transform 0.3s;
    }

    .carousel img:hover {
      transform: scale(1.05);
    }

    .hotel-description {
      margin: 20px 0;
      line-height: 1.6;
      font-size: 18px;
    }

    .facilities {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin: 20px 0;
    }

    .facility {
      background: #f5f5f5;
      padding: 8px 15px;
      border-radius: 20px;
      font-size: 14px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .availability-check {
  margin: 30px auto;         /* center horizontally */
  background: #f9f9f9;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  
  max-width: 300px;          /* reduce max width */
  width: 90%;                /* responsive width */
  box-sizing: border-box;
}


    .availability-check label,
    .availability-check input,
    .availability-check select,
    .availability-check button {
      display: block;
      margin-bottom: 10px;
      width: 100%;
      max-width: 300px;
      font-size: 16px;
    }

    input[type="date"],
    select {
      padding: 8px;
      border-radius: 8px;
      border: 1px solid #ccc;
      background: #fff;
      transition: 0.3s ease;
    }

    input[type="date"]:focus,
    select:focus {
      border-color: #003366;
      outline: none;
      box-shadow: 0 0 5px #003366;
    }

    .availability-check button {
      background-color: #003366;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }

    #availability-result {
      margin-top: 15px;
      font-size: 16px;
      color: green;
    }

    #price-result {
      margin-top: 10px;
      font-weight: bold;
      color: #003366;
    }

    .weather-section {
      margin: 40px 0;
    }

    .weather-section h3 {
      margin-bottom: 10px;
      color: #003366;
    }

    select#city-select {
      font-size: 16px;
      padding: 8px;
      border-radius: 8px;
      border: 1px solid #ccc;
      max-width: 300px;
      margin-bottom: 20px;
    }

    .weather-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      padding: 10px 0;
    }

    .weather-card {
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      color: #fff;
      border-radius: 15px;
      padding: 20px;
      width: 160px;
      box-shadow: 0 8px 20px rgba(26, 64, 123, 0.3);
      text-align: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: default;
    }

    .weather-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 16px 30px rgba(26, 64, 123, 0.5);
    }

    .weather-card img {
      width: 60px;
      margin: 0 auto 12px;
      filter: drop-shadow(0 0 2px rgba(255, 255, 255, 0.7));
    }

    .date {
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: 10px;
      letter-spacing: 0.05em;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    }

    .weather-card div:nth-child(3) {
      font-size: 1.2rem;
      margin-bottom: 6px;
      font-weight: 600;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }

    .weather-card div:last-child {
      font-size: 1rem;
      font-weight: 500;
      color: #cfe0fc;
      text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
    }

    /* Book Now styled as link button */
    .book-now {
      display: inline-block;
      text-align: center;
      background-color: #003366;
      color: white;
      padding: 15px 30px;
      border-radius: 10px;
      font-size: 1.1rem;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.3s;
      margin-top: 20px;
    }

    .book-now:hover {
      background-color: #6493c6;
    }

    @media (max-width: 600px) {
      .carousel img {
        height: 180px;
      }
    }
    /* Container fills vertically and horizontally with nice padding */
.reviews-section {
  max-width: 900px;       /* smaller max width */
  width: 80vw;            /* slightly narrower */
  min-height: 30vh;       /* smaller min height */
  margin: 20px auto;      /* less margin */
  padding: 20px 25px;     /* reduced padding */
  background: #0a1e4d;
  border-radius: 12px;    /* smaller radius */
  box-shadow: 0 6px 18px rgba(10, 30, 77, 0.5); /* lighter shadow */
  color: #f0f4ff;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 16px;              /* less gap */
  box-sizing: border-box;
}

.reviews-section h2 {
  font-size: 20px;        /* smaller font */
  font-weight: 700;
  color: #82aaff;
  text-align: center;
  letter-spacing: 0.8px;
}

.reviews-section input[type="text"],
.reviews-section select,
.reviews-section textarea {
  width: 100%;
  padding: 10px 14px;     /* smaller padding */
  font-size: 13px;        /* smaller font */
  border: 2px solid #3e62ad;
  border-radius: 10px;
  background-color: #142d7d;
  color: #e2e8f0;
  font-family: inherit;
  transition: border-color 0.3s ease, background-color 0.3s ease;
  box-sizing: border-box;
  resize: vertical;
}

.reviews-section input[type="text"]::placeholder,
.reviews-section textarea::placeholder,
.reviews-section select option:first-child {
  color: #a0aec0;
}

.reviews-section input[type="text"]:focus,
.reviews-section select:focus,
.reviews-section textarea:focus {
  border-color: #82aaff;
  background-color: #1f3ba7;
  outline: none;
  color: #f0f4ff;
}

.reviews-section select {
  cursor: pointer;
}

.reviews-section button {
  margin-top: 8px;
  background: linear-gradient(90deg, #4c6ef5, #364fc7);
  border: none;
  color: white;
  font-weight: 700;
  font-size: 14px;        /* smaller font */
  padding: 10px 0;        /* smaller padding */
  border-radius: 12px;
  cursor: pointer;
  letter-spacing: 0.03em;
  transition: background 0.3s ease;
}

.reviews-section button:hover {
  background: linear-gradient(90deg, #364fc7, #4c6ef5);
  box-shadow: 0 4px 10px rgba(70, 100, 255, 0.4);
}

/* Responsive text sizes */
@media (max-width: 600px) {
  .reviews-section {
    padding: 15px 15px;
    min-height: auto;
  }

  .reviews-section h2 {
    font-size: 18px;
  }

  .reviews-section input[type="text"],
  .reviews-section select,
  .reviews-section textarea {
    font-size: 12px;
    padding: 10px 12px;
  }

  .reviews-section button {
    font-size: 13px;
    padding: 10px 0;
  }
}

.reviews-list {
  margin-top: 24px;
  max-height: 180px;        /* smaller max height */
  overflow-y: auto;
  padding-right: 6px;
  border-top: 1px solid #27418b;
}

.reviews-list h3 {
  color: #82aaff;
  font-weight: 700;
  font-size: 18px;          /* smaller font */
  margin-bottom: 12px;
  text-align: center;
}

.review-item {
  background-color: #142d7d;
  border-radius: 10px;
  padding: 10px 14px;       /* smaller padding */
  margin-bottom: 10px;
  box-shadow: 0 2px 6px rgba(10, 30, 77, 0.3);
  color: #dbe9ff;
}

.reviewer-name {
  font-weight: 700;
  font-size: 14px;          /* smaller font */
  color: #a1c4fd;
  margin-bottom: 3px;
}

.review-rating {
  color: #ffd700;
  font-size: 14px;          /* smaller font */
  margin-bottom: 6px;
  letter-spacing: 1.5px;
}

.review-comment {
  font-size: 13px;          /* smaller font */
  line-height: 1.3;
  color: #cfd9ff;
  white-space: pre-wrap;
}

.main-content {
  max-width: 1200px;
  margin: 40px auto 60px; /* top/bottom margin, center horizontally */
  display: flex;
  gap: 40px;
  padding: 0 20px;
  box-sizing: border-box;
}

.availability-check,
.reviews-section {
  flex: 1 1 0; /* equal width, flexible */
  min-width: 300px; /* avoid too narrow on small screens */
}

/* Responsive: stack vertically on smaller screens */
@media (max-width: 900px) {
  .main-content {
    flex-direction: column;
    margin: 20px auto 40px;
  }

  .availability-check,
  .reviews-section {
    width: 100%;
    min-width: auto;
  }
}


  </style>
</head>
<body>

   <?php include 'navbar.php'; ?>  

  <div class="container">

    <h1><?= htmlspecialchars($stay->name) ?></h1>

<div class="carousel">
 
  <?php if (!empty($stay->images)): ?>
    <?php foreach ($stay->images as $img): ?>
      <img src="/tripzly_test/<?= htmlspecialchars($img->image) ?>" alt="<?= htmlspecialchars($img->alt_text ?? $stay->name) ?>" />
 <?php endforeach; ?>
  <?php else: ?>
    <p>No images available.</p>
  <?php endif; ?>
</div>

<div class="hotel-description">
  <?= nl2br(htmlspecialchars($stay->description)) ?><br>
   <?= nl2br(htmlspecialchars($stay->contacts)) ?><br>
    <?= nl2br(htmlspecialchars($stay->free_cancellation)) ?><br>
</div>

<h3>Facilities</h3>
<div class="facilities">
  <?php if (!empty($stay->amenities)): ?>
    <?php foreach ($stay->amenities as $a): ?>
      <div class="facility"><?= htmlspecialchars($a->name) ?></div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="facility">No amenities listed.</div>
  <?php endif; ?>
</div>

    <div class="weather-section">
      <h3>5-Day Weather Forecast</h3>

      <label for="city-select">Select City for Weather Forecast: </label>
<select id="city-select" name="city-select" required>

  <!-- Colombo and suburbs -->
  <optgroup label="Colombo">
    <option value="Colombo">Colombo</option>
    <option value="Dehiwala">Dehiwala</option>
    <option value="Nugegoda">Nugegoda</option>
    <option value="Battaramulla">Battaramulla</option>
    <option value="Kollupitiya">Kollupitiya</option>
    <option value="Borella">Borella</option>
    <option value="Maharagama">Maharagama</option>
  </optgroup>

  <!-- Kandy and suburbs -->
  <optgroup label="Kandy">
    <option value="Kandy">Kandy</option>
    <option value="Peradeniya">Peradeniya</option>
    <option value="Katugastota">Katugastota</option>
    <option value="Gampola">Gampola</option>
  </optgroup>

  <!-- Galle and suburbs -->
  <optgroup label="Galle">
    <option value="Galle">Galle</option>
    <option value="Unawatuna">Unawatuna</option>
    <option value="Hikkaduwa">Hikkaduwa</option>
    <option value="Ambalangoda">Ambalangoda</option>
  </optgroup>

  <!-- Jaffna and suburbs -->
  <optgroup label="Jaffna">
    <option value="Jaffna">Jaffna</option>
    <option value="Chavakachcheri">Chavakachcheri</option>
    <option value="Point Pedro">Point Pedro</option>
  </optgroup>

  <!-- Negombo and suburbs -->
  <optgroup label="Negombo">
    <option value="Negombo">Negombo</option>
    <option value="Katana">Katana</option>
    <option value="Mundal">Mundal</option>
  </optgroup>

  <!-- Other cities -->
  <option value="Anuradhapura">Anuradhapura</option>
  <option value="Trincomalee">Trincomalee</option>
  <option value="Nuwara Eliya">Nuwara Eliya</option>
  <option value="Matara">Matara</option>
  <option value="Badulla">Badulla</option>
  <option value="Ratnapura">Ratnapura</option>
  <option value="Polonnaruwa">Polonnaruwa</option>
  <option value="Hambantota">Hambantota</option>
  <option value="Batticaloa">Batticaloa</option>
  <option value="Kurunegala">Kurunegala</option>
  <option value="Vavuniya">Vavuniya</option>
  <option value="Mannar">Mannar</option>
  <option value="Chilaw">Chilaw</option>
  <option value="Kalutara">Kalutara</option>
</select>
      <div class="weather-container" id="weather-container">Loading weather...</div> 
    </div>
 </div>

<section class="main-content">
  <div class="availability-check">
     <?php flash('booking'); ?>
     <br>
    <h3>Check Availability</h3>
    <form action="/tripzly_test/make_booking" method="POST" id="bookingForm">
    <label for="checkin">Check-in Date:</label>
    <input type="date" name="checkin" id="checkin" />

    <label for="checkout">Check-out Date:</label>
    <input type="date" name="checkout" id="checkout" />

    <label for="guests">Number of Adults:</label>
    <input type="number" name="guestsAdults" id="guestsAdults" step="1" min="0" value="0" required>

    <label for="guests">Number of Children:</label>
    <input type="number" name="guestsChildren" id="guestsChildren" step="1" min="0" value="0" required>

    <label for="guests">Number of Rooms:</label>
    <input type="number" name="roomCount" id="roomCount" step="1" min="0" value="0" required>

    <label for="room-type">Room Type:</label>
    <select id="room-type">
      <option value="single">Single Room</option>
      <option value="double">Double Room</option>
      <option value="deluxe">Deluxe Room</option>
      <option value="suite">Suite Room</option>
       <option value="family">Family Room</option>
    </select>
    
    <!-- hidden input for totalprice and room ids -->
    <input type="hidden" name="totalPrice" id="totalPrice">
    <input type="hidden" name="roomIds" id="roomIdsInput">
    <input type="hidden" name="bookableType" value="room">
    <input type="hidden" name="stayId" value="<?= htmlspecialchars($stay->stay_id) ?>">

    <button type="button" onclick="checkAvailability()">Check Availability</button>

    <div id="availability-result"></div>
    <div id="price-result"></div>
    <button type="submit" class="book-now" style="display:none;">Book Now</button>
</form>
  </div>

  <section class="reviews-section">
    <h2>Leave a Review</h2>
     <form action="/tripzly_test/leave_review" method="POST" id="reviewForm">
    <select id="rating" name="rating" required>
      <option value="" disabled selected>Rate your stay</option>
      <option value="5">★★★★★ (5)</option>
      <option value="4">★★★★ (4)</option>
      <option value="3">★★★ (3)</option>
      <option value="2">★★ (2)</option>
      <option value="1">★ (1)</option>
    </select>

    <textarea id="comment" name="comment" rows="4" placeholder="Write your review here..." required></textarea>

    <!-- hidden -->
    <input type="hidden" name="reviewableType" value="stay">
    <input type="hidden" name="reviewableId" value="<?= htmlspecialchars($stay->stay_id) ?>">
    <button type="submit" id="submit-review">Submit Review</button></form>

    <div class="reviews-list">
  <h3>Reviews from Guests</h3>

  <?php if (empty($reviews)): ?>
    <p>No reviews yet.</p>
  <?php else: ?>
    <?php foreach ($reviews as $review): ?>
      <div class="review-item">
        <p class="review-rating">
          <?= str_repeat('★', $review->rating) . str_repeat('☆', 5 - $review->rating) ?>
        </p>
        <p class="review-comment"><?= htmlspecialchars($review->comment) ?></p>
        <p class="review-user"><strong>By:</strong> <?= htmlspecialchars($review->username) ?></p>
        <p class="review-date"><small><?= date('F j, Y', strtotime($review->date)) ?></small></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

  </section>
</section>

  <script>
    const apiKey = "940bf30c6979a72aac34ef460a1869f4";

    function checkAvailability() {
  const checkinDate = new Date(document.getElementById("checkin").value);
  const checkoutDate = new Date(document.getElementById("checkout").value);
  const roomType = document.getElementById("room-type").value;
  const guestsAdults = parseInt(document.getElementById("guestsAdults").value);
  const guestsChildren = parseInt(document.getElementById("guestsChildren").value);
  const roomCount = parseInt(document.getElementById("roomCount").value);

  const availabilityResult = document.getElementById("availability-result");
  const priceResult = document.getElementById("price-result"); 

  // format to y-m-d
  const checkin = checkinDate.toISOString().split('T')[0];
  const checkout = checkoutDate.toISOString().split('T')[0];

  // valiation
    if (isNaN(checkinDate.getTime()) || isNaN(checkoutDate.getTime())) {
        availabilityResult.style.color = "red";
        availabilityResult.textContent = "Please select valid check-in and check-out dates.";
        priceResult.textContent = "";
        return;
      }

      if (checkoutDate <= checkinDate) {
        availabilityResult.style.color = "red";
        availabilityResult.textContent = "Check-out date must be after check-in date.";
         priceResult.textContent = "";
        return;
      }

      if (guestsAdults < 1) {
        availabilityResult.style.color = "red";
        availabilityResult.textContent = "Please select at least one guest.";
        priceResult.textContent = "";
        return;
      }

      // check that at least one room added
      if (isNaN(roomCount) || roomCount < 1) {
        availabilityResult.style.color = "red";
        availabilityResult.textContent = "Please select at least one room.";
        priceResult.textContent = "";
        return;
      }

      const adultsPerRoom = guestsAdults / roomCount;
      if (adultsPerRoom > 4) {
        const requiredRooms = Math.ceil(guestsAdults / 4);
        availabilityResult.style.color = "red";
        availabilityResult.textContent = `Too many adults for one room. You need at least ${requiredRooms} room(s).`;
        priceResult.textContent = "";
        return;
      }

      const childrenPerRoom = guestsChildren / roomCount;
      if (childrenPerRoom > 2)
      {
         availabilityResult.style.color = "red";
         availabilityResult.textContent = "Too many children per room. Please add another room.";
         priceResult.textContent = "";
         return;
      }

  fetch("/tripzly_test/booking/check", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `checkin=${encodeURIComponent(checkin)}&checkout=${encodeURIComponent(checkout)}&room_type=${encodeURIComponent(roomType)}&room_count=${encodeURIComponent(roomCount)}`
  })
    .then(response => response.json())
    .then(data => {
      const availabilityResult = document.getElementById("availability-result");
      const priceResult = document.getElementById("price-result");

      if (data.available) {
        availabilityResult.style.color = "green";
        const roomNames = data.rooms.map(room => `${room.name} (${room.type})`).join(', ');
        availabilityResult.textContent = `Room available: ${roomNames}`;
        
        // calculating total cost based on number of adults and children
        const nights = (new Date(checkout) - new Date(checkin)) / (1000 * 60 * 60 * 24);

        const totalPrice = data.rooms.reduce((sum, room) => {
          return sum + (nights * parseFloat(room.price_per_night));}, 0);

        priceResult.textContent = `Total Price: $${totalPrice.toFixed(2)} for ${nights} night(s) for
        ${roomCount} room(s).`;

        // these are for booking
         document.getElementById('totalPrice').value = totalPrice.toFixed(2);
         document.getElementById('roomIdsInput').value = data.rooms.map(r => r.room_id).join(',');
         document.querySelector('.book-now').style.display = 'inline-block';
 
      } 
      else {
        availabilityResult.style.color = "red";
        availabilityResult.textContent = "No rooms available for the selected type and dates.";
        priceResult.textContent = "";
      }
    });
}


    function capitalize(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    }

    async function fetchWeather(city) {
      const weatherContainer = document.getElementById("weather-container");
      weatherContainer.innerHTML = "Loading weather...";

      try {
        const response = await fetch(
          `https://api.openweathermap.org/data/2.5/forecast?q=${city},LK&units=metric&appid=${apiKey}`
        );
        const data = await response.json();

        if (data.cod !== "200") {
          weatherContainer.innerHTML = `<p>Weather data not available for ${city}.</p>`;
          return;
        }

        // Extract daily forecasts for next 5 days (approx. midday)
        const dailyData = {};
        data.list.forEach((item) => {
          const date = item.dt_txt.split(" ")[0];
          if (!dailyData[date]) {
            dailyData[date] = [];
          }
          dailyData[date].push(item);
        });

        const days = Object.keys(dailyData).slice(0, 5);

        weatherContainer.innerHTML = days
          .map((day) => {
            // Pick the item closest to 12:00:00 for each day
            const middayData = dailyData[day].reduce((prev, curr) => {
              return Math.abs(new Date(curr.dt_txt).getHours() - 12) <
                Math.abs(new Date(prev.dt_txt).getHours() - 12)
                ? curr
                : prev;
            });

            const dateOptions = { weekday: "short", month: "short", day: "numeric" };
            const formattedDate = new Date(day).toLocaleDateString("en-US", dateOptions);
            const iconUrl = `https://openweathermap.org/img/wn/${middayData.weather[0].icon}@2x.png`;
            const temp = middayData.main.temp.toFixed(1);
            const description = middayData.weather[0].description;

            return `
              <div class="weather-card">
                <div class="date">${formattedDate}</div>
                <img src="${iconUrl}" alt="${description}" />
                <div>${temp} °C</div>
                <div>${description}</div>
              </div>
            `;
          })
          .join("");
      } catch (error) {
        weatherContainer.innerHTML = `<p>Error loading weather data. Please try again later.</p>`;
      }
    }

    document.getElementById("city-select").addEventListener("change", (e) => {
      fetchWeather(e.target.value);
    });

    // Load default city weather on page load
    window.onload = () => {
      fetchWeather(document.getElementById("city-select").value);
    };

    //review
//    document.getElementById('reviewForm').addEventListener('submit', function(e) {
//   e.preventDefault(); // Stop form from reloading the page

//   const rating = document.getElementById('rating').value;
//   const comment = document.getElementById('comment').value.trim();
//   const reviewableType = document.querySelector('input[name="reviewableType"]').value;
//   const reviewableId = document.querySelector('input[name="reviewableId"]').value;

//   // validation
//   if (!rating) {
//     alert('Please select a rating.');
//     return;
//   }
//   if (!comment) {
//     alert('Please write a review.');
//     return;
//   }

//   // send review to PHP
//   fetch('/tripzly_test/leave_review', {
//     method: 'POST',
//     headers: {
//       'Content-Type': 'application/x-www-form-urlencoded'
//     },
//     body: `rating=${encodeURIComponent(rating)}&comment=${encodeURIComponent(comment)}&reviewableType=${encodeURIComponent(reviewableType)}&reviewableId=${encodeURIComponent(reviewableId)}`
//   })
//   .then(response => response.json())
//   .then(data => {
//     if (data.success) {
//       // show review on page
//       const stars = '★'.repeat(rating) + '☆'.repeat(5 - rating);

//       const reviewItem = document.createElement('div');
//       reviewItem.classList.add('review-item');
//       reviewItem.innerHTML = `
//         <p class="review-rating">${stars}</p>
//         <p class="review-comment">${comment}</p>
//       `;

//       document.querySelector('.reviews-list').appendChild(reviewItem);

//       // Clear the form
//       document.getElementById('rating').value = '';
//       document.getElementById('comment').value = '';
//     } else {
//       alert('There was an error in saving your review. Please try again.');
//     }
//   })
//   .catch(err => {
//     console.error('Error:', err);
//   });
// });

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
