<?php
include_once __DIR__ . '/../helpers/session_helper.php';

// if (!isset($_SESSION['userId']) || !isset($_SESSION['name'])) {
//     header("Location: ../user/login");
//     exit();
// }
// ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tripzly - Discover Your Next Staycation</title>
 <link rel="stylesheet" href="/tripzly_test/views/style.css" />
</head>
<body>
<div class="page-wrapper">
  <?php include 'navbar.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Discover Your Next Staycation</h1>
    <p>Explore beautiful places with Tripzly</p>

    <form id="searchStaysForm" class="search-bar">
      <input type="text" id="destination" name="destination" placeholder="Where are you going?" />
      
      <label>Check-in</label>
      <input type="date" id="checkin" name="checkin" />

      <label>Check-out</label>
      <input type="date" id="checkout" name="checkout" />

      <input type="number" id="guests" name="guests" placeholder="Guests" min="1" />
      <button class="btn" type="submit" id="search">Search</button>
    </form>
  </section>

  <!-- Trending Destinations -->
  <section class="trending">
    <h2>Trending Destinations</h2>
    <div class="destinations">
      <?php if (!empty($destinations)): ?>
        <?php foreach ($destinations as $d): ?>
          <div class="card">
            <img src="/tripzly_test/<?= htmlspecialchars($d->image) ?>" alt="<?= htmlspecialchars($d->alt_text) ?>" class="destination-image">
            <div class="destination-name"><?= htmlspecialchars($d->name) ?></div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No destinations available.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Filters -->
  <section class="filters" id="filters">
    <h3>Popular Filters</h3>
    <div class="tags" id="amenityFilters">
      <?php foreach ($amenities as $amenity): ?>
        <button class="amenity-btn" data-id="<?= htmlspecialchars($amenity->id) ?>">
          <?= htmlspecialchars($amenity->name) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <div class="budget-section">
      <label for="budgetRange">Select Budget Range</label>
      <input type="range" id="budgetRange" min="5000" max="500000" step="5000"
        oninput="document.getElementById('rangeValue').innerText = 'LKR ' + Number(this.value).toLocaleString()" />
      <p>Budget: <span id="rangeValue">LKR 5,000</span></p>
    </div>

    <h2>Top Stays</h2>
    <div class="stay-grid" id="stayResults">
      <?php if (!empty($stays)): ?>
        <?php foreach ($stays as $stay): ?>
          <div class="stay-card">
            <img src="/tripzly_test/<?= htmlspecialchars($stay->image) ?>" 
                alt="<?= htmlspecialchars($stay->alt_text ?? $stay->name) ?>" class="stay-image">
            <div class="stay-content">
              <div class="stay-title"><?= htmlspecialchars($stay->name) ?></div>
              <div class="stay-type"><?= htmlspecialchars($stay->property_type) ?></div>
              <a href="/tripzly_test/stay/<?= urlencode($stay->stay_id) ?>" class="view-button">View Details</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No stays available at the moment.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Feedback -->
  <section class="feedback">
    <h2>Customer Feedback</h2>
    <div class="feedback-carousel">
      <div class="feedback-card">
        <div class="user-img"><img src="images/jane.jpg" alt="Jane"></div>
        <h4>Jane</h4>
        <p>★★★★★</p>
        <p>Absolutely loved our stay!</p>
      </div>

      <div class="feedback-card">
        <div class="user-img"><img src="images/samantha.jpg" alt="Samantha"></div>
        <h4>Samantha</h4>
        <p>★★★★☆</p>
        <p>Great location and service.</p>
      </div>

      <div class="feedback-card">
        <div class="user-img"><img src="images/ravi.jpg" alt="Ravi"></div>
        <h4>Ravi</h4>
        <p>★★★★★</p>
        <p>Wonderful experience overall.</p>
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="newsletter">
    <div class="newsletter-box">
      <h3>Get special offers,<br>and more from Tripzly</h3>
      <input type="email" placeholder="Enter your email">
      <button class="btn">Subscribe</button>
    </div>
  </section>
</div>

<!-- Footer -->
<footer>
  <div class="footer-container">
    <div class="footer-section">
      <h4>Company</h4>
      <ul>
        <li><a href="#">About Tripzly</a></li>
        <li><a href="#">Careers</a></li>
        <li><a href="#">Newsroom</a></li>
      </ul>
    </div>
    <div class="footer-section">
      <h4>Explore</h4>
      <ul>
        <li><a href="#">Stays</a></li>
        <li><a href="#">Attractions</a></li>
        <li><a href="#">Restaurants</a></li>
      </ul>
    </div>
    <div class="footer-section">
      <h4>Help</h4>
      <ul>
        <li><a href="#">Customer Support</a></li>
        <li><a href="#">Terms & Conditions</a></li>
        <li><a href="#">Privacy Policy</a></li>
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

  <script>
    
  
    const selectedAmenities = new Set();


document.addEventListener('DOMContentLoaded', function () {
  // all your event listeners go here
  document.getElementById('searchStaysForm').addEventListener('submit', function (e) {
    e.preventDefault(); 
    applyFilters();    
  });

  document.getElementById('budgetRange').addEventListener('input', applyFilters);

  document.querySelectorAll('.amenity-btn').forEach(button => {
    button.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      if (selectedAmenities.has(id)) {
        selectedAmenities.delete(id);
        this.classList.remove('selected');
      } else {
        selectedAmenities.add(id);
        this.classList.add('selected');
      }
      applyFilters(); 
    });
  });
});

 function applyFilters() {
  const destination = document.getElementById('destination').value;
  const budget = document.getElementById('budgetRange').value;
  const amenities = Array.from(selectedAmenities);

  const checkin = document.getElementById('checkin').value;
  const checkout = document.getElementById('checkout').value;
  const guests = document.querySelector('input[name="guests"]').value;

  const payload = {
    destination,
    budget,
    amenities,
    checkin,
    checkout,
    guests
  };

  fetch('/tripzly_test/search_filter_stays', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
    .then(res => res.json())
    .then(stays => {
      const grid = document.getElementById('stayResults');
      grid.innerHTML = '';

      if (stays.length === 0) {
        grid.innerHTML = '<p>We apologize. There are no stays found that match your filters.</p>';
        return;
      }

      stays.forEach(stay => {
        const card = document.createElement('div');
        card.className = 'stay-card';
        card.innerHTML = `
      <img src="/tripzly_test/${stay.image}" alt="${stay.alt_text || stay.name}" class="stay-image">
    <div class="stay-content">
      <div class="stay-title">${stay.name}</div>
      <div class="stay-type">${stay.property_type}</div>
      <p>Price Per Night: LKR ${Number(stay.price_per_night).toLocaleString()}</p>
      <a href="/tripzly_test/stay/${stay.stay_id}" class="view-button">View Details</a>
    </div>
  `;
        grid.appendChild(card);
      });
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

  </script>
 
</body>
 
</html> 
