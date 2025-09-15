<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/tripzly_test/views/style.css" />
  <title>Tripzly - Packages</title>
<style>
  
  html, body {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
  }

  .page-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  .container {
    flex: 1;
    padding: 20px;
  }

  h1 {
    text-align: center;
    color: #003366;
    margin-bottom: 30px;
  }

  .package-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
  }

  .package-card {
    border: 1px solid #ccc;
    border-radius: 10px;
    overflow: hidden;
    background-color: #f9f9f9;
  }

  .package-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }

  .package-content {
    padding: 15px;
  }

  .package-content h3 {
    margin-top: 0;
    color: #007acc;
  }

  .package-content p {
    margin: 10px 0;
  }
   
  .package-content button {
    background-color: #003366;
    color: white;
    border: none;
    padding: 10px 14px;
    cursor: pointer;
    border-radius: 5px;
  }

  .details-btn {
  display: inline-block;
  background-color: #003366;
  color: white;
  text-decoration: none;
  padding: 10px 14px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.details-btn:hover {
  background-color: #005599;
}

</style>

</head>
<body>
  <div class="page-wrapper">

    <?php include 'navbar.php'; ?>  

    <!-- Page Content -->
    <div class="container">
      <h1>Our Exclusive Tour Packages</h1>

    <?php if (!empty($tours)): ?>
  <?php foreach ($tours as $t): ?>
    <div class="package-card">
      <img src="/tripzly_test/<?= htmlspecialchars($t->image ?: 'images/default.jpg') ?>" alt="<?= htmlspecialchars($t->alt_text ?: 'Tour Package') ?>" />
      <div class="package-content">
        <h3><?= htmlspecialchars($t->name) ?></h3>
    <p><li><?= htmlspecialchars(trim(explode('/', $t->description)[0])) ?></li></p>
        <p><strong>Price:</strong> LKR <?= number_format($t->price_per_adult) ?></p>
        <a href="/tripzly_test/tour/<?= urlencode($t->tour_id) ?>" class="details-btn">View Details</a>
         <!-- we are passing the id of the item here so we can retrieve its details -->
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>No packages available.</p>
<?php endif; ?>


  </div>
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
  </div>
</body>
</html>
