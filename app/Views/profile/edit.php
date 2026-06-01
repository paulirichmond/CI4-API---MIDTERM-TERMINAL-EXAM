<?= $this->extend('layouts/main') ?>

<?= $this->section('breadcrumb') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data" id="profileForm">
    <?= csrf_field() ?>

    <style>
    /* Local styles to enhance the Edit Profile UI */
    .clean-card{background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border-radius:16px}
    .clean-input{background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);padding:10px 12px;border-radius:10px;color:var(--text-primary);transition:box-shadow .18s, border-color .18s, transform .12s}
    .clean-input:focus{outline:none;box-shadow:0 10px 30px rgba(99,102,241,0.09);border-color:rgba(99,102,241,0.7);transform:translateY(-1px)}
    .clean-btn-primary{background:linear-gradient(90deg,#059669,#10b981);color:#fff;border-radius:10px;padding:8px 14px;font-weight:700;box-shadow:0 8px 24px rgba(16,185,129,0.12);transition:transform .15s, box-shadow .15s, opacity .12s}
    .clean-btn-primary:hover{transform:translateY(-3px);box-shadow:0 18px 40px rgba(16,185,129,0.18);opacity:0.98}
    .btn-discard{background:linear-gradient(90deg, rgba(239,68,68,0.06), rgba(239,68,68,0.04));border:1px solid rgba(239,68,68,0.18);color:#ef4444;border-radius:10px;padding:8px 14px;transition:transform .15s, box-shadow .15s, background .12s}
    .btn-discard:hover{background:linear-gradient(90deg,#fb7185,#ef4444);color:#fff;transform:translateY(-3px);box-shadow:0 12px 30px rgba(239,68,68,0.12)}
    label.form-label{color:var(--text-secondary);font-weight:700}
    .section-header{background:rgba(255,255,255,0.02);padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.03);}
    select.clean-input option{background:transparent;color:var(--text-primary)}
    /* Make form links and nav items have subtle hover lifts */
    a.btn, .clean-card a{transition:transform .12s, box-shadow .12s}
    a.btn:hover, .clean-card a:hover{transform:translateY(-2px)}
    @media (prefers-color-scheme: light){
        .clean-card{background:#fff}
        .clean-input{background:#fff;border:1px solid #e6e6f0;color:#0f172a}
        .clean-btn-primary{box-shadow:0 6px 20px rgba(3,105,83,0.08)}
        .btn-discard{background:transparent;border:1px solid rgba(239,68,68,0.08);color:#dc2626}
        .btn-discard:hover{background:#ef4444;color:#fff}
    }
    </style>

    <?php if (session('errors')): ?>
        <div class="alert d-flex align-items-start gap-2 mb-4" style="background: rgba(251,113,133,0.1); border: 1px solid rgba(251,113,133,0.3); border-radius: var(--radius-md); color: #fb7185; font-size: 0.875rem;">
            <i class="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="pb-5">
        <!-- Cover Header -->
        <div class="clean-card mb-4 border-0 position-relative" style="box-shadow: 0 8px 32px rgba(0,0,0,0.5);">
            <div style="height: 160px; background: var(--accent-gradient); border-radius: var(--radius-md) var(--radius-md) 0 0; opacity: 0.85;"></div>
            <div class="px-4 px-md-5 pb-4 d-flex flex-column flex-md-row align-items-center align-items-md-end" style="margin-top: -65px;">
                <!-- Avatar -->
                <div class="position-relative me-md-4 mb-3 mb-md-0 flex-shrink-0">
                    <?php if (!empty($user['profile_image'])): ?>
                        <img id="preview" src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>" alt="Profile"
                            style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 4px solid var(--bg-page); box-shadow: 0 4px 20px rgba(0,0,0,0.6); display: block;">
                    <?php else: ?>
                        <div id="preview" style="width: 130px; height: 130px; border-radius: 50%; background: rgba(255,255,255,0.05); color: var(--text-secondary); display: flex; justify-content: center; align-items: center; border: 4px solid var(--bg-page); box-shadow: 0 4px 20px rgba(0,0,0,0.6);">
                            <i class="bi bi-person-fill" style="font-size: 4.5rem;"></i>
                        </div>
                    <?php endif; ?>

                    <label for="profile_image" id="cameraBtn" title="Change photo"
                        class="position-absolute bottom-0 end-0 d-flex align-items-center justify-content-center rounded-circle"
                        style="width: 38px; height: 38px; cursor: pointer; background: var(--accent-gradient); color: #fff; border: 2px solid var(--bg-page); box-shadow: 0 2px 8px rgba(99,102,241,0.5); transition: transform 0.2s;">
                        <i class="bi bi-camera-fill" style="font-size: 0.95rem;"></i>
                    </label>
                    <input type="file" name="profile_image" id="profile_image" class="d-none" accept="image/jpeg,image/png,image/webp">
                </div>

                <div class="flex-grow-1 text-center text-md-start">
                    <h4 class="mb-1" style="font-weight: 700; color: var(--text-primary);"><?= esc($user['fullname']) ?></h4>
                    <p class="mb-0" style="color: var(--text-secondary); font-size: 0.9rem;">
                        <i class="bi bi-pencil-square me-1"></i>Editing your profile
                    </p>
                    <p id="fileInfo" class="mb-0 mt-1" style="font-size: 0.78rem; color: var(--accent-hover); display: none;"></p>
                </div>

                <div class="ms-md-auto d-flex gap-2 mt-3 mt-md-0">
                    <a href="<?= base_url('profile') ?>" class="btn-discard">
                        <i class="bi bi-x-lg me-1"></i>Discard
                    </a>
                    <button type="submit" class="clean-btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Personal Details -->
            <div class="col-lg-6">
                <div class="clean-card h-100 border-0">
                    <div class="p-4 border-bottom border-light" style="background: rgba(255,255,255,0.02);">
                        <h6 class="mb-0 text-indigo-600" style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;">
                            <i class="bi bi-person-vcard me-2"></i>Personal Details
                        </h6>
                    </div>
                    <div class="p-4">
                        <div class="mb-4">
                            <label class="form-label text-muted" style="font-size: 0.82rem; font-weight: 600;">Full Name <span class="text-rose-600">*</span></label>
                            <input type="text" name="fullname"
                                class="clean-input w-100 <?= session('errors.fullname') ? 'border-danger' : '' ?>"
                                value="<?= old('fullname', esc($user['fullname'])) ?>" required
                                placeholder="Your full name">
                            <?php if (session('errors.fullname')): ?>
                                <div class="mt-1 d-flex align-items-center gap-1" style="font-size: 0.75rem; color: #fb7185;">
                                    <i class="bi bi-exclamation-circle-fill"></i><?= session('errors.fullname') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted" style="font-size: 0.82rem; font-weight: 600;">Email / Username <span class="text-rose-600">*</span></label>
                            <input type="text" name="username"
                                class="clean-input w-100 <?= session('errors.username') ? 'border-danger' : '' ?>"
                                value="<?= old('username', esc($user['username'])) ?>" required
                                placeholder="your@email.com">
                            <?php if (session('errors.username')): ?>
                                <div class="mt-1 d-flex align-items-center gap-1" style="font-size: 0.75rem; color: #fb7185;">
                                    <i class="bi bi-exclamation-circle-fill"></i><?= session('errors.username') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted" style="font-size: 0.82rem; font-weight: 600;">Phone Number</label>
                            <div class="position-relative">
                                <span class="position-absolute" style="left: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 0.9rem; pointer-events: none;">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="tel" name="phone" class="clean-input w-100" style="padding-left: 2.4rem;"
                                    value="<?= old('phone', esc($user['phone'] ?? '')) ?>"
                                    placeholder="+63 9XX XXX XXXX">
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label text-muted d-flex justify-content-between" style="font-size: 0.82rem; font-weight: 600;">
                                <span>Home Address</span>
                                <span id="addrCount" style="font-weight: 400; color: #52525b;">0 / 255</span>
                            </label>
                            <textarea name="address" id="addressField" rows="3" class="clean-input w-100" maxlength="255"
                                placeholder="Street, City, Province"><?= old('address', esc($user['address'] ?? '')) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Record -->
            <div class="col-lg-6 d-flex flex-column gap-4">
                <?php $myrole = session('user')['role'] ?? 'student'; ?>
                <?php if (! in_array($myrole, ['teacher','coordinator'])): ?>
                <div class="clean-card border-0">
                    <div class="p-4 border-bottom border-light" style="background: rgba(255,255,255,0.02);">
                        <h6 class="mb-0 text-emerald-600" style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;">
                            <i class="bi bi-mortarboard me-2"></i>Academic Record
                        </h6>
                    </div>
                    <div class="p-4">
                        <div class="mb-4">
                            <label class="form-label text-muted" style="font-size: 0.82rem; font-weight: 600;">Student ID</label>
                            <input type="text" name="student_id" class="clean-input w-100"
                                value="<?= old('student_id', esc($user['student_id'] ?? '')) ?>"
                                placeholder="e.g. 2024-00001">
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted" style="font-size: 0.82rem; font-weight: 600;">Course / Program</label>
                            <input type="text" name="course" class="clean-input w-100"
                                value="<?= old('course', esc($user['course'] ?? '')) ?>"
                                placeholder="e.g. BS Computer Science">
                        </div>

                        <div class="row g-3 mb-0">
                            <div class="col-6">
                                <label class="form-label text-muted" style="font-size: 0.82rem; font-weight: 600;">Year Level</label>
                                <select name="year_level" class="clean-input w-100">
                                    <option value="">— Select —</option>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?= $i ?>"
                                            <?= old('year_level', $user['year_level'] ?? '') == $i ? 'selected' : '' ?>>
                                            Year <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted" style="font-size: 0.82rem; font-weight: 600;">Section</label>
                                <input type="text" name="section" class="clean-input w-100"
                                    value="<?= old('section', esc($user['section'] ?? '')) ?>"
                                    placeholder="e.g. A, B, C">
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Change Password -->
                <div class="clean-card border-0">
                    <div class="p-4 border-bottom border-light" style="background: rgba(255,255,255,0.02);">
                        <h6 class="mb-0 text-amber-600" style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;">
                            <i class="bi bi-shield-lock me-2"></i>Change Password
                            <span style="font-weight: 400; text-transform: none; font-size: 0.75rem; color: var(--text-secondary); letter-spacing: 0;"> — leave blank to keep current</span>
                        </h6>
                    </div>
                    <div class="p-4">
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 0.82rem; font-weight: 600;">New Password</label>
                            <div class="position-relative">
                                <input type="password" name="new_password" id="newPassword" class="clean-input w-100" style="padding-right: 2.8rem;"
                                    placeholder="Min. 8 characters" autocomplete="new-password">
                                <button type="button" class="toggle-pw position-absolute border-0 bg-transparent p-0"
                                    style="right: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); cursor: pointer;" data-target="newPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label text-muted" style="font-size: 0.82rem; font-weight: 600;">Confirm Password</label>
                            <div class="position-relative">
                                <input type="password" name="confirm_password" id="confirmPassword" class="clean-input w-100" style="padding-right: 2.8rem;"
                                    placeholder="Repeat new password" autocomplete="new-password">
                                <button type="button" class="toggle-pw position-absolute border-0 bg-transparent p-0"
                                    style="right: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); cursor: pointer;" data-target="confirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div id="pwMismatch" class="mt-1 d-none d-flex align-items-center gap-1" style="font-size: 0.75rem; color: #fb7185;">
                                <i class="bi bi-exclamation-circle-fill"></i>Passwords do not match
                            </div>
                            <div style="display:flex;gap:8px;margin-top:12px;align-items:center;">
                                <button type="button" id="updatePwBtn" class="clean-btn-primary" style="background:linear-gradient(90deg,#059669,#10b981);padding:8px 12px;font-size:0.9rem;"> 
                                    <i class="bi bi-key-fill me-1"></i> Update Password
                                </button>
                                <button type="submit" name="update_password_submit" class="btn-discard" title="Fallback: submit the form to update password">
                                    <i class="bi bi-arrow-repeat me-1"></i> Update (fallback)
                                </button>
                                <div id="pwStatus" style="align-self:center;font-size:0.9rem;color:var(--text-secondary)"></div>
                            </div>
                            <noscript><div style="margin-top:8px;color:#fb7185;font-size:0.9rem">JavaScript is disabled — use the <strong>Update (fallback)</strong> button to submit the form.</div></noscript>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
(function () {
    // --- Avatar preview ---
    const fileInput = document.getElementById('profile_image');
    const fileInfo  = document.getElementById('fileInfo');

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('Image must be under 2 MB.');
            this.value = '';
            return;
        }
        fileInfo.textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        fileInfo.style.display = 'block';

        const reader = new FileReader();
        reader.onload = (e) => {
            const prev = document.getElementById('preview');
            if (prev.tagName === 'IMG') {
                prev.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.id = 'preview';
                img.alt = 'Profile';
                img.src = e.target.result;
                img.style.cssText = prev.style.cssText;
                prev.parentNode.replaceChild(img, prev);
            }
        };
        reader.readAsDataURL(file);
    });

    // Camera button hover effect
    const camBtn = document.getElementById('cameraBtn');
    camBtn.addEventListener('mouseenter', () => camBtn.style.transform = 'scale(1.15)');
    camBtn.addEventListener('mouseleave', () => camBtn.style.transform = 'scale(1)');

    // --- Address character counter ---
    const addr      = document.getElementById('addressField');
    const addrCount = document.getElementById('addrCount');
    const updateCount = () => addrCount.textContent = addr.value.length + ' / 255';
    addr.addEventListener('input', updateCount);
    updateCount();

    // --- Password toggle visibility ---
    document.querySelectorAll('.toggle-pw').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const icon  = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        });
    });

    // --- Password match validation ---
    const newPw  = document.getElementById('newPassword');
    const confPw = document.getElementById('confirmPassword');
    const mismatch = document.getElementById('pwMismatch');

    function checkPw() {
        if (confPw.value && newPw.value !== confPw.value) {
            mismatch.classList.remove('d-none');
            confPw.style.borderColor = '#fb7185';
        } else {
            mismatch.classList.add('d-none');
            confPw.style.borderColor = '';
        }
    }
    newPw.addEventListener('input', checkPw);
    confPw.addEventListener('input', checkPw);

    // Prevent submit if passwords mismatch
    document.getElementById('profileForm').addEventListener('submit', function (e) {
        if (newPw.value && newPw.value !== confPw.value) {
            e.preventDefault();
            confPw.focus();
            mismatch.classList.remove('d-none');
        }
    });

    // --- Update password via AJAX (submit only password fields) ---
    const updateBtn = document.getElementById('updatePwBtn');
    const pwStatus  = document.getElementById('pwStatus');
    updateBtn.addEventListener('click', function () {
        // Basic client-side validation
        if (!newPw.value) {
            pwStatus.textContent = 'Enter a new password';
            pwStatus.style.color = '#fb7185';
            return;
        }
        if (newPw.value.length < 8) {
            pwStatus.textContent = 'Password must be at least 8 characters';
            pwStatus.style.color = '#fb7185';
            return;
        }
        if (newPw.value !== confPw.value) {
            pwStatus.textContent = 'Passwords do not match';
            pwStatus.style.color = '#fb7185';
            return;
        }

        // Find CSRF token input inside the form
        const csrfInput = document.querySelector('#profileForm input[type=hidden][name]');
        const fd = new FormData();
        if (csrfInput) fd.append(csrfInput.name, csrfInput.value);
        fd.append('new_password', newPw.value);
        fd.append('confirm_password', confPw.value);

        updateBtn.disabled = true;
        updateBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
        pwStatus.textContent = '';

        fetch('<?= base_url('profile/update') ?>', {
            method: 'POST',
            credentials: 'same-origin',
            body: fd
        }).then(r => {
            updateBtn.disabled = false;
            updateBtn.innerHTML = '<i class="bi bi-key-fill me-1"></i> Update Password';
            if (r.ok) {
                pwStatus.textContent = 'Password updated';
                pwStatus.style.color = '#34d399';
                // Clear password fields
                newPw.value = '';
                confPw.value = '';
                mismatch.classList.add('d-none');
            } else {
                pwStatus.textContent = 'Failed to update';
                pwStatus.style.color = '#fb7185';
            }
        }).catch(() => {
            updateBtn.disabled = false;
            updateBtn.innerHTML = '<i class="bi bi-key-fill me-1"></i> Update Password';
            pwStatus.textContent = 'Network error';
            pwStatus.style.color = '#fb7185';
        });
    });
})();
</script>
<?= $this->endSection() ?>
