<?php
require_once __DIR__ . '/auth.php';
require_login();

const UPLOAD_DIR = __DIR__ . '/../assets/uploads/projects';
const UPLOAD_WEB = 'assets/uploads/projects';
const ALLOWED_EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
const MAX_UPLOAD_BYTES = 5 * 1024 * 1024;

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isEdit = $id > 0;
$projects = get_projects();

$project = [
    'id' => 0,
    'slug' => '',
    'title' => '',
    'description' => '',
    'content' => '',
    'tech_stack' => '',
    'category' => 'laravel',
    'category_label' => 'Laravel',
    'image' => '',
    'link_url' => '',
    'link_label' => '',
    'featured' => true,
    'sort_order' => count($projects) + 1,
    'project_type' => 'Client Project',
    'status' => 'Deployed',
    'role' => '',
    'business_flow' => '',
    'technical' => '',
    'features' => [],
];

if ($isEdit) {
    $existing = get_project_by_id($id);
    if (!$existing) {
        header('Location: projects.php');
        exit;
    }
    $project = array_merge($project, $existing);
}

$errors = [];

$categoryPresets = [
    'laravel' => 'Laravel',
    'next' => 'Next.js',
    'php' => 'PHP',
    'other' => 'Other',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();

    $project['title'] = trim((string) ($_POST['title'] ?? ''));
    $project['description'] = trim((string) ($_POST['description'] ?? ''));
    $project['content'] = trim((string) ($_POST['content'] ?? ''));
    $project['tech_stack'] = trim((string) ($_POST['tech_stack'] ?? ''));
    $project['category'] = strtolower(trim((string) ($_POST['category'] ?? 'other')));
    $project['category_label'] = trim((string) ($_POST['category_label'] ?? ''));
    $project['link_url'] = trim((string) ($_POST['link_url'] ?? ''));
    $project['link_label'] = trim((string) ($_POST['link_label'] ?? ''));
    $project['project_type'] = trim((string) ($_POST['project_type'] ?? ''));
    $project['status'] = trim((string) ($_POST['status'] ?? ''));
    $project['role'] = trim((string) ($_POST['role'] ?? ''));
    $project['business_flow'] = trim((string) ($_POST['business_flow'] ?? ''));
    $project['technical'] = trim((string) ($_POST['technical'] ?? ''));
    $featuresRaw = trim((string) ($_POST['features'] ?? ''));
    $project['features'] = [];
    if ($featuresRaw !== '') {
        foreach (preg_split('/\r\n|\r|\n/', $featuresRaw) ?: [] as $line) {
            $line = trim($line);
            if ($line !== '') {
                $project['features'][] = $line;
            }
        }
    }
    $project['featured'] = !empty($_POST['featured']);
    $project['sort_order'] = (int) ($_POST['sort_order'] ?? 0);
    $slugInput = trim((string) ($_POST['slug'] ?? ''));

    if (trim(strip_tags($project['content'])) === '' && stripos($project['content'], '<img') === false) {
        $project['content'] = '';
    }

    if ($project['title'] === '') {
        $errors[] = 'Title is required.';
    }
    if ($project['description'] === '') {
        $errors[] = 'Short description is required.';
    }
    if ($project['link_url'] !== '' && !filter_var($project['link_url'], FILTER_VALIDATE_URL)) {
        $errors[] = 'Live URL must be valid and include http:// or https://.';
    }
    if ($project['category'] === '') {
        $project['category'] = 'other';
    }
    if ($project['category_label'] === '') {
        $project['category_label'] = $categoryPresets[$project['category']] ?? ucfirst($project['category']);
    }

    $imagePath = (string) ($project['image'] ?? '');
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload = $_FILES['image'];
        if ($upload['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Image upload failed.';
        } elseif ($upload['size'] > MAX_UPLOAD_BYTES) {
            $errors[] = 'Image is too large (max 5 MB).';
        } else {
            $ext = strtolower(pathinfo($upload['name'], PATHINFO_EXTENSION));
            $info = @getimagesize($upload['tmp_name']);
            if (!in_array($ext, ALLOWED_EXT, true) || $info === false) {
                $errors[] = 'Image must be JPG, PNG, GIF or WEBP.';
            } else {
                if (!is_dir(UPLOAD_DIR)) {
                    mkdir(UPLOAD_DIR, 0755, true);
                }
                $filename = 'p-' . date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
                $dest = UPLOAD_DIR . '/' . $filename;
                if (move_uploaded_file($upload['tmp_name'], $dest)) {
                    if (is_uploaded_project_image($imagePath)) {
                        $old = dirname(__DIR__) . '/' . $imagePath;
                        if (is_file($old)) {
                            @unlink($old);
                        }
                    }
                    $imagePath = UPLOAD_WEB . '/' . $filename;
                } else {
                    $errors[] = 'Could not save the uploaded image.';
                }
            }
        }
    }
    $project['image'] = $imagePath;

    if (!$errors) {
        $all = get_projects();
        $project['slug'] = unique_slug($slugInput !== '' ? $slugInput : $project['title'], $all, $isEdit ? $id : null);

        if ($isEdit) {
            foreach ($all as $i => $row) {
                if ((int) $row['id'] === $id) {
                    $project['id'] = $id;
                    $all[$i] = $project;
                    break;
                }
            }
            save_projects($all);
            header('Location: projects.php?msg=updated');
            exit;
        }

        $project['id'] = next_project_id($all);
        $all[] = $project;
        save_projects($all);
        header('Location: projects.php?msg=created');
        exit;
    }
}

