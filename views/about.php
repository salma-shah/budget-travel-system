<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="/tripzly_test/views/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us | Tripzly</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      line-height: 1.6;
      background: #ffffff;
      color: #333;
    }

    .about-section {
      padding: 60px 20px;
      background: #ffffff;
      text-align: center;
    }

    .about-container {
      max-width: 1100px;
      margin: 0 auto;
    }

    .about-section h1 {
      font-size: 2.8rem;
      margin-bottom: 20px;
      color: #000266;
    }

    .about-section .intro {
      font-size: 1.2rem;
      margin-bottom: 40px;
      color: #444;
    }

    .about-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
    }

    .about-box {
      background: linear-gradient(135deg, #f0f8ff 0%, #d0e7ff 100%);
      border-radius: 16px;
      padding: 25px;
      box-shadow: 0 8px 20px rgba(0, 92, 191, 0.15);
      text-align: left;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
      cursor: default;
    }

    .about-box:hover {
      transform: translateY(-8px);
      box-shadow: 0 16px 40px rgba(0, 92, 191, 0.25);
    }

    .about-box img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 20px;
      transition: transform 0.4s ease;
    }

    .about-box:hover img {
      transform: scale(1.05);
    }

    .about-box h3 {
      color: #005cbf;
      margin-bottom: 16px;
      font-size: 1.4rem;
      font-weight: 700;
    }

    .about-box ul {
      padding-left: 20px;
      list-style-type: disc;
      color: #555;
      font-size: 1rem;
      line-height: 1.7;
    }

    .about-box p, .about-box li {
      color: #555;
      line-height: 1.7;
      font-size: 1rem;
      font-weight: 400;
    }

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

    @media screen and (max-width: 768px) {
      .nav-links, .nav-buttons {
        display: none;
      }

      .navbar {
        flex-direction: column;
        align-items: flex-start;
      }

      .about-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

   <?php include 'navbar.php'; ?>  

  <!-- About Section -->
  <section class="about-section">
    <div class="about-container">
      <h1>Discover Tripzly</h1>
      <p class="intro">
        Tripzly is your all-in-one travel companion built to empower Sri Lankan travelers to explore, plan, and book their perfect journey on a budget.
      </p>
      <div class="about-grid">
        <div class="about-box">
          <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400" alt="Team">
          <h3>🌍 Who We Are</h3>
          <p>
            We’re a passionate team of travelers, developers, and designers committed to making travel smarter, easier, and more affordable. At Tripzly, we believe travel is for everyone—not just the privileged few.
          </p>
        </div>
        <div class="about-box">
          <img src="https://images.unsplash.com/photo-1500534623283-312aade485b7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400" alt="Mission">
          <h3>🚀 Our Mission</h3>
          <p>
            To make travel planning seamless and transparent. Whether it’s finding a cozy stay in Ella, the best seafood in Galle, or discovering hidden gems in Jaffna, we’re here to make it happen—with just a few clicks.
          </p>
        </div>
        <div class="about-box">
          <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400" alt="What We Offer">
          <h3>🧭 What We Offer</h3>
          <ul>
            <li>Affordable stays and accommodations across Sri Lanka</li>
            <li>Real-time weather and destination data</li>
            <li>Personalized itinerary planning</li>
            <li>Traveler feedback and ratings</li>
            <li>Responsive support for travelers and hosts</li>
          </ul>
        </div>
        <div class="about-box">
          <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=400" alt="Join Us">
          <h3>🤝 Join Our Journey</h3>
          <p>
            Whether you're a traveler or a property owner, Tripzly is built for you. Add your property, book your next adventure, or simply explore Sri Lanka like never before.
          </p>
        </div>
      </div>
    </div>
  </section>
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
</body>
</html>
