<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-head">
    <div>
        <h1>Edit Student</h1>
        <p>Update the student record for <strong><?= esc($student['fullname'] ?? '') ?></strong>.</p>
    </div>
    <div class="page-head-actions">
        <a href="<?= site_url('students') ?>" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Students</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= site_url('students/update/' . $student['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="fullname" class="form-input" value="<?= esc($student['fullname']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email / Username</label>
                    <input type="email" name="username" class="form-input" value="<?= esc($student['username']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Student ID</label>
                    <input type="text" name="student_id" class="form-input" value="<?= esc($student['student_id'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Course</label>
                    <input type="text" name="course" class="form-input" value="<?= esc($student['course'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Year Level</label>
                    <input type="text" name="year_level" class="form-input" value="<?= esc($student['year_level'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Section</label>
                    <input type="text" name="section" class="form-input" value="<?= esc($student['section'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-input" value="<?= esc($student['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-input" value="<?= esc($student['address'] ?? '') ?>">
                </div>
            </div>

            <div style="margin-top:18px;display:flex;gap:10px;align-items:center;">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Changes</button>
                <a href="<?= site_url('students') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
