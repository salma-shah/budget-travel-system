<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Bookings - Tripzly Business Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f7f9fc;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 14px;
      text-align: center;
      border-bottom: 1px solid #eaeaea;
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
    .confirm-btn { background-color: #2ecc71; color: white; }
    .cancel-btn { background-color: #e74c3c; color: white; }

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      thead {
        display: none;
      }

      tr {
        margin-bottom: 15px;
        border: 1px solid #ccc;
        background: white;
      }

      td {
        padding-left: 50%;
        position: relative;
        text-align: right;
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

  <h1>Manage Bookings</h1>

  <table>
    <thead>
      <tr>
        <th>Booking ID</th>
        <th>Customer</th>
        <th>Customer ID</th>
        <th>Customer Email</th>
        <th>Service</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="userTableBody">
    <?php include 'partials/bookings_rows.php'; ?>  
     <!-- it is going to be populated here -->
    </tbody>
  </table>

  <!-- Booking details modal -->
<div id="bookingDetailsModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2 id="modalBookingTitle">Booking Details</h2>

    <p><strong>Booking ID:</strong> <span id="modalBookingId"></span></p>
    <p><strong>Date of Booking:</strong> <span id="modalBookingDate"></span></p>
    <p><strong>Customer Name:</strong> <span id="modalCustomer"></span></p>
    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
    <p><strong>Category:</strong> <span id="modalCategory"></span></p>
    <p><strong>Name:</strong> <span id="modalName"></span></p>
    <p><strong>Total Cost:</strong> <span id="modalTotalCost"></span></p>
    <p><strong>Booking Start:</strong> <span id="modalBookingStart"></span></p>
    <p><strong>Booking End:</strong> <span id="modalBookingEnd"></span></p>
    <p><strong>Number of Adults:</strong> <span id="modalNumAdults"></span></p>
    <p><strong>Number of Children:</strong> <span id="modalNumChildren"></span></p>
    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
    <p><strong>Payment Status:</strong> <span id="modalPaymentStatus"></span></p>
  </div>
</div>

</body>

<script>

    // approving booking
    function approveBooking(bookingID) {
  if (confirm("Approve booking ID: " + bookingID + "?")) {
    fetch('/tripzly_test/approve_booking', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'bookingID=' + encodeURIComponent(bookingID)
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

// rejecitng booking
    function rejectBooking(bookingID) {
  if (confirm("Reject booking ID: " + bookingID + "?")) {
    fetch('/tripzly_test/reject_booking', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'bookingID=' + encodeURIComponent(bookingID)
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
document.getElementById('modalCustomer').textContent = data.customer_name;
document.getElementById('modalEmail').textContent = data.customer_email;
document.getElementById('modalCategory').textContent = data.bookable_type;
document.getElementById('modalName').textContent = data.details?.name || 'N/A';
document.getElementById('modalTotalCost').textContent = data.total_cost;
document.getElementById('modalBookingStart').textContent = data.booking_start;
document.getElementById('modalBookingEnd').textContent = data.booking_end;
document.getElementById('modalNumAdults').textContent = data.num_of_adults;
document.getElementById('modalNumChildren').textContent = data.num_of_children;
document.getElementById('modalStatus').textContent = data.status;
document.getElementById('modalPaymentStatus').textContent = data.payment_status;

    // showing it
    document.getElementById('bookingDetailsModal').style.display = 'block';
  })
  .catch(error => {
    alert('Error fetching booking details: ' + error);
  });
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


</script>
</html>
