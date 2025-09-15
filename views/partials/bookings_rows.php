
<!-- these are JUST the rows -->
      <?php if (!empty($bookings)): ?>
    <?php foreach ($bookings as $booking): ?>

<tr>
        <td data-label="Booking ID"><?= htmlspecialchars($booking->booking_id) ?></td>
        <td data-label="Customer"><?= htmlspecialchars($booking->customer_name) ?></td>
        <td data-label="Cuatomer ID"><?= htmlspecialchars($booking->customer_id) ?></td>
        <td data-label="Customer Email"><?= htmlspecialchars($booking->customer_email) ?></td>
        <td data-label="Service"><?= htmlspecialchars($booking->service) ?></td>
        <td data-label="Start Date"><?= htmlspecialchars($booking->booking_start) ?></td>
        <td data-label="End Date"><?= htmlspecialchars($booking->booking_end) ?></td>
        <td data-label="Status"><?= htmlspecialchars($booking->status) ?></td>
        <td data-label="Actions">
          <button class="action-btn view-btn" onclick="viewBooking(<?= $booking->booking_id ?>)">View</button>
          <button class="action-btn confirm-btn" onclick="approveBooking(<?= $booking->booking_id ?>)">Approve</button>
          <button class="action-btn cancel-btn" onclick="rejectBooking(<?= $booking->booking_id ?>)">Reject</button>
        </td>
      </tr>
      <?php endforeach; ?>
  <?php else: ?>
    <tr><td colspan="6">No Bookings were found.</td></tr>
  <?php endif; ?>
