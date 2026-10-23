<?php

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function site_base(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $root = str_replace('\\', '/', realpath(dirname(__DIR__)) ?: dirname(__DIR__));
    $doc = str_replace('\\', '/', rtrim((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''), '/'));
    $rootCmp = PHP_OS_FAMILY === 'Windows' ? strtolower($root) : $root;
    $docCmp = PHP_OS_FAMILY === 'Windows' ? strtolower($doc) : $doc;
    if ($docCmp !== '' && strncmp($rootCmp, $docCmp, strlen($docCmp)) === 0) {
        $rel = substr($root, strlen($doc));
        $base = $rel === '' ? '/' : $rel . '/';
        return $base;
    }

    // Local XAMPP fallback; on shared hosting (public_html) docroot match above yields '/'.
    $base = (str_ends_with($rootCmp, '/shahid') || str_ends_with($rootCmp, '\\shahid')) ? '/shahid/' : '/';
    return $base;
}

function data_dir(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data';
}

function load_json(string $filename, $default = [])
{
    $path = data_dir() . DIRECTORY_SEPARATOR . $filename;
    if (!is_file($path)) {
        return $default;
    }

    $raw = file_get_contents($path);
    $data = json_decode((string) $raw, true);

    return is_array($data) ? $data : $default;
}

function save_json(string $filename, $data): bool
{
    $dir = data_dir();
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $path = $dir . DIRECTORY_SEPARATOR . $filename;
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    return file_put_contents($path, $json . PHP_EOL, LOCK_EX) !== false;
}

function get_admin(): array
{
    $admin = load_json('admin.json', []);

    return [
        'username' => (string) ($admin['username'] ?? 'admin'),
        'password_hash' => (string) ($admin['password_hash'] ?? ''),
    ];
}

function save_admin(array $admin): bool
{
    return save_json('admin.json', [
        'username' => $admin['username'],
        'password_hash' => $admin['password_hash'],
    ]);
}

function get_projects(): array
{
    $projects = load_json('projects.json', []);
    usort($projects, static function ($a, $b) {
        $ao = (int) ($a['sort_order'] ?? 0);
        $bo = (int) ($b['sort_order'] ?? 0);
        if ($ao === $bo) {
            return ((int) ($a['id'] ?? 0)) <=> ((int) ($b['id'] ?? 0));
        }

        return $ao <=> $bo;
    });

    return $projects;
}

function get_featured_projects(): array
{
    return array_values(array_filter(get_projects(), static function ($project) {
        return !empty($project['featured']);
    }));
}

function get_project_by_id(int $id): ?array
{
    foreach (get_projects() as $project) {
        if ((int) ($project['id'] ?? 0) === $id) {
            return $project;
        }
    }

    return null;
}

function get_project_by_slug(string $slug): ?array
{
    $slug = strtolower(trim($slug));
    if ($slug === '') {
        return null;
    }

    foreach (get_projects() as $project) {
        if (strtolower((string) ($project['slug'] ?? '')) === $slug) {
            return $project;
        }
    }

    return null;
}

function save_projects(array $projects): bool
{
    return save_json('projects.json', array_values($projects));
}

function next_project_id(array $projects): int
{
    $max = 0;
    foreach ($projects as $project) {
        $max = max($max, (int) ($project['id'] ?? 0));
    }

    return $max + 1;
}

function slugify(string $title): string
{
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? '';
    $slug = trim($slug, '-');

    return $slug !== '' ? $slug : 'project';
}

function unique_slug(string $slug, array $projects, ?int $ignoreId = null): string
{
    $base = slugify($slug);
    $candidate = $base;
    $i = 2;

    while (true) {
        $taken = false;
        foreach ($projects as $project) {
            if ($ignoreId !== null && (int) ($project['id'] ?? 0) === $ignoreId) {
                continue;
            }
            if (strtolower((string) ($project['slug'] ?? '')) === $candidate) {
                $taken = true;
                break;
            }
        }
        if (!$taken) {
            return $candidate;
        }
        $candidate = $base . '-' . $i;
        $i++;
    }
}

function project_public_url(string $slug, string $from = 'home'): string
{
    return site_base() . 'projects/' . rawurlencode($slug) . '/';
}

function project_image_url(?string $image, string $from = 'home'): string
{
    $image = ltrim((string) $image, '/');
    if ($image === '') {
        $image = 'assets/uploads/projects/shahid/nahj.png';
    }

    return site_base() . $image;
}

function project_shots(array $project): array
{
    $shots = [];
    if (!empty($project['gallery']) && is_array($project['gallery'])) {
        foreach ($project['gallery'] as $item) {
            if (is_string($item) && $item !== '') {
                $shots[] = ['src' => $item, 'label' => ''];
            } elseif (is_array($item) && !empty($item['src'])) {
                $shots[] = [
                    'src' => (string) $item['src'],
                    'label' => (string) ($item['label'] ?? ''),
                ];
            }
        }
    }

    if (!$shots && !empty($project['image'])) {
        $shots[] = ['src' => (string) $project['image'], 'label' => ''];
    }

    return $shots;
}

function project_category_counts(array $projects): array
{
    $counts = [];
    foreach ($projects as $project) {
        $key = strtolower(trim((string) ($project['category'] ?? 'other')));
        if ($key === '') {
            $key = 'other';
        }
        if (!isset($counts[$key])) {
            $counts[$key] = [
                'key' => $key,
                'label' => (string) ($project['category_label'] ?? ucfirst($key)),
                'count' => 0,
            ];
        }
        $counts[$key]['count']++;
    }

    return $counts;
}

