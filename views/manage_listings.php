<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tripzly Admin - Manage Listings</title>
  <style>

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9fafa;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #2c3e50;
    }

    .search-box {
      max-width: 400px;
      margin: 20px auto;
    }

    .search-box input {
      width: 100%;
      padding: 10px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #eee;
      font-size: 14px;
    }

    th {
      background-color: #3498db;
      color: white;
    }

    .action-btn {
      padding: 6px 10px;
      margin: 2px;
      font-size: 13px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .view-btn { background-color: #00bcd4; color: white; }
    .approve-btn { background-color: #2ecc71; color: white; }
    .reject-btn { background-color: #e67e22; color: white; }
    .delete-btn { background-color: #e74c3c; color: white; }

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      thead {
        display: none;
      }

      tr {
        background-color: white;
        margin-bottom: 15px;
        border: 1px solid #ccc;
      }

      td {
        text-align: right;
        padding-left: 50%;
        position: relative;
        border: none;
        border-bottom: 1px solid #eee;
      }

      td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        font-weight: bold;
        text-align: left;
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

  <h1>Manage Listings - Tripzly</h1>

  <div class="search-box">
    <input type="text" id="searchListing" placeholder="Search listings by title or business name..." />
  </div>

  <table>
    <thead>
      <tr>
        <th>Listing ID</th>
        <th>Category</th>
        <th>Title</th>
        <th>Business Name</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
     <tbody id="userTableBody">
    <?php include 'partials/listings_rows.php'; ?>  
     <!-- it is going to be populated here -->
  </tbody>
  </table>

  <!-- Your modal -->
<div id="listingDetailsModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2 id="modalListingTitle">Listing Details</h2>
    <p><strong>Listing ID:</strong> <span id="modalListingId"></span></p>
    <p><strong>Category:</strong> <span id="modalCategory"></span></p>
    <p><strong>Name:</strong> <span id="modalName"></span></p>
    <p><strong>Business Name:</strong> <span id="modalBusinessName"></span></p>
    <p><strong>Contacts:</strong> <span id="modalContacts"></span></p>
    <p><strong>Address:</strong> <span id="modalAddress"></span></p>
    <p><strong>Description:</strong> <span id="modalDesc"></span></p>
    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
  </div>
</div>

<!-- JS -->
<script>
function openModal() {
  document.getElementById('listingDetailsModal').style.display = 'block';
}
function closeModal() {
  document.getElementById('listingDetailsModal').style.display = 'none';
}
window.onclick = function(event) {
  const modal = document.getElementById('listingDetailsModal');
  if (event.target === modal) closeModal();
}
</script>


<!--JS script functions-->
  <script>

    // search function
     document.getElementById('searchListing').addEventListener('input', function () {
    const searchTerm = this.value;

    fetch('/tripzly_test/search_listings', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'search=' + encodeURIComponent(searchTerm)
    })
    .then(res => res.text())
    .then(html => {
      document.getElementById('userTableBody').innerHTML = html;
    })
    .catch(err => console.error('Search error:', err));
  });

  // delete a listinf function
     function deleteListing(listingID) {
      if (confirm("Are you sure you want to permanently delete listing ID: " + listingID + "?")) {
      
        fetch('/tripzly_test/delete_listing', {
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
  fetch('/tripzly_test/listing_details', {
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
    document.getElementById('modalListingId').textContent = data.id;
    document.getElementById('modalCategory').textContent = data.listable_type;
    document.getElementById('modalBusinessName').textContent = data.business_name || 'N/A';
    document.getElementById('modalStatus').textContent = data.details.status || 'Pending';
    document.getElementById('modalName').textContent = data.details.name || 'Untitled';
    document.getElementById('modalAddress').textContent = data.details.address;
    document.getElementById('modalDesc').textContent = data.details.description;
    document.getElementById('modalContacts').textContent = data.details.contacts;

    // showing it
    document.getElementById('listingDetailsModal').style.display = 'block';
  })
  .catch(error => {
    alert('Error fetching listing details: ' + error);
  });
}

function closeModal() {
  document.getElementById('listingDetailsModal').style.display = 'none';
}


    // approving listings
    function approveListing(listingID) {
  if (confirm("Approve listing ID: " + listingID + "?")) {
    fetch('/tripzly_test/approve_listing', {
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

    // rejecitng listings
    function rejectListing(listingID) {
  if (confirm("Reject listing ID: " + listingID + "?")) {
    fetch('/tripzly_test/reject_listing', {
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

  </script>

</body>
</html>