$contentForEditor = (string) $project['content'];
if ($contentForEditor !== '' && !preg_match('/<[a-z!\/][\s\S]*>/i', $contentForEditor)) {
    $contentForEditor = '<p>' . nl2br(e($contentForEditor)) . '</p>';
}

admin_header($isEdit ? 'Edit project' : 'Add project', 'projects');
?>
<div class="page-head">
    <h1><?= $isEdit ? 'Edit project' : 'Add project' ?></h1>
    <a href="projects.php" class="btn">&larr; Back</a>
</div>

<?php if ($errors): ?>
<div class="alert alert-error">
    <ul>
        <?php foreach ($errors as $err): ?>
        <li><?= e($err) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="card form">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

    <label for="title">Title <span class="req">*</span></label>
    <input type="text" id="title" name="title" value="<?= e($project['title']) ?>" required>

    <label for="slug">URL slug</label>
    <input type="text" id="slug" name="slug" value="<?= e($project['slug']) ?>" placeholder="auto-from-title">
    <p class="muted small">Used in the project URL, e.g. /projects/nahj/</p>

    <label for="description">Short description <span class="req">*</span></label>
    <textarea id="description" name="description" rows="3" required><?= e($project['description']) ?></textarea>

    <label for="content-editor">Full details</label>
    <div class="editor-wrap">
        <div id="content-editor"><?= $contentForEditor ?></div>
    </div>
    <textarea id="content" name="content" hidden><?= e($project['content']) ?></textarea>
    <p class="muted small">Shown on the project page. Leave empty to use the short description.</p>

    <label for="tech_stack">Tech stack</label>
    <input type="text" id="tech_stack" name="tech_stack" value="<?= e($project['tech_stack']) ?>" placeholder="Laravel 11 · PHP · MySQL">

    <div class="grid-2">
        <div>
            <label for="project_type">Project type</label>
            <input type="text" id="project_type" name="project_type" value="<?= e($project['project_type'] ?? '') ?>" placeholder="Client Project">
        </div>
        <div>
            <label for="status">Status</label>
            <input type="text" id="status" name="status" value="<?= e($project['status'] ?? '') ?>" placeholder="Deployed">
        </div>
    </div>

    <label for="role">My role</label>
    <textarea id="role" name="role" rows="2" placeholder="Full-stack Laravel development…"><?= e($project['role'] ?? '') ?></textarea>

    <label for="business_flow">Business flow</label>
    <input type="text" id="business_flow" name="business_flow" value="<?= e($project['business_flow'] ?? '') ?>" placeholder="Search → Book → Pay → Deliver">

    <label for="features">Key features</label>
    <textarea id="features" name="features" rows="6" placeholder="One feature per line"><?= e(implode("\n", array_map('strval', $project['features'] ?? []))) ?></textarea>

    <label for="technical">Technical implementation</label>
    <textarea id="technical" name="technical" rows="4" placeholder="How it was built…"><?= e($project['technical'] ?? '') ?></textarea>

    <div class="grid-2">
        <div>
            <label for="category">Category</label>
            <select id="category" name="category">
                <?php foreach ($categoryPresets as $key => $label): ?>
                <option value="<?= e($key) ?>" <?= ($project['category'] === $key) ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="category_label">Category label</label>
            <input type="text" id="category_label" name="category_label" value="<?= e($project['category_label']) ?>" placeholder="Laravel">
        </div>
    </div>

    <div class="grid-2">
        <div>
            <label for="link_url">Live URL</label>
            <input type="url" id="link_url" name="link_url" value="<?= e($project['link_url']) ?>" placeholder="https://">
        </div>
        <div>
            <label for="link_label">Link label</label>
            <input type="text" id="link_label" name="link_label" value="<?= e($project['link_label']) ?>" placeholder="View live">
        </div>
    </div>

    <label for="sort_order">Sort order</label>
    <input type="number" id="sort_order" name="sort_order" value="<?= (int) $project['sort_order'] ?>" style="max-width:140px;">
    <p class="muted small">Lower numbers appear first.</p>

    <label class="check-row">
        <input type="checkbox" name="featured" value="1" <?= !empty($project['featured']) ? 'checked' : '' ?>>
        Show on homepage
    </label>

    <label for="image">Image</label>
    <?php if (!empty($project['image'])): ?>
    <div class="current-image">
        <img src="<?= e(project_image_url($project['image'], 'admin')) ?>" alt="Current image">
        <span class="muted small">Upload a new file to replace this image.</span>
    </div>
    <?php endif; ?>
    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">
    <p class="muted small">JPG, PNG, GIF or WEBP, up to 5 MB.</p>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save changes' : 'Create project' ?></button>
        <a href="projects.php" class="btn">Cancel</a>
    </div>
</form>

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
(function () {
    var editorEl = document.getElementById('content-editor');
    var hidden = document.getElementById('content');
    if (!editorEl || !hidden) return;

    var quill = new Quill(editorEl, {
        theme: 'snow',
        placeholder: 'Longer project description…',
        modules: {
            toolbar: [
                [{ header: [2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    });

    function syncHidden() {
        hidden.value = quill.getText().trim() === '' ? '' : quill.root.innerHTML;
    }
    quill.on('text-change', syncHidden);
    syncHidden();
    var form = hidden.closest('form');
    if (form) form.addEventListener('submit', syncHidden);
})();
</script>
<?php admin_footer();