function render_project_content(string $content, string $fallback = ''): string
{
    $content = trim($content);
    if ($content === '') {
        $content = trim($fallback);
    }
    if ($content === '') {
        return '';
    }

    if (preg_match('/<[a-z!\/][\s\S]*>/i', $content)) {
        return preg_replace('#<script\b[^>]*>.*?</script>#is', '', $content) ?? '';
    }

    return '<p class="section-text">' . nl2br(e($content)) . '</p>';
}

function project_tech_tags(array $project): array
{
    if (!empty($project['stack']) && is_array($project['stack'])) {
        $tags = [];
        foreach ($project['stack'] as $tag) {
            $tag = trim((string) $tag);
            if ($tag !== '') {
                $tags[] = $tag;
            }
        }
        if ($tags) {
            return $tags;
        }
    }

    $raw = (string) ($project['tech_stack'] ?? '');
    if ($raw === '') {
        return [];
    }

    $parts = preg_split('/\s*[·|,]\s*/u', $raw) ?: [];
    $tags = [];
    foreach ($parts as $part) {
        $part = trim($part);
        if ($part !== '') {
            $tags[] = $part;
        }
    }

    return $tags;
}

function project_features_list(array $project): array
{
    if (!empty($project['features']) && is_array($project['features'])) {
        $out = [];
        foreach ($project['features'] as $feature) {
            $feature = trim(strip_tags((string) $feature));
            if ($feature !== '') {
                $out[] = $feature;
            }
        }
        if ($out) {
            return $out;
        }
    }

    $content = (string) ($project['content'] ?? '');
    if ($content !== '' && preg_match_all('#<li[^>]*>(.*?)</li>#is', $content, $matches)) {
        $out = [];
        foreach ($matches[1] as $item) {
            $item = trim(html_entity_decode(strip_tags($item), ENT_QUOTES, 'UTF-8'));
            if ($item !== '') {
                $out[] = $item;
            }
        }
        return $out;
    }

    return [];
}

/**
 * Normalized fields for Ahmad-style project detail (modal + detail page).
 */
function project_detail_fields(array $project): array
{
    $features = project_features_list($project);
    $tags = project_tech_tags($project);
    $hasLive = trim((string) ($project['link_url'] ?? '')) !== '';

    $role = trim((string) ($project['role'] ?? ''));
    if ($role === '') {
        $role = 'Full-stack development — ownership of backend, database, and frontend.';
    }

    $technical = trim((string) ($project['technical'] ?? ''));
    if ($technical === '') {
        $content = (string) ($project['content'] ?? '');
        if ($content !== '' && preg_match('#<p[^>]*>(.*?)</p>#is', $content, $m)) {
            $technical = trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES, 'UTF-8'));
        }
        if ($technical === '') {
            $technical = trim((string) ($project['description'] ?? ''));
        }
    }

    $status = trim((string) ($project['status'] ?? ''));
    if ($status === '') {
        $status = $hasLive ? 'Deployed' : 'Completed';
    }

    $type = trim((string) ($project['project_type'] ?? ''));
    if ($type === '') {
        $type = $hasLive ? 'Client Project' : 'Independent Project';
    }

    return [
        'title' => (string) ($project['title'] ?? ''),
        'description' => (string) ($project['description'] ?? ''),
        'role' => $role,
        'business_flow' => trim((string) ($project['business_flow'] ?? '')),
        'features' => $features,
        'technical' => $technical,
        'stack' => $tags,
        'status' => $status,
        'project_type' => $type,
        'link_url' => trim((string) ($project['link_url'] ?? '')),
        'link_label' => trim((string) ($project['link_label'] ?? '')) ?: ($hasLive ? 'Visit Site' : 'View Details'),
        'image' => (string) ($project['image'] ?? ''),
        'shots' => project_shots($project),
        'slug' => (string) ($project['slug'] ?? ''),
        'category_label' => (string) ($project['category_label'] ?? ''),
    ];
}

function get_contact_messages(): array
{
    $dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'contact-messages';
    if (!is_dir($dir)) {
        return [];
    }

    $files = glob($dir . DIRECTORY_SEPARATOR . '*.json') ?: [];
    rsort($files);
    $messages = [];

    foreach ($files as $file) {
        $data = json_decode((string) file_get_contents($file), true);
        if (!is_array($data)) {
            continue;
        }
        $data['_file'] = basename($file);
        $messages[] = $data;
    }

    return $messages;
}

function delete_contact_message(string $filename): bool
{
    $filename = basename($filename);
    if (!preg_match('/^[a-zA-Z0-9._-]+\.json$/', $filename)) {
        return false;
    }

    $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'contact-messages' . DIRECTORY_SEPARATOR . $filename;
    if (!is_file($path)) {
        return false;
    }

    $data = json_decode((string) file_get_contents($path), true);
    if (is_array($data) && !empty($data['attachment'])) {
        $upload = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'contact-uploads' . DIRECTORY_SEPARATOR . basename((string) $data['attachment']);
        if (is_file($upload)) {
            @unlink($upload);
        }
    }

    return @unlink($path);
}

function is_uploaded_project_image(?string $image): bool
{
    $name = basename((string) $image);

    return (bool) preg_match('/^p-\d{14}-[a-f0-9]+\.(jpe?g|png|gif|webp)$/i', $name);
}
