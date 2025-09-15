<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="/tripzly_test/views/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us | Tripzly</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      line-height: 1.6;
      background: #fefefe;
      color: #333;
    }

    /* Contact Section */
    .contact-section {
      display: flex;
      flex-wrap: wrap;
      padding: 60px 20px;
      background: #fff;
      gap: 40px;
      justify-content: center;
    }

    .contact-form {
      flex: 1;
      min-width: 300px;
      max-width: 500px;
    }
  
    .contact-form h2 {
      color: #003366;
      margin-bottom: 20px;
    }

    .contact-form form input,
    .contact-form form textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-family: inherit;
    }

    .contact-form form button {
      background-color: #003366;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 1rem;
      border-radius: 5px;
      cursor: pointer;
    }

    .contact-form form button:hover {
      background-color: #1c5690;
    }

    .contact-image {
      flex: 1;
      min-width: 300px;
      max-width: 500px;
    }

    .contact-image img {
      width: 100%;
      border-radius: 10px;
    }

    .map-section {
      width: 100%;
      padding: 0 20px 60px;
    }

    .map-section iframe {
      width: 100%;
      height: 350px;
      border: none;
      border-radius: 10px;
    }

    /* Footer */
    footer {
      background-color: #222;
      color: #fff;
      padding: 40px 20px 20px;
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

      .contact-section {
        flex-direction: column;
        align-items: center;
      }

      .contact-image img {
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>

 <?php include 'navbar.php'; ?>  

  <!-- Contact Section -->
  <section class="contact-section">
    <div class="contact-form">
      <h2>Contact Tripzly</h2>
      <p>Have questions, suggestions, or feedback? We’d love to hear from you!</p>
      <?php flash('contact')?>
      <form method= "POST" action="/tripzly_test/submit_query" >
        <input type="text" name="name" placeholder="Your Name" required/>
        <input type="email" name="email" placeholder="Your Email" required/>
        <textarea name="subject" rows="6" placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>
    <div class="contact-image">
      <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=80" alt="Tripzly Contact"/>
    </div>
  </section>

  <!-- Map -->
  <div class="map-section">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126740.5833704601!2d79.773663!3d6.9270799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2596f53f64b09%3A0x6c12d129635c620f!2sColombo!5e0!3m2!1sen!2slk!4v1600000000000" allowfullscreen="" loading="lazy"></iframe>
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
