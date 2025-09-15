<!-- these are JUST the rows -->
 
<?php if (!empty($users)): ?>
  <?php foreach ($users as $user): ?>
    <tr>
      <td data-label="User ID"><?= htmlspecialchars($user->user_id) ?></td>
      <td data-label="Full Name"><?= htmlspecialchars($user->name) ?></td>
      <td data-label="Address"><?= htmlspecialchars($user->address) ?></td>
      <td data-label="Email"><?= htmlspecialchars($user->email) ?></td>
      <td data-label="Full Name"><?= htmlspecialchars($user->contact_number) ?></td>
      <td data-label="Role"><?= htmlspecialchars($user->role) ?></td>
      <td data-label="Status" id="status-<?= $user->user_id ?>"><?= htmlspecialchars($user->status ?? 'Active') ?></td>
      <td data-label="Actions">
      <button class="action-btn delete-btn" onclick="deleteUser(<?= $user->user_id ?>)">Delete</button>
      </td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr><td colspan="7">No users found.</td></tr>
<?php endif; ?>
