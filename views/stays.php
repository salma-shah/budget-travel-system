<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="/tripzly_test/views/style.css" />
  <title>Stays – Tripzly</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #fff;
      color: #333;
    }

    .stay-section {
      padding: 40px 20px;
    }

    .stay-header {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 30px;
    }

    .stay-container {
      display: flex;
      gap: 30px;
    }

    .stay-filters {
      width: 25%;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 20px;
      align-items: center;
    }

    .filter-button {
      padding: 10px 20px;
      border: 1px solid #003366;
      background-color: transparent;
      color: #003366;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
    }

    .filter-button:hover {
      background-color: #003366;
      color: white;
    }

    /* FIXED SEARCH BOX */
    .search-box {
      display: flex;
      flex-direction: column;
      gap: 10px;
      background-color: white;
      padding: 15px 20px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
      width: 100%;
      box-sizing: border-box;
    }

    .search-box label {
      font-weight: bold;
      font-size: 14px;
      color: #003366;
    }

    .search-box input[type="date"],
    .search-box select {
      width: 100%;
      padding: 8px 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      box-sizing: border-box;
    }
  

    .search-box button {
      padding: 10px;
      background-color: #003366;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
      width: 100%;
      box-sizing: border-box;
    }

    .search-box button:hover {
      background-color: #032546;
    }

    .stay-grid-wrapper {
      width: 75%;
    }

    .stay-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .stay-card {
      background-color: #f9f9f9;
      border-radius: 10px;
      display: flex;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .stay-image {
      width: 120px;
      height: 100%;
      object-fit: cover;
    }

    .stay-content {
      padding: 15px;
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .stay-title {
      font-size: 1.1rem;
      font-weight: bold;
    }

    .stay-type {
      color: #777;
      margin: 5px 0;
    }

    .view-button {
      align-self: flex-start;
      padding: 6px 12px;
      background-color: transparent;
      border: 1px solid #003366;
      color: #003366;
      text-decoration: none;
      font-size: 0.9rem;
      border-radius: 5px;
      transition: 0.3s;
    }

    .view-button:hover {
      background-color: #003366;
      color: white;
    }

    .amenity-btn.selected {
  background-color: #007bff;
  color: white;
}

    @media screen and (max-width: 768px) {
      .stay-container {
        flex-direction: column;
      }

      .stay-filters,
      .stay-grid-wrapper {
        width: 100%;
      }

      .stay-grid {
        grid-template-columns: 1fr;
      }

      .stay-card {
        flex-direction: column;
        align-items: center;
      }

      .stay-image {
        width: 100%;
        height: 180px;
      }

      .stay-content {
        align-items: center;
        text-align: center;
      }

      .view-button {
        margin-top: 10px;
      }
    }

  </style>
</head>
<body>
   <?php include 'navbar.php'; ?>  

  <!-- Stays Section -->
  <section class="stay-section" id="stays-showcase">
    <h2 class="stay-header">Stay where you feel at home</h2>
    <div class="stay-container">

      <!-- Left Filter & Search -->
      <div class="stay-filters">
        <div class="search-box">
          
           <form id="searchStaysForm" class="search-bar">

          <label for="checkin">Check-in:</label>
          <input type="date" id="checkin" name="checkin" required />

          <label for="checkout">Check-out:</label>
          <input type="date" id="checkout" name="checkout" required />

          <label for="adults">Guests:</label>
    <input type="number" name="guests" min="1" />
    <button class="btn" type="submit" id="search">Search</button>

        </div>

        <div class="budget-section">
        <label for="budgetRange">Select Budget Range</label>
         <input 
          type="range" 
          id="budgetRange" 
          min="5000" 
          max="500000" 
          step="5000" 
          oninput="document.getElementById('rangeValue').innerText = 'LKR ' + Number(this.value).toLocaleString()" />
         <p>Budget: <span id="rangeValue">LKR 5,000</span></p>
       </div>

        <h3>Filters</h3>
        <div class="tags">
         <?php foreach ($amenities as $amenity): ?>
    <button type= "button" class="amenity-btn" data-id="<?= htmlspecialchars($amenity->id) ?>">
      <?= htmlspecialchars($amenity->name) ?>
    </button>
  <?php endforeach; ?>  </div>
      </div>

      <!-- Stay Cards -->
      <div class="stay-grid-wrapper" id="stayResults">
    <?php if (!empty($stays)): ?>
      <?php foreach ($stays as $stay): ?>
        <div class="stay-card">
          <img src="/tripzly_test/<?= htmlspecialchars($stay->image ?? '') ?>" 
               alt="<?= htmlspecialchars($stay->alt_text ?? $stay->name) ?>" 
               class="stay-image">
          
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
      </div>
    </div>
  </section>

 
  <script>
    document.getElementById('searchStaysForm').addEventListener('submit', function (e) {
  e.preventDefault(); 
    applyFilters();    
});

    // Show/hide login dropdown
    document.getElementById('loginBtn').addEventListener('click', () => {
      const dropdown = document.getElementById('loginDropdown');
      dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', function(e) {
      const dropdown = document.getElementById('loginDropdown');
      if (!e.target.matches('#loginBtn')) {
        if (dropdown.style.display === 'block') {
          dropdown.style.display = 'none';
        }
      }
    });


  const selectedAmenities = new Set();

  // toggle amenity selection
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

  document.getElementById('budgetRange').addEventListener('input', applyFilters);

 function applyFilters() {
  const budget = document.getElementById('budgetRange').value;
  const amenities = Array.from(selectedAmenities);

  const checkin = document.getElementById('checkin').value;
  const checkout = document.getElementById('checkout').value;
  const guests = document.querySelector('input[name="guests"]').value;

  const payload = {
    budget,
    amenities,
    checkin,
    checkout,
    guests
  };

  fetch('/tripzly_test/filter_stays', {
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
