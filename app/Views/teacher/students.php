<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Page Head -->
<div class="page-head">
    <div>
        <h1>Student Management</h1>
        <p>View and manage all enrolled students in Digimon Academy.</p>
    </div>
    <div class="page-head-actions">
        <span class="badge badge-indigo" style="font-size:12px;padding:6px 12px;">
            <i class="bi bi-people-fill"></i> <?= count($students) ?> Enrolled
        </span>
    </div>
</div>

<!-- Search Bar -->
<div style="margin-bottom:16px;">
    <div style="position:relative;max-width:100%;">
        <i class="bi bi-search" style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:var(--text-3);font-size:15px;pointer-events:none;"></i>
        <input type="text" id="searchInput"
               placeholder="Search by name, student ID, course, email..."
               style="width:100%;height:46px;padding:0 48px 0 44px;border:1.5px solid var(--border);border-radius:12px;font-size:14px;font-family:inherit;color:var(--text-1);background:var(--surface);outline:none;transition:all .2s;box-shadow:var(--shadow-xs);">
        <span style="position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:11px;color:var(--text-3);background:var(--bg);border:1px solid var(--border);padding:2px 7px;border-radius:5px;font-family:inherit;">Search</span>
    </div>
</div>

<!-- Students Card -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="bi bi-table" style="color:var(--indigo);"></i>
            All Enrolled Students
        </div>
        <span class="badge badge-indigo" style="font-size:12px;padding:5px 12px;">
            <i class="bi bi-people-fill"></i> <?= count($students) ?> Students
        </span>
    </div>

    <div class="data-table-wrap">
        <table class="data-table" id="studentTable">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Student</th>
                    <th>Student ID</th>
                    <th>Course</th>
                    <th>Year & Section</th>
                    <th>Email</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)): ?>
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>No students enrolled yet.</p>
                        </div>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($students as $i => $s): ?>
                <tr>
                    <td style="color:var(--text-3);font-size:12px;"><?= $i + 1 ?></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <?php if (!empty($s['profile_image'])): ?>
                                <img src="<?= base_url('uploads/profiles/' . esc($s['profile_image'])) ?>"
                                     style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid var(--border);" alt="">
                            <?php else: ?>
                                <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:12px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <?= strtoupper(substr($s['name'] ?? 'U', 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <span style="font-weight:700;color:var(--text-1);"><?= esc($s['name']) ?></span>
                        </div>
                    </td>
                    <td style="color:var(--text-2);font-size:12px;"><?= esc($s['student_id'] ?? '—') ?></td>
                    <td>
                        <?php if (!empty($s['course'])): ?>
                            <span class="badge badge-indigo"><?= esc($s['course']) ?></span>
                        <?php else: ?>
                            <span style="color:var(--text-3);">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="color:var(--text-2);font-size:12px;">
                        <?php
                        $yl = $s['year_level'] ? 'Year '.$s['year_level'] : '';
                        $sec = $s['section'] ? ' · '.$s['section'] : '';
                        echo ($yl || $sec) ? esc($yl.$sec) : '—';
                        ?>
                    </td>
                    <td style="color:var(--text-3);font-size:12px;"><?= esc($s['email']) ?></td>
                    <td style="text-align:center;">
                        <a href="<?= site_url('students/show/' . $s['id']) ?>" class="btn btn-secondary btn-xs">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <?php if (in_array(session('user')['role'] ?? '', ['teacher','admin','coordinator'])): ?>
                        <a href="<?= site_url('students/edit/' . $s['id']) ?>" class="btn btn-primary btn-xs" style="margin-left:6px;">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('focus', () => {
    searchInput.style.borderColor = '#6366f1';
    searchInput.style.boxShadow = '0 0 0 4px rgba(99,102,241,.12)';
    searchInput.style.background = '#fff';
});
searchInput.addEventListener('blur', () => {
    searchInput.style.borderColor = 'var(--border)';
    searchInput.style.boxShadow = 'var(--shadow-xs)';
    searchInput.style.background = 'var(--surface)';
});
searchInput.addEventListener('keyup', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#studentTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
<?= $this->endSection() ?>
