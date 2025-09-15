<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tripzly | List Your Property or Restaurant</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background: #fff;
      color: #333;
      margin: 0;
      padding: 0;
    }
    .navbar {
      background-color: #003366;
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 3px 8px rgba(112, 105, 245, 0.811);
    }
    .navbar h1 {
      margin: 0;
      font-weight: 600;
      letter-spacing: 1.5px;
      font-size: 1.5rem;
      user-select: none;
    }
    .navbar a {
      color: white;
      font-weight: 600;
      text-decoration: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      transition: background-color 0.3s;
    }
    .navbar a:hover {
      background-color: rgba(112, 105, 245, 0.811);
    }

    main {
      max-width: 700px;
      margin: 3rem auto 4rem auto;
      padding: 2rem;
      box-shadow: 0 4px 15px rgba(112, 105, 245, 0.811);
      border-radius: 10px;
      background: #fff;
    }

    h2 {
      color: #003366;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .selector {
      display: flex;
      justify-content: center;
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .selector button {
      padding: 0.8rem 2rem;
      font-weight: 600;
      font-size: 1rem;
      border: 2px solid #003366;
      border-radius: 8px;
      background: white;
      color: #003366;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .selector button.active,
    .selector button:hover {
      background-color: #003366;
      color: white;
    }

    form {
      display: none;
      flex-direction: column;
      gap: 1.3rem;
    }

    form.active {
      display: flex;
    }

    label {
      font-weight: 600;
      margin-bottom: 0.3rem;
    }

    input[type="text"],
    input[type="number"],
    input[type="url"],
    textarea,
    select {
      padding: 0.8rem 1rem;
      border: 2px solid #003366;
      border-radius: 8px;
      font-size: 1rem;
      font-family: inherit;
      resize: vertical;
    }

    textarea {
      min-height: 100px;
    }

    button[type="submit"] {
      background-color: #003366;
      color: white;
      font-weight: 700;
      padding: 1rem;
      border: none;
      border-radius: 10px;
      font-size: 1.2rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-top: 1rem;
    }

    button[type="submit"]:hover {
      background-color: #001f4d;
    }
  </style>
</head>
<body>

  <nav class="navbar">
    <h1>Tripzly - List Your Property or Restaurant</h1>
    <a href="/tripzly_test/business_dashboard">Back to Dashboard</a>
  </nav>

  <main>
    <div class="selector">
      <button id="propertyBtn" class="active">List Property</button>
      <button id="restaurantBtn">List Restaurant</button>
    </div>

    <!-- Property Form -->
    <form id="propertyForm" action="/tripzly_test/listing/add" method="POST" enctype="multipart/form-data" class="active">
      <h2>List Your Property</h2>

      <label for="propertyName">Property Name *</label>
      <input type="text" id="propertyName" name="name" placeholder="Enter property name" required />

          <label for="destinationId">Select Destination *</label>
<select id="destinationId" name="destinationId" required>
  <option value="">-- Choose Destination --</option>
  <?php foreach ($destinations as $destination): ?>
    <option value="<?= $destination->destination_id ?>">
      <?= htmlspecialchars($destination->name) ?>
    </option>
  <?php endforeach; ?>
</select>

<label for="restaurantEmail">Contact Email *</label>
        <input type="email" id="email" name="email" placeholder="Enter contact email" required />

        <label for="restaurantPhone">Contact Phone *</label>
          <input type="tel" id="phone" name="phone" placeholder="Enter contact number" required />

      <label for="propertyDescription">Description *</label>
      <textarea id="propertyDescription" name="description" placeholder="Describe your property" required></textarea>

      <label for="propertyAddress">Address *</label>
      <input type="text" id="propertyAddress" name="address" placeholder="Full address" required />

      <label for="propertyType">Property Type *</label>
<select id="propertyType" name="propertyType" required>
  <option value="" disabled selected>Select property type</option>
  <?php foreach ($stayTypeResults as $type): ?>
    <option value="<?= htmlspecialchars($type->property_type) ?>">
      <?= htmlspecialchars(ucfirst($type->property_type)) ?>
    </option>
  <?php endforeach; ?>
</select>

      <label for="amenities">Select Amenities:</label>
      <div id="amenities" class="checkbox-group">
          <?php foreach ($amenities as $amenity): ?>
      <label>
      <input type="checkbox" name="amenities[]" value="<?= htmlspecialchars($amenity->id) ?>">
      <?= htmlspecialchars($amenity->name) ?>
     </label>
          <?php endforeach; ?>
     </div>

     <label>Free Cancellation *</label>
<div class="radio-group">
  <label><input type="radio" name="freeCancellation" value="1" required> Yes</label>
  <label><input type="radio" name="freeCancellation" value="0"> No</label>
</div>


      <label for="propertyImages">Upload Images (max 5)</label>
      <input type="file" id="propertyImages" name="property_images[]" accept="image/*" multiple />

       <h3>Add Rooms</h3>

      <label for="roomName">Room Name *</label>
      <input type="text" id="roomName" placeholder="e.g., Deluxe Room" />

          <label for="roomType">Room Type *</label>
<select id="roomType">
  <option value="" disabled selected>Select room type</option>
  <?php foreach ($roomTypeResults as $type): ?>
    <option value="<?= htmlspecialchars($type->type) ?>">
      <?= htmlspecialchars(ucfirst($type->type)) ?>
    </option>
  <?php endforeach; ?>
</select>


      <label for="roomDescription">Room Description *</label>
      <textarea id="roomDescription" placeholder="Describe this room"></textarea>

      <label for="roomPrice">Price per Night (LKR) *</label>
      <input type="number" id="roomPrice" min="0" placeholder="e.g., 5000" />

      <button type="button" id="addRoomBtn">Add Room</button>

      <!-- Display added rooms -->
      <div id="addedRoomsList">
        <h4>Rooms Added:</h4>
        <ul id="roomsUl"></ul>
      </div>

      <!-- Hidden input to store JSON of rooms -->
      <input type="hidden" name="rooms_data" id="roomsDataInput" />

      <button type="submit">Submit Property & Rooms</button>

    </form>

    <!-- Restaurant Form -->
    <form id="restaurantForm" action="/tripzly_test/restaurant/add" method="POST" enctype="multipart/form-data">
      <h2>List Your Restaurant</h2>
 <?php flash('restaurant'); ?>
      <label for="restaurantName">Restaurant Name *</label>
      <input type="text" id="restaurantName" name="restaurantName" placeholder="Enter restaurant name" required />

      <label for="destinationId">Select Destination *</label>
<select id="destinationId" name="destinationId" required>
  <option value="">-- Choose Destination --</option>
  <?php foreach ($destinations as $destination): ?>
    <option value="<?= $destination->destination_id ?>">
      <?= htmlspecialchars($destination->name) ?>
    </option>
  <?php endforeach; ?>
</select>

      <label for="restaurantDescription">Description *</label>
      <textarea id="restaurantDescription" name="restaurantDescription" placeholder="Describe your restaurant" required></textarea>

       
        <label for="restaurantAddress">Address *</label>
        <input type="text" id="restaurantAddress" name="restaurantAddress" placeholder="Enter address" required />

        <label for="restaurantEmail">Contact Email *</label>
        <input type="email" id="restaurantEmail" name="restaurantEmail" placeholder="Enter contact email" required />

        <label for="restaurantPhone">Contact Phone *</label>
          <input type="tel" id="restaurantPhone" name="restaurantPhone" placeholder="Enter contact number" required />

  <label for="openTime">Open From *</label>
  <input type="time" id="openTime" name="openFrom" required />

  <label for="closeTime">Open To *</label>
  <input type="time" id="closeTime" name="openTo" required />

      <label for="restaurantImages">Upload Images (max 5)</label>
      <input type="file" id="restaurantImages" name="restaurant_images[]" accept="image/*" multiple />

      <button type="submit">List Restaurant</button>
    </form>
  </main>

  <script>
    const propertyBtn = document.getElementById('propertyBtn');
    const restaurantBtn = document.getElementById('restaurantBtn');
    const propertyForm = document.getElementById('propertyForm');
    const restaurantForm = document.getElementById('restaurantForm');

    propertyBtn.addEventListener('click', () => {
      propertyBtn.classList.add('active');
      restaurantBtn.classList.remove('active');
      propertyForm.classList.add('active');
      restaurantForm.classList.remove('active');
    });

    restaurantBtn.addEventListener('click', () => {
      restaurantBtn.classList.add('active');
      propertyBtn.classList.remove('active');
      restaurantForm.classList.add('active');
      propertyForm.classList.remove('active');
    });

  const addRoomBtn = document.getElementById('addRoomBtn');
  const roomsUl = document.getElementById('roomsUl');
  const roomsDataInput = document.getElementById('roomsDataInput');

  let rooms = [];

  addRoomBtn.addEventListener('click', () => {
    const name = document.getElementById('roomName').value.trim();
    const type = document.getElementById('roomType').value;
    const description = document.getElementById('roomDescription').value.trim();
    const price = document.getElementById('roomPrice').value.trim();

    if (!name || !type || !description || !price) {
      alert('Please fill in all room fields.');
      return;
    }

    const room = { name, type, description, price };
    rooms.push(room);

    // Update the visual list
    const li = document.createElement('li');
    li.innerText = `${name} (${type}) - LKR ${price}`;
    roomsUl.appendChild(li);

    // Update hidden input as JSON
    roomsDataInput.value = JSON.stringify(rooms);

    // Clear inputs
    document.getElementById('roomName').value = '';
    document.getElementById('roomType').selectedIndex = 0;
    document.getElementById('roomDescription').value = '';
    document.getElementById('roomPrice').value = '';
  });
</script>


</body>
</html>
