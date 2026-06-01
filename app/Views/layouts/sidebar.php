<?php
$role    = session('user')['role'] ?? 'guest';
$seg     = service('uri')->getSegment(1);
$subseg  = service('uri')->getSegment(2);
$name    = session('user')['fullname'] ?? 'User';
$initial = strtoupper(substr($name, 0, 1));

function sideLink($href, $icon, $label, $active, $badge = null) {
    $cls = 'nav-link' . ($active ? ' active' : '');
    $b   = $badge ? "<span class=\"nav-badge\">{$badge}</span>" : '';
    return "<a href=\"{$href}\" class=\"{$cls}\"><i class=\"bi bi-{$icon}\"></i><span>{$label}</span>{$b}</a>";
}
?>
<aside class="app-sidebar">
    <div class="sidebar-logo">
        <div class="logo-mark">DA</div>
        <div class="logo-text">
            <span class="logo-name">Digimon Academy</span>
            <span class="logo-sub">School Management</span>
        </div>
    </div>

    <div class="sidebar-nav">
        <?php if ($role === 'admin'): ?>
        <div class="nav-group">
            <div class="nav-group-label">Overview</div>
            <?= sideLink(base_url('dashboard'), 'speedometer2', 'Dashboard', $seg === 'dashboard') ?>
        </div>
        <div class="nav-group">
            <div class="nav-group-label">Academic</div>
            <?= sideLink(base_url('students'), 'people-fill', 'Students', $seg === 'students') ?>
        </div>
        <div class="nav-group">
            <div class="nav-group-label">Administration</div>
            <?= sideLink(base_url('admin/users'), 'person-badge-fill', 'User Accounts', $seg === 'admin' && $subseg === 'users') ?>
            <?= sideLink(base_url('admin/roles'), 'shield-lock-fill', 'Roles & Access', $seg === 'admin' && $subseg === 'roles') ?>
        </div>

        <?php elseif ($role === 'teacher' || $role === 'coordinator'): ?>
        <div class="nav-group">
            <div class="nav-group-label">Overview</div>
            <?= sideLink(base_url('dashboard'), 'speedometer2', 'Dashboard', $seg === 'dashboard') ?>
        </div>
        <div class="nav-group">
            <div class="nav-group-label">Academic</div>
                    <?= sideLink(base_url('students'), 'people-fill', 'My Students', $seg === 'students') ?>
                    <?= sideLink(base_url('profile'), 'person-circle', 'Profile', $seg === 'profile' && !$subseg) ?>
                    <?= sideLink(base_url('profile/edit'), 'pencil-square', 'Edit Profile', $seg === 'profile' && $subseg === 'edit') ?>
        </div>

        <?php else: ?>
        <div class="nav-group">
            <div class="nav-group-label">My Space</div>
            <?= sideLink(base_url('student/dashboard'), 'house-door-fill', 'Home',     $seg === 'student') ?>
            <?= sideLink(base_url('profile'),           'person-circle',   'My Profile', $seg === 'profile' && !$subseg) ?>
            <?= sideLink(base_url('profile/edit'),      'pencil-square',   'Edit Profile', $seg === 'profile' && $subseg === 'edit') ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="sidebar-footer">
        <div class="dropdown dropup">
            <div class="sidebar-user" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="sidebar-avatar"><?= $initial ?></div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name"><?= esc($name) ?></div>
                    <div class="sidebar-user-role"><?= esc(ucfirst($role)) ?></div>
                </div>
                <i class="bi bi-three-dots-vertical" style="margin-left:auto;font-size:13px;color:rgba(255,255,255,.3);"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" style="margin-bottom:8px;min-width:200px;">
                <li>
                    <div style="padding:10px 14px 12px;border-bottom:1px solid var(--border);margin-bottom:4px;">
                        <div style="font-size:13px;font-weight:700;color:var(--text-1);"><?= esc($name) ?></div>
                        <div style="font-size:11px;color:var(--text-3);text-transform:capitalize;"><?= esc($role) ?></div>
                    </div>
                </li>
                <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="bi bi-person-fill"></i> My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right"></i> Sign out</a></li>
            </ul>
        </div>
    </div>
</aside>
