<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="/tripzly_test/views/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Top Sri Lankan Restaurants | Tripzly</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      line-height: 1.6;
      background: #f9f9f9;
      color: #333;
    }

    
    /* Page Title */
    h1 {
      text-align: center;
      color: #000266;
      margin: 40px 20px 20px;
      font-size: 2.8rem;
      font-weight: 700;
    }

    /* Grid Container */
    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      max-width: 1100px;
      margin: 0 auto 60px;
      padding: 0 20px;
    }

    /* Restaurant Card */
    .restaurant-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(230, 81, 0, 0.1);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .restaurant-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 30px rgba(230, 81, 0, 0.2);
    }

    .restaurant-image {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-bottom: 3px solid #000266;
      transition: transform 0.4s ease;
    }

    .restaurant-card:hover .restaurant-image {
      transform: scale(1.05);
    }

    .restaurant-content {
      padding: 15px 20px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .restaurant-name {
      font-weight: 700;
      font-size: 1.2rem;
      color: #000266;
      margin-bottom: 5px;
    }

    .restaurant-location {
      font-size: 0.9rem;
      color: #777;
      margin-bottom: 12px;
      font-style: italic;
    }

    .btn-view {
      display: inline-block;
      padding: 7px 15px;
      background-color: #000266;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: 600;
      transition: background-color 0.3s ease;
      align-self: flex-start;
    }

    .btn-view:hover {
      background-color: #000266;
    }

    /* Footer */
    footer {
      background-color: #222;
      color: #fff;
      padding: 40px 20px 20px;
      margin-top: 60px;
    }

    .footer-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      max-width: 1200px;
      margin: 0 auto;
      gap: 20px;
    }

    .footer-section {
      flex: 1;
      min-width: 200px;
    }

    .footer-section h4 {
      color: #468ed5;
      margin-bottom: 10px;
      font-size: 1.2rem;
    }

    .footer-section ul {
      list-style: none;
      padding: 0;
    }

    .footer-section ul li {
      margin-bottom: 10px;
    }

    .footer-section ul li a {
      color: #ccc;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .footer-section ul li a:hover {
      color: #fff;
    }

    .footer-bottom {
      text-align: center;
      margin-top: 30px;
      border-top: 1px solid #444;
      padding-top: 15px;
      font-size: 0.9rem;
      color: #aaa;
    }

    /* Responsive */
    @media screen and (max-width: 768px) {
      .nav-links, .nav-buttons {
        display: none;
      }

      .navbar {
        flex-direction: column;
        align-items: flex-start;
      }

      .grid-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <?php include 'navbar.php'; ?>  

  <!-- Page Title -->
  <h1>Charming Cafes & Restaurants of Sri Lanka</h1>

  <!-- Restaurants Grid -->
  <div class="grid-container">
    <?php if (!empty($restaurants)): ?>
  <?php foreach ($restaurants as $r): ?>
    <div class="restaurant-card"> 
      <img class="restaurant-image" src="/tripzly_test/<?= htmlspecialchars($r->image) ?>" alt="<?= htmlspecialchars($r->alt_text ?? 'Restaurant Image') ?>" />
      <div class="restaurant-content">
        <div class="restaurant-name"><?= htmlspecialchars($r->name) ?></div>
        <div class="restaurant-location"><?= htmlspecialchars($r->address) ?></div>
        <a href="/tripzly_test/restaurant/<?= urlencode($r->restaurant_id) ?>"class="btn-view">View More Details</a>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>No restaurants available.</p>
<?php endif; ?>


  </div>

   <script>
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

</body>
</html>
