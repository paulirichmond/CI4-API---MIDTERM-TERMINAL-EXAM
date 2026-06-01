<?php
$seg     = service('uri')->getSegment(1);
$subseg  = service('uri')->getSegment(2);
$name    = session('user')['fullname'] ?? 'User';
$role    = session('user')['role'] ?? '';
$initial = strtoupper(substr($name, 0, 1));

$crumbs = [];
if ($seg) $crumbs[] = ucwords(str_replace(['-','_'], ' ', $seg));
if ($subseg) $crumbs[] = ucwords(str_replace(['-','_'], ' ', $subseg));

$roleColors = [
    'admin'       => ['bg' => '#eef2ff', 'color' => '#6366f1', 'label' => 'Administrator'],
    'teacher'     => ['bg' => '#ecfdf5', 'color' => '#059669', 'label' => 'Teacher'],
    'coordinator' => ['bg' => '#fffbeb', 'color' => '#b45309', 'label' => 'Coordinator'],
    'student'     => ['bg' => '#f0f9ff', 'color' => '#0284c7', 'label' => 'Student'],
];
$rc = $roleColors[$role] ?? ['bg' => '#f1f5f9', 'color' => '#64748b', 'label' => ucfirst($role)];
?>
<style>
/* Notification badge alignment and sizing - improved centering and contrast */
.hdr-icon-btn{position:relative;display:inline-flex;align-items:center;justify-content:center;padding:6px;border-radius:6px}
.hdr-icon-btn i{font-size:18px}
.hdr-icon-btn .notif-badge{
    position:absolute;
    top:0;
    right:0;
    transform:translate(40%, -40%);
    min-width:20px;
    height:20px;
    padding:0 6px;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    font-size:11px;
    font-weight:700;
    background:var(--indigo, #6366f1);
    color:#fff;
    box-shadow:0 4px 10px rgba(0,0,0,0.12);
    z-index:100;
    border:2px solid #fff; /* white ring so badge stands out */
}
@media (max-width:576px){
    .hdr-icon-btn .notif-badge{transform:translate(45%,-45%);min-width:18px;height:18px;font-size:10px}
}
</style>

<header class="app-header">
    <div class="header-left">
        <div class="header-breadcrumb">
            <i class="bi bi-house-fill" style="font-size:13px;color:var(--text-3);"></i>
            <?php foreach ($crumbs as $i => $crumb): ?>
                <i class="bi bi-chevron-right" style="font-size:9px;color:var(--border-2);"></i>
                <span class="<?= $i === count($crumbs)-1 ? 'crumb-active' : 'crumb-item' ?>"><?= esc($crumb) ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="header-center">
        <div class="header-search">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search students, courses...">
            <kbd>⌘K</kbd>
        </div>
    </div>

    <div class="header-right">
        <div class="dropdown">
            <button class="hdr-icon-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                <i class="bi bi-bell-fill"></i>
                <?php
                $db = \Config\Database::connect();
                $recentCount = $db->table('users')
                    ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-24 hours')))
                    ->countAllResults();
                if ($recentCount > 0): ?>
                <span class="notif-badge"><?= $recentCount ?></span>
                <?php endif; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="min-width:320px;max-height:420px;overflow-y:auto;">
                <li>
                    <div style="padding:10px 14px 12px;border-bottom:1px solid var(--border);margin-bottom:4px;display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:13px;font-weight:700;color:var(--text-1);">Notifications</span>
                        <?php if ($recentCount > 0): ?>
                        <span class="badge badge-indigo"><?= $recentCount ?> new</span>
                        <?php endif; ?>
                    </div>
                </li>
                <?php
                $notifications = $db->table('users u')
                    ->select('u.id, u.fullname, u.username, u.created_at, u.updated_at, r.name AS role_name')
                    ->join('roles r', 'r.id = u.role_id', 'left')
                    ->orderBy('u.created_at', 'DESC')
                    ->limit(8)
                    ->get()->getResultArray();

                $roleIcons = [
                    'admin'       => ['bi-shield-fill',      '#6366f1'],
                    'teacher'     => ['bi-person-workspace', '#059669'],
                    'coordinator' => ['bi-diagram-3-fill',   '#b45309'],
                    'student'     => ['bi-mortarboard-fill', '#0284c7'],
                ];

                if (empty($notifications)): ?>
                <li><div style="padding:24px;text-align:center;color:var(--text-3);font-size:13px;"><i class="bi bi-bell-slash" style="font-size:24px;display:block;margin-bottom:8px;"></i>No notifications</div></li>
                <?php else:
                foreach ($notifications as $n):
                    $role = $n['role_name'] ?? 'student';
                    [$ico, $clr] = $roleIcons[$role] ?? ['bi-person-fill', '#94a3b8'];
                    $isNew = strtotime($n['created_at']) >= strtotime('-24 hours');
                    $timeAgo = function($dt) {
                        $diff = time() - strtotime($dt);
                        // If timestamp is in the future (clock skew), treat as just now
                        if ($diff < 0) {
                            $diff = 0;
                        }
                        if ($diff < 5) return 'just now';
                        if ($diff < 60) return $diff . 's ago';
                        if ($diff < 3600) return floor($diff/60) . 'm ago';
                        if ($diff < 86400) return floor($diff/3600) . 'h ago';
                        return floor($diff/86400) . 'd ago';
                    };
                ?>
                <li>
                    <a class="dropdown-item" href="<?= base_url('students/show/'.$n['id']) ?>" style="align-items:flex-start;gap:10px;padding:10px 14px;<?= $isNew ? 'background:#f8f7ff;' : '' ?>">
                        <div style="width:32px;height:32px;border-radius:50%;background:<?= $clr ?>18;display:flex;align-items:center;justify-content:center;color:<?= $clr ?>;font-size:13px;flex-shrink:0;margin-top:1px;">
                            <i class="bi <?= $ico ?>"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:12px;font-weight:700;color:var(--text-1);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <?= esc($n['fullname']) ?>
                                <?php if ($isNew): ?><span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#6366f1;margin-left:4px;vertical-align:middle;"></span><?php endif; ?>
                            </div>
                            <div style="font-size:11px;color:var(--text-3);margin-top:1px;">
                                New <?= ucfirst($role) ?> account registered
                            </div>
                            <div style="font-size:10px;color:var(--text-3);margin-top:2px;"><?= $timeAgo($n['created_at']) ?></div>
                        </div>
                    </a>
                </li>
                <?php endforeach; endif; ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?= base_url('admin/users') ?>" style="justify-content:center;color:var(--indigo);font-size:12px;">View all accounts <i class="bi bi-arrow-right"></i></a></li>
            </ul>
        </div>

        <div class="hdr-divider"></div>

        <div class="dropdown">
            <button class="hdr-user-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="hdr-avatar"><?= $initial ?></div>
                <div class="hdr-user-info">
                    <span class="hdr-user-name"><?= esc(explode(' ', $name)[0]) ?></span>
                    <span class="hdr-user-role" style="background:<?= $rc['bg'] ?>;color:<?= $rc['color'] ?>;"><?= $rc['label'] ?></span>
                </div>
                <i class="bi bi-chevron-down" style="font-size:10px;color:var(--text-3);"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="min-width:220px;">
                <li>
                    <div style="padding:12px 14px 14px;border-bottom:1px solid var(--border);margin-bottom:4px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:14px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><?= $initial ?></div>
                            <div>
                                <div style="font-size:13px;font-weight:700;color:var(--text-1);"><?= esc($name) ?></div>
                                <div style="font-size:11px;color:var(--text-3);"><?= esc(session('user')['email'] ?? session('user')['username'] ?? '') ?></div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="bi bi-person-fill"></i> My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right"></i> Sign out</a></li>
            </ul>
        </div>
    </div>
</header>
