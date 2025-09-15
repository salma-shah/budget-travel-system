<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tripzly | Business Dashboard</title>
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
      background-color: #f4f4f4;
      display: flex;
      min-height: 100vh;
      color: #333;
    }

    .sidebar {
      width: 250px;
      background-color: #160066;
      color: white;
      display: flex;
      flex-direction: column;
      padding: 2rem 1.5rem;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      overflow-y: auto;
    }

    .sidebar h2 {
      margin-bottom: 2rem;
      font-size: 1.5rem;
    }

    .sidebar a {
      text-decoration: none;
      color: white;
      margin-bottom: 1rem;
      display: block;
      font-weight: 500;
      padding: 0.75rem 1rem;
      border-radius: 6px;
      transition: background 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #001eb3;
    }

    .main {
      margin-left: 250px;
      flex: 1;
      padding: 2rem 3rem;
    }

    .main h1 {
      font-size: 2rem;
      color: #003366;
      margin-bottom: 1.5rem;
    }

    .card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
      padding: 2rem;
      margin-bottom: 2rem;
    }

    .card h3 {
      margin-bottom: 1rem;
      color: #003366;
      font-size: 1.2rem;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem 2rem;
    }

    .info-item {
      font-size: 0.95rem;
      padding: 0.5rem 0;
    }

    .info-item .label {
      font-weight: 600;
      color: #444;
      display: block;
      margin-bottom: 4px;
    }

    input[type="text"],
    input[type="email"],
    textarea {
      width: 100%;
      padding: 0.5rem;
      margin-top: 0.25rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-family: 'Poppins', sans-serif;
      font-size: 0.95rem;
    }

    textarea {
      resize: vertical;
    }

    .btn-group {
      margin-top: 1.5rem;
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .btn {
      background-color: #003366;
      color: white;
      padding: 0.75rem 1.25rem;
      border: none;
      border-radius: 6px;
      font-size: 0.95rem;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #001299;
    }

    .listings-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
      margin-top: 1.5rem;
    }

    .listing-card {
      border: 1px solid #ddd;
      padding: 1rem;
      border-radius: 8px;
      background-color: #fafafa;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .listing-card h4 {
      margin-bottom: 0.5rem;
      color: #003366;
    }

    .listing-card p {
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
      .info-grid {
        grid-template-columns: 1fr;
      }

      .main {
        margin-left: 0;
        padding: 1.5rem;
      }

      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        flex-direction: row;
        justify-content: space-around;
      }

      .sidebar h2 {
        display: none;
      }

      .sidebar a {
        margin: 0.5rem;
        padding: 0.5rem;
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

  <div class="sidebar">
    <h2>Tripzly Business</h2>
    <a href="#profile">Profile</a>
    <a href="#add-property">Add Property</a>
    <a href="#my-listings">My Listings</a>
    <a href="#bookings">Bookings</a>
    <a href="#support">Support</a>
    <a href="#" onclick="logout()">Logout</a>
  </div>

  <div class="main">

    <section id="profile">
      <div class="card">
        <h3>Business Profile</h3>
        <form id="profileForm" method="POST" action="/tripzly_test/update_business_details">
          <div class="info-grid">
           <label class="label">Name:</label>
  <input type="text" name="name" value="<?= htmlspecialchars($business->name ?? '') ?>" />
</div>

<div class="info-item">
  <label class="label">Email:</label>
  <input type="email" name="email" value="<?= htmlspecialchars($business->email ?? '') ?>" />
</div>

<div class="info-item">
  <label class="label">Phone:</label>
  <input type="text" name="contactNumber" value="<?= htmlspecialchars($business->contact_number ?? '') ?>" />
</div>

<div class="info-item">
  <label class="label">Address:</label>
  <input type="text" name="address" value="<?= htmlspecialchars($business->address ?? '') ?>" /><div class="info-item"><label class="label">Operational Hours:</label><input type="text" name="hours" value="24/7" /></div>
            <div class="info-item"><label class="label">Social:</label><input type="text" name="social" value="Facebook | Instagram | LinkedIn" /></div>
            </div>
          <div class="btn-group"><button type="submit" class="btn">Save Changes</button></div>
          <?php flash('business_profile'); ?>

        </form>
      </div>
    </section>

    <section id="add-property">
      <div class="card">
        <h3>Add Property</h3>
        <p>Add and list new properties.</p>
        <div class="btn-group">
          <button class="btn" onclick="location.href='/tripzly_test/add_listing'">List New Property</button>
        </div>
      </div>
  
    </section>

    <section id="my-listings">
      <div class="card">
        <h3>My Property Listings</h3>
        <p>Manage and update all your listed properties.</p>
        <div class="listings-grid">

       <?php foreach ($listings as $listing): ?>
  <div class="listing-card">
    <h4><?= htmlspecialchars($listing->name) ?> (<?= ucfirst($listing->listable_type) ?>)</h4>
    <div class="btn-group">
      <button class="btn" onclick="viewListing(<?= $listing->id ?>)">Edit</button>
      <button class="btn" onclick="deleteListing(<?= $listing->id ?>)">Delete</button>
    </div>
  </div>
<?php endforeach; ?>          
          </div>

        </div>
      </div>
    </section>

    <!-- Listing details modal -->
<div id="listingDetailsModal" class="modal hidden">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2 id="modalListingTitle">Listing Details</h2>
<p><strong>ID:</strong> <span id="visibleListingId"></span></p>
<input type="hidden" id="modalListingId" />

 <p><strong>Category:</strong> <span id="modalCategory"></span></p>
    <p><strong>Status:</strong> <span id="modalStatus"></span></p>

     <label>Name:</label>
     <input type="text" id="modalName">
      <label>Address:</label>
     <input type="text" id="modalAddress">
      <label>Description:</label>
     <input type="text" id="modalDesc">
      <label>Contacts:</label>
     <input type="text" id="modalContacts">
      <label>Open From:</label>
     <input type="text" id="modalOpenFrom">
      <label>Open To:</label>
     <input type="text" id="modalOpenTo">


     <button onclick="updateListing()">Update Listing</button>
  </div>
</div>


    <section id="bookings">
      <div class="card">
        <h3>Manage Bookings</h3>
        <p>Track and manage all your bookings.</p>
        <div class="btn-group">
          <button class="btn" onclick="location.href='/tripzly_test/manage_bookings'">Go to Bookings</button>
        </div>
      </div>
    </section>

    <section id="support">
      <div class="card">
        <h3>Support</h3>
        <p>Need help? Reach out to our support team.</p>
        <div class="btn-group">
          <button class="btn" onclick="location.href='/tripzly_test/contact_support'">Contact Support</button>
        </div>
      </div>
    </section>

  </div>

  <script>
    function logout() {
      alert("You have been logged out successfully.");
       window.location.href = "/tripzly_test/logout";
    }

    // delete a listinf function
     function deleteListing(listingID) {
      if (confirm("Are you sure you want to permanently delete listing ID: " + listingID + "?")) {
      
        fetch('/tripzly_test/delete_business_listing', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'listingID=' + encodeURIComponent(listingID)
    })
    .then(response => response.text())
    .then(data => {
      alert(data);
      location.reload(); 
    })
    .catch(error => {
      alert('Error: ' + error);
    });
  }
    }


     // view a listing details in a modal function
    function viewListing(listingId) {
  fetch('/tripzly_test/listing/view', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'listingID=' + encodeURIComponent(listingId),
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      alert(data.error);
      return;
    }

    // getting data and filling modal fields
    document.getElementById('modalListingTitle').textContent = data.details.name || 'Listing Details';
    document.getElementById('modalListingId').value = data.listable_id;
    document.getElementById('visibleListingId').textContent = data.listable_sid;
    document.getElementById('modalCategory').textContent = data.listable_type || 'N/A';
    document.getElementById('modalStatus').textContent = data.details.status || 'Pending';
    document.getElementById('modalName').value = data.details.name || 'Untitled';
    document.getElementById('modalAddress').value = data.details.address;
    document.getElementById('modalDesc').value = data.details.description;
    document.getElementById('modalContacts').value = data.details.contacts;
    document.getElementById('modalOpenFrom').value = data.details.open_from || 'N/a';
    document.getElementById('modalOpenTo').value = data.details.open_to || 'N/A';

    
    // showing it
    document.getElementById('listingDetailsModal').style.display = 'block';
  })
  .catch(error => {
    alert('Error fetching listing details: ' + error);
  });
}

// updating a listing
function updateListing(listingId) {
  const updatedData = {
    id: document.getElementById('modalListingId').value,
    name: document.getElementById('modalName').value,
    type: document.getElementById('modalCategory').textContent,
    address: document.getElementById('modalAddress').value,
    description: document.getElementById('modalDesc').value,
    contacts: document.getElementById('modalContacts').value,
 open_from: document.getElementById('modalOpenFrom').value,
    open_to: document.getElementById('modalOpenTo').value
  };

  fetch('/tripzly_test/listing/update', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
     body: JSON.stringify(updatedData),
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Listing updated successfully!');
      closeModal();
      location.reload(); 
    } else {
      alert('Update failed: ' + data.error);
    }
  })
  .catch(err => {
    console.error(err);
    alert('Error updating listing.');
  });
}


function closeModal() {
  document.getElementById('listingDetailsModal').style.display = 'none';
}

  </script>

</body>
</html>
