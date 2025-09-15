<?php
$stays = $stays ?? ($_SESSION['current_stays'] ?? []);
?>

<?php if (!empty($stays)): ?>
      <?php foreach ($stays as $stay): ?>
        <div class="stay-card">
          <img src="/tripzly_test/<?= htmlspecialchars($stay->image) ?>" 
               alt="<?= htmlspecialchars($stay->alt_text ?? $stay->name) ?>" 
               class="stay-image">
          
          <div class="stay-content">
            <div class="stay-title"><?= htmlspecialchars($stay->name) ?></div>
            <div class="stay-type"><?= htmlspecialchars($stay->property_type) ?></div>
            <a href="/tripzly_test/stay/<?= urlencode($stay->stay_id) ?>" class="view-button">View Details</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No stays available at the moment.</p>
    <?php endif; ?>