<?php
session_start();
error_log('Session contents: ' . print_r($_SESSION, true));

$destinations = $_SESSION['destinationResults'] ?? [];
$tours = $_SESSION['tourResults'] ?? [];
$searchValue = $_SESSION['searchValue'] ?? '';
// error_log("Searching for: " . $searchValue);
?>


<h2>Search Results</h2>
<?php error_log("Searching for: " . $searchValue);?>
<h3>Matching Destinations</h3>
<?php if (!empty($destinations)): ?>
  <ul>
    <?php foreach ($destinations as $d): ?>
      <li><?= htmlspecialchars($d['name']) ?> (<?= htmlspecialchars($d['location']) ?>)</li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p>No destinations found.</p>
<?php endif; ?>

<h3>Matching Tours</h3>
<?php if (!empty($tours)): ?>
  <ul>
    <?php foreach ($tours as $t): ?>
      <li><?= htmlspecialchars($t['name']) ?> - <?= htmlspecialchars($t['type']) ?></li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p>No tours found.</p>
<?php endif; ?>
