<?php 
    include_once __DIR__ . '/../helpers/session_helper.php';
    if (!isset($_SESSION['userId']) || !isset($_SESSION['name'])) {
    header("Location: ../views/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tripzly | User Profile</title>
  
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Poppins', sans-serif;
      display: flex;
      background-color: #f7f7f7;
      min-height: 100vh;
      color: #333;
    }

    .sidebar {
      width: 250px;
      background-color: #003366;
      color: white;
      padding: 2rem 1.5rem;
      display: flex;
      flex-direction: column;
      position: fixed;
      height: 100vh;
      left: 0;
      top: 0;
    }

    .sidebar h2 {
      font-size: 1.5rem;
      margin-bottom: 2rem;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      margin-bottom: 1rem;
      display: block;
      font-weight: 500;
      padding: 0.75rem 1rem;
      border-radius: 6px;
      transition: background 0.3s;
      cursor: pointer;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #000266;
    }

    .main {
      margin-left: 250px;
      padding: 2rem 3rem;
      flex: 1;
      max-width: 800px;
    }

    section {
      margin-bottom: 4rem;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      padding: 2rem;
    }

    h1, h2, h3 {
      color: #003366;
      margin-bottom: 1rem;
    }

    /* Profile Section */
    .profile-header {
      display: flex;
      align-items: center;
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .profile-photo {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-color: #b3d6ff;
      background-image: url('https://via.placeholder.com/100');
      background-size: cover;
      background-position: center;
      border: 3px solid #003366;
    }

    .profile-name {
      font-size: 1.8rem;
      font-weight: 600;
      color: #003366;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    label {
      font-weight: 600;
      color: #003366;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"] {
      padding: 0.6rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      width: 100%;
    }

    .btn {
      align-self: flex-start;
      background-color: #003366;
      color: white;
      padding: 0.6rem 1.2rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #000266;
    }

    /* Dashboard Cards */
    .dashboard-cards {
      display: flex;
      gap: 1.5rem;
      flex-wrap: wrap;
    }
    .card {
      flex: 1 1 250px;
      background-color: #e6f0ff;
      padding: 1rem 1.5rem;
      border-radius: 8px;
      box-shadow: inset 0 0 10px #cce0ff;
      color: #003366;
    }
    .card h3 {
      margin-bottom: 0.5rem;
    }
    .card p {
      font-size: 1.25rem;
      font-weight: 600;
    }

    /* Trips List */
    .trip-list {
      list-style: none;
      padding-left: 0;
    }
    .trip-list li {
      border-bottom: 1px solid #ccc;
      padding: 0.75rem 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .trip-list li:last-child {
      border-bottom: none;
    }
    .trip-destination {
      font-weight: 600;
      color: #003366;
    }
    .trip-date {
      font-size: 0.9rem;
      color: #666;
    }
    .btn-small {
      padding: 0.3rem 0.7rem;
      font-size: 0.85rem;
      border-radius: 4px;
      background-color: #003366;
      color: white;
      border: none;
      cursor: pointer;
      transition: background 0.3s;
    }
    .btn-small:hover {
      background-color: #000266;
    }

    /* Messages */
    .message {
      border-bottom: 1px solid #ddd;
      padding: 1rem 0;
    }
    .message:last-child {
      border-bottom: none;
    }
    .message-header {
      display: flex;
      justify-content: space-between;
      font-weight: 600;
      color: #003366;
      margin-bottom: 0.25rem;
    }
    .message-body {
      color: #555;
    }

    /* Settings Form */
    .settings-form label {
      display: block;
      margin-bottom: 0.3rem;
    }
    .settings-form input[type="checkbox"] {
      margin-right: 0.5rem;
      vertical-align: middle;
    }
    .settings-form div {
      margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        flex-direction: row;
        justify-content: space-around;
        padding: 1rem 0.5rem;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
      }

      .main {
        margin-left: 0;
        padding: 5rem 1.5rem 2rem; /* top padding for fixed sidebar */
        max-width: 100%;
      }

      .sidebar h2 {
        display: none;
      }

      .sidebar a {
        padding: 0.5rem;
        margin: 0.3rem;
      }

      .profile-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
      }
    }

    .modal {
  display: none; 
  position: fixed; 
  z-index: 9999; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgba(0, 0, 0, 0.5); 
}

.modal-content {
  background-color: #fff;
  margin: 10% auto; 
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  position: relative;
}

.close-btn {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close-btn:hover {
  color: #000;
}
  </style>
</head>
<body>

  <div class="sidebar" id="sidebar">
    <h2>Tripzly</h2>
    <a href="/tripzly_test/home">Home</a>
    <a href="#my-profile" class="active">My Profile</a>
    <a href="#dashboard">Dashboard</a>
    <a href="#my-trips">My Trips</a>
    <a href="#messages">Messages</a>
    <a href="#settings">Settings</a>
    <a href="#" id="logout-link" onclick="confirmLogout()">Logout</a>
  </div>

  <div class="main">

    <section id="my-profile">
      <h2>My Profile</h2>

      <div class="main">
  <section id="my-profile">
    <h2>My Profile</h2>

    <div class="profile-header">
      <div class="profile-photo" id="profilePhoto"></div>
      <div>
        <div class="profile-name"><?= htmlspecialchars($user->name) ?></div>
        <button type="button" id="changePhotoBtn" class="btn" style="margin-top: 0.5rem; padding: 0.3rem 0.8rem; font-size: 0.9rem;">Change Photo</button>
        <input type="file" id="photoInput" accept="image/*" style="display:none" />
      </div>
    </div>

    <form method="POST" action="/tripzly_test/update_user_details">
      <label for="fullName">Full Name</label>
      <input type="text" id="fullName" name="fullName" value="<?= htmlspecialchars($user->name) ?>" />

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->email) ?>" />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" value="●●●●●●●●●" />

      <label for="phone">Contact Number</label>
      <input type="tel" id="contactNumber" name="contactNumber" value="<?= htmlspecialchars($user->contact_number) ?>" />

      <label for="location">Address</label>
      <input type="text" id="location" name="address" value="<?= htmlspecialchars($user->address) ?>" />

      <button type="submit" class="btn">Save Changes</button>
    </form>
  </section>

    <section id="dashboard">
      <h1>Dashboard</h1>
      <div class="dashboard-cards">
        <div class="card">
          <h3>Upcoming Trips</h3>
           <p><?= $bookingsCount['Confirmed'] ?? 0 ?></p>
        </div>
        <div class="card">
          <h3>Pending Bookings</h3>
           <p><?= $bookingsCount['Pending'] ?? 0 ?></p>
        </div>
        <div class="card">
          <h3>Completed Trips</h3>
           <p><?= $bookingsCount['Completed'] ?? 0 ?></p>
        </div>
        <div class="card">
          <h3>Total Bookings</h3>
          <p><?= $total ?></p>
        </div>

      </div>
      <p style="margin-top:1.5rem;">Welcome back, <strong><?= htmlspecialchars($user->name) ?></strong>! Here's a quick overview of your recent activity.</p>
    </section>

    <section id="my-trips">
      <h2>My Trips</h2>
<ul class="trip-list">
  <?php if (!empty($bookings)): ?>
  <?php foreach ($bookings as $b): ?>
    <li>
      <div>
        <span class="trip-destination"><?= htmlspecialchars($b->destination_name) ?></span><br />
        <strong><?= htmlspecialchars($b->item_name) ?> (<?= $b->bookable_type ?>)</strong><br>
        <span>Status: <?= ucfirst($b->status) ?></span><br>
        <span>From <?= $b->booking_start ?> to <?= $b->booking_end ?></span>
      </div>
      <button class="btn-small" onClick="viewBooking(<?= $b->booking_id ?>)">View Details</button>
    </li>
  <?php endforeach; ?>
  <?php else: ?>
  <li>No bookings found.</li>
<?php endif; ?>
</ul>

      <button class="btn" style="margin-top: 1rem;">Plan New Trip</button>
    </section>

    <!-- Booking details modal -->
<div id="bookingDetailsModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2 id="modalBookingTitle">Booking Details</h2>

    <p><strong>Booking ID:</strong> <span id="modalBookingId"></span></p>
    <p><strong>Date of Booking:</strong> <span id="modalBookingDate"></span></p>
    <p><strong>Category:</strong> <span id="modalCategory"></span></p>
    <p><strong>Name of Service:</strong> <span id="modalName"></span></p>
    <p><strong>Total Cost:</strong> <span id="modalTotalCost"></span></p>
    <p><strong>Booking Start:</strong> <span id="modalBookingStart"></span></p>
    <p><strong>Booking End:</strong> <span id="modalBookingEnd"></span></p>
    <p><strong>Number of Adults:</strong> <span id="modalNumAdults"></span></p>
    <p><strong>Number of Children:</strong> <span id="modalNumChildren"></span></p>
    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
    <p><strong>Payment Status:</strong> <span id="modalPaymentStatus"></span></p>
    
    <button id="makePaymentBtn" style="display: none;" onclick="redirectToPayment()">Make Payment</button>

  </div>
</div>

    <section id="settings">
      <h2>Settings</h2>
      <form class="settings-form">
        <div>
          <label><input type="checkbox" checked /> Email Notifications</label>
        </div>
        <div>
          <label><input type="checkbox" /> SMS Alerts</label>
        </div>
        <div>
          <label><input type="checkbox" checked /> Newsletter Subscription</label>
        </div>
        <button type="submit" class="btn">Save Settings</button>
      </form>
    </section>

  </div>

  <script>
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.sidebar a[href^="#"]');

    function updateActiveLink() {
      let current = '';
      sections.forEach(section => {
        const sectionTop = section.offsetTop - 100;
        if (pageYOffset >= sectionTop) {
          current = section.getAttribute('id');
        }
      });

      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + current) {
          link.classList.add('active');
        }
      });
    }

    window.addEventListener('scroll', updateActiveLink);
    window.addEventListener('load', updateActiveLink);

    // Profile photo change logic
    const profilePhoto = document.getElementById('profilePhoto');
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const photoInput = document.getElementById('photoInput');

    changePhotoBtn.addEventListener('click', () => {
      photoInput.click();
    });

    photoInput.addEventListener('change', () => {
      const file = photoInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          profilePhoto.style.backgroundImage = `url(${e.target.result})`;
        };
        reader.readAsDataURL(file);
      }
    });

    // viewing booking details
  function viewBooking(bookingID) {
  fetch('/tripzly_test/booking_details', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'bookingID=' + encodeURIComponent(bookingID),
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      alert(data.error);
      return;
    }

    // getting data and filling modal fields
document.getElementById('modalBookingId').textContent = data.booking_id;
document.getElementById('modalBookingDate').textContent = data.booking_date;
document.getElementById('modalCategory').textContent = data.bookable_type;
document.getElementById('modalName').textContent = data.details.name || 'N/A';
document.getElementById('modalTotalCost').textContent = data.total_cost;
document.getElementById('modalBookingStart').textContent = data.booking_start;
document.getElementById('modalBookingEnd').textContent = data.booking_end;
document.getElementById('modalNumAdults').textContent = data.num_of_adults;
document.getElementById('modalNumChildren').textContent = data.num_of_children;
document.getElementById('modalStatus').textContent = data.status;
document.getElementById('modalPaymentStatus').textContent = data.payment_status;

// checking if make payment btn should be shown
if (data.payment_status != 'Paid' && data.status == 'Confirmed')
{
  const paymentBtn = document.getElementById('makePaymentBtn');
  paymentBtn.style.display = 'inline-block';
  paymentBtn.dataset.bookingId = data.booking_id;
  paymentBtn.dataset.totalCost = data.total_cost;
}
else 
  {  // showing it wirhout btn
    document.getElementById('makePaymentBtn').style.display = 'none';
  }

   document.getElementById('bookingDetailsModal').style.display = 'block';

  })
  .catch(error => {
    alert('Error fetching booking details: ' + error);
  });
}

function redirectToPayment() {
  const btn = document.getElementById('makePaymentBtn');
  const bookingId = btn.dataset.bookingId;
  const totalCost = btn.dataset.totalCost;

  // redirect to  payment page 
  window.location.href = `/tripzly_test/payment_form?booking_id=${bookingId}&amount=${totalCost}`;
}


function openModal() {
  document.getElementById('bookingDetailsModal').style.display = 'block';
}
function closeModal() {
  document.getElementById('bookingDetailsModal').style.display = 'none';
}
window.onclick = function(event) {
  const modal = document.getElementById('bookingDetailsModal');
  if (event.target === modal) closeModal();
}

    function confirmLogout() {
      if (confirm("Are you sure you want to logout?")) {
        window.location.href = "/tripzly_test/logout" 
      }
    }
  </script>

</body>
</html>
