<?php
/** @var array $detail Normalized via project_detail_fields() */
$detail = $detail ?? [];
$showClose = !empty($showClose);
?>
<div class="pd-thumb">
  <?php
  $hero = $detail['shots'][0]['src'] ?? $detail['image'] ?? '';
  if ($hero !== ''):
  ?>
  <img src="<?= e(project_image_url($hero)) ?>" alt="<?= e($detail['title']) ?> screenshot" class="pd-thumb-img">
  <?php endif; ?>
</div>

<?php if (count($detail['shots'] ?? []) > 1): ?>
<div class="pd-gallery">
  <?php foreach (array_slice($detail['shots'], 0, 6) as $i => $shot): ?>
  <button type="button" class="pd-gallery__item<?= $i === 0 ? ' is-active' : '' ?>" data-pd-shot="<?= e(project_image_url($shot['src'])) ?>" aria-label="<?= e($shot['label'] ?: ('Screenshot ' . ($i + 1))) ?>">
    <img src="<?= e(project_image_url($shot['src'])) ?>" alt="" loading="lazy">
  </button>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (!empty($detail['project_type']) || !empty($detail['status'])): ?>
<p class="pd-meta-line">
  <?php if (!empty($detail['project_type'])): ?><span><?= e($detail['project_type']) ?></span><?php endif; ?>
  <?php if (!empty($detail['project_type']) && !empty($detail['status'])): ?> · <?php endif; ?>
  <?php if (!empty($detail['status'])): ?><span><?= e($detail['status']) ?></span><?php endif; ?>
</p>
<?php endif; ?>

<?php if (!empty($detail['description'])): ?>
<p class="pd-desc"><?= e($detail['description']) ?></p>
<?php endif; ?>

<?php if (!empty($detail['role'])): ?>
<div class="pd-section">
  <h3 class="pd-subheading">My Role</h3>
  <p><?= e($detail['role']) ?></p>
</div>
<?php endif; ?>

<?php if (!empty($detail['business_flow'])): ?>
<div class="pd-section">
  <h3 class="pd-subheading">Business Flow</h3>
  <p><strong><?= e($detail['business_flow']) ?></strong></p>
</div>
<?php endif; ?>

<?php if (!empty($detail['features'])): ?>
<div class="pd-section">
  <h3 class="pd-subheading">Key Features</h3>
  <ul class="pd-feature-list">
    <?php foreach ($detail['features'] as $feature): ?>
    <li><?= e($feature) ?></li>
    <?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>

<?php if (!empty($detail['technical'])): ?>
<div class="pd-section">
  <h3 class="pd-subheading">Technical Implementation</h3>
  <p><?= e($detail['technical']) ?></p>
</div>
<?php endif; ?>

<?php if (!empty($detail['stack'])): ?>
<div class="pd-section">
  <h3 class="pd-subheading">Stack</h3>
  <div class="pd-tags">
    <?php foreach ($detail['stack'] as $tag): ?>
    <span class="pd-tag"><?= e($tag) ?></span>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<?php if (!empty($detail['status'])): ?>
<div class="pd-section">
  <h3 class="pd-subheading">Status</h3>
  <span class="pd-status<?= stripos($detail['status'], 'deploy') !== false ? ' pd-status--live' : '' ?>"><?= e($detail['status']) ?></span>
</div>
<?php endif; ?>

<?php if (!empty($detail['link_url'])): ?>
<div class="pd-section">
  <h3 class="pd-subheading">Live Demo</h3>
  <a href="<?= e($detail['link_url']) ?>" class="btn btn-primary" target="_blank" rel="noopener noreferrer"><?= e($detail['link_label']) ?></a>
</div>
<?php endif; ?>
