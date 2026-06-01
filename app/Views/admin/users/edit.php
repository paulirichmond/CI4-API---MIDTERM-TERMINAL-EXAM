<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-head">
    <div>
        <h1>Edit User</h1>
        <p>Modify user profile and contact information.</p>
    </div>
    <div class="page-head-actions">
        <a href="<?= base_url('/admin/users') ?>" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('/admin/users/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label class="form-label">Full name</label>
                    <input type="text" name="fullname" class="clean-input w-100" value="<?= esc($user['fullname']) ?>" required>
                </div>
                <div>
                    <label class="form-label">Email / Username</label>
                    <input type="text" name="username" class="clean-input w-100" value="<?= esc($user['username']) ?>" required>
                </div>
                <div>
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="clean-input w-100" value="<?= esc($user['phone'] ?? '') ?>">
                </div>
                <div>
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="clean-input w-100" value="<?= esc($user['address'] ?? '') ?>">
                </div>
                <div>
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="profile_image" accept="image/*" class="w-100">
                </div>
                <div>
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="clean-input w-100" placeholder="Leave blank to keep current">
                </div>
            </div>

            <div style="margin-top:12px;display:flex;gap:8px;">
                <button type="submit" class="clean-btn-primary"><i class="bi bi-save me-1"></i> Save</button>
                <a href="<?= base_url('/admin/users') ?>" class="btn-discard">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
