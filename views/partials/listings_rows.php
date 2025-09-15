
<?php if (!empty($listings)): ?>
  <?php foreach ($listings as $listing): ?>
    <tr id="L<?= htmlspecialchars($listing->id) ?>">
      <td data-label="Listing ID">L<?= htmlspecialchars($listing->listable_id) ?></td>
      <td data-label="Category"><?= ucfirst(htmlspecialchars($listing->listable_type)) ?></td>
      <td data-label="Title"><?= htmlspecialchars($listing->name) ?></td>
      <td data-label="Business Name"><?= htmlspecialchars($listing->business_name ?? 'N/A') ?></td>
      <td data-label="Status" class="status"><?= htmlspecialchars($listing->status) ?></td>
      <td data-label="Actions">
        <button class="action-btn view-btn" onclick="viewListing(<?= $listing->id ?>)">View</button>
        <button class="action-btn approve-btn" onclick="approveListing(<?= $listing->id ?>)">Approve</button>
        <button class="action-btn reject-btn" onclick="rejectListing(<?= $listing->id ?>)">Reject</button>
        <button class="action-btn delete-btn" onclick="deleteListing(<?= $listing->id ?>)">Delete</button>
      </td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr><td colspan="6">No listings found.</td></tr>
<?php endif; ?>


