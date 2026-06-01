<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-head">
    <div class="page-head-left">
        <h1>Edit Student</h1>
        <p>Update the profile details for <strong><?= esc($student['name'] ?? '') ?></strong>.</p>
    </div>
    <div class="page-head-actions">
        <a href="<?= site_url('students') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Students
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= site_url('student/update/' . $student['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" value="<?= esc($student['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="<?= esc($student['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Course</label>
                    <input type="text" name="course" class="form-input" value="<?= esc($student['course']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Student ID</label>
                    <input type="text" class="form-input" value="<?= esc($student['student_id'] ?? '') ?>" disabled>
                </div>
            </div>
            <div style="margin-top:18px;display:flex;gap:10px;align-items:center;">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Save Changes
                </button>
                <a href="<?= site_url('students') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>