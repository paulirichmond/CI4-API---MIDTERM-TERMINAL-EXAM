<?= $this->extend('layouts/main') ?>
<?= $this->section('breadcrumb') ?>
<div class="row align-items-center">
    <div class="col-sm-6">
        <h3 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill me-2 text-success"></i><?= esc($student['fullname']) ?></h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('/students') ?>">Students</a></li>
            <li class="breadcrumb-item active"><?= esc($student['fullname']) ?></li>
        </ol>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-4 justify-content-center">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body py-5">
                <?php if (!empty($student['profile_image'])): ?>
                    <img src="<?= base_url('uploads/profiles/' . esc($student['profile_image'])) ?>"
                         class="rounded-circle border border-4 border-success shadow mb-3"
                         style="width:130px;height:130px;object-fit:cover;" alt="Avatar">
                <?php else: ?>
                    <div class="rounded-circle bg-success bg-opacity-10 border border-4 border-success
                                d-inline-flex align-items-center justify-content-center mb-3 shadow"
                         style="width:130px;height:130px;">
                        <i class="bi bi-person-fill text-success" style="font-size:3.5rem;"></i>
                    </div>
                <?php endif; ?>
                <h5 class="fw-bold mb-1"><?= esc($student['fullname']) ?></h5>
                <p class="text-muted small mb-3"><?= esc($student['username']) ?></p>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                    <?= esc($student['course'] ?? 'No course set') ?>
                </span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0"><i class="bi bi-id-card me-2 text-success"></i>Student Details</h6>
                <span class="badge bg-success">
                    <i class="bi bi-mortarboard me-1"></i><?= esc($student['role_label'] ?? 'Student') ?>
                </span>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <?php
                    $fields = [
                        ['bi-hash',        'Student ID',  $student['student_id'] ?? null],
                        ['bi-person',      'Full Name',   $student['fullname']],
                        ['bi-mortarboard', 'Course',      $student['course'] ?? null],
                        ['bi-layers',      'Year Level',  $student['year_level'] ? 'Year ' . $student['year_level'] : null],
                        ['bi-people',      'Section',     $student['section'] ?? null],
                        ['bi-envelope',    'Email',       $student['username']],
                        ['bi-telephone',   'Phone',       $student['phone'] ?? null],
                        ['bi-geo-alt',     'Address',     $student['address'] ?? null],
                    ];
                    foreach ($fields as [$icon, $label, $val]): ?>
                    <div class="col-sm-6">
                        <p class="text-muted small mb-1"><i class="bi <?= $icon ?> me-1"></i><?= $label ?></p>
                        <p class="fw-semibold mb-0">
                            <?= $val ? esc($val) : '<span class="text-muted fst-italic small">Not set</span>' ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <hr class="my-4">
                <div class="text-muted small">
                    <i class="bi bi-calendar-check me-1"></i>
                    Enrolled: <strong><?= date('F d, Y', strtotime($student['created_at'])) ?></strong>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-3">
                <div style="display:flex;gap:8px;align-items:center;">
                    <a href="<?= base_url('/students') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Back to Student List
                    </a>
                    <?php
                    $currentRole = strtolower(session('user')['role'] ?? '');
                    $viewedRole  = strtolower($student['role_name'] ?? $student['role_label'] ?? 'student');
                    // Allow edit only for admins, or for teachers when the viewed account is not an admin
                    $canEdit = false;
                    if ($currentRole === 'admin') {
                        $canEdit = true;
                    } elseif ($currentRole === 'teacher' && $viewedRole !== 'admin') {
                        $canEdit = true;
                    } elseif ($currentRole === 'coordinator') {
                        $canEdit = true;
                    }
                    if ($canEdit): ?>
                    <a href="<?= site_url('students/edit/' . $student['id']) ?>" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>Edit Student Profile
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
