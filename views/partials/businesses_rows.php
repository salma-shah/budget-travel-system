
<!-- these are JUST the rows -->
      <?php if (!empty($businesses)): ?>
    <?php foreach ($businesses as $business): ?>
      <tr>
        <td data-label="Business ID"><?= htmlspecialchars($business->user_id) ?></td>
        <td data-label="Full Name"><?= htmlspecialchars($business->name) ?></td>
        <td data-label="Address"><?= htmlspecialchars($business->address) ?></td>
        <td data-label="Email"><?= htmlspecialchars($business->email) ?></td>
        <td data-label="Role"><?= htmlspecialchars($business->role) ?></td>
        <td data-label="Status" id="status-<?= $business->user_id ?>"><?= htmlspecialchars($business->status ?? 'Active') ?></td>
        <td data-label="Actions">
       <a class="action-btn view-btn" href="manage_listings/<?= $business->user_id ?>">View Listings</a>
       <button class="action-btn delete-btn" onclick="deleteBusiness(<?= $business->user_id ?>)">Delete</button>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr><td colspan="6">No Businesses were found.</td></tr>
  <?php endif; ?>

