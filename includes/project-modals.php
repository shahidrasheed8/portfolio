<?php
/** @var array $modalProjects */
$modalProjects = $modalProjects ?? [];
foreach ($modalProjects as $modalProject):
    $detail = project_detail_fields($modalProject);
    $modalId = 'project-modal-' . preg_replace('/[^a-z0-9\-]/i', '', (string) ($detail['slug'] ?: ($modalProject['id'] ?? 'x')));
?>
<div class="project-modal" id="<?= e($modalId) ?>" hidden data-project-modal role="dialog" aria-modal="true" aria-labelledby="<?= e($modalId) ?>-title">
  <div class="project-modal__backdrop" data-close-project-modal tabindex="-1"></div>
  <div class="project-modal__dialog" role="document">
    <div class="project-modal__content">
      <header class="project-modal__header">
        <h2 class="project-modal__title" id="<?= e($modalId) ?>-title"><?= e($detail['title']) ?></h2>
        <button type="button" class="project-modal__close" data-close-project-modal aria-label="Close">
          <i class="fas fa-times" aria-hidden="true"></i>
        </button>
      </header>
      <div class="project-modal__body">
        <?php require __DIR__ . '/project-detail-body.php'; ?>
      </div>
      <footer class="project-modal__footer">
        <button type="button" class="btn btn-outline-primary" data-close-project-modal>Close</button>
        <a href="<?= e(project_public_url($detail['slug'])) ?>" class="btn btn-primary">Open page</a>
      </footer>
    </div>
  </div>
</div>
<?php endforeach; ?>
