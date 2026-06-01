<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — Digimon Academy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            background: #06061a;
            display: grid;
            place-items: center;
            padding: 24px 16px;
            -webkit-font-smoothing: antialiased;
            position: relative;
            overflow: hidden;
        }

        /* ── BACKGROUND MESH ── */
        .mesh {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(99,102,241,.28) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 80%, rgba(139,92,246,.22) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 60% 30%, rgba(37,99,235,.15) 0%, transparent 50%);
        }
        /* subtle grid lines */
        .mesh::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* ── WRAPPER ── */
        .page-wrap {
            position: relative; z-index: 1;
            width: 100%; max-width: 900px;
            display: flex; flex-direction: column; align-items: center; gap: 28px;
        }

        /* ── TOP BRAND ── */
        .top-brand {
            display: flex; align-items: center; gap: 12px;
        }
        .brand-mark {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 15px; font-weight: 800;
            box-shadow: 0 6px 20px rgba(99,102,241,.5);
        }
        .brand-info { text-align: left; }
        .brand-name { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -0.4px; line-height: 1; }
        .brand-sub  { font-size: 11px; color: rgba(255,255,255,.35); font-weight: 500; margin-top: 2px; }

        /* ── HERO TEXT ── */
        .hero-text { text-align: center; }
        .hero-text h1 {
            font-size: 48px; font-weight: 800; color: #fff;
            letter-spacing: -1.5px; line-height: 1.1; margin-bottom: 14px;
        }
        .hero-text h1 .grad {
            background: linear-gradient(135deg, #a5b4fc, #c4b5fd, #93c5fd);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-text p {
            font-size: 15px; color: rgba(255,255,255,.45);
            line-height: 1.75; max-width: 520px; margin: 0 auto; font-weight: 500;
        }

        /* ── MAIN CARD ── */
        .auth-wrap {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            background: rgba(255,255,255,.97);
            border-radius: 28px;
            box-shadow: 0 40px 100px rgba(0,0,0,.45), 0 0 0 1px rgba(255,255,255,.08);
            overflow: hidden;
        }

        /* Left info panel inside card */
        .card-info {
            background: linear-gradient(160deg, #1e1b4b 0%, #0f0e2a 100%);
            padding: 44px 40px;
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden;
        }
        .card-info::before {
            content: '';
            position: absolute; top: -60px; right: -60px;
            width: 220px; height: 220px; border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,.3), transparent 70%);
        }
        .card-info::after {
            content: '';
            position: absolute; bottom: -40px; left: -40px;
            width: 180px; height: 180px; border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,.25), transparent 70%);
        }
        .info-top { position: relative; z-index: 1; }
        .info-tag {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.1em; color: #a5b4fc;
            background: rgba(99,102,241,.2); border: 1px solid rgba(99,102,241,.3);
            padding: 4px 10px; border-radius: 99px; margin-bottom: 20px;
        }
        .info-heading {
            font-size: 26px; font-weight: 800; color: #fff;
            letter-spacing: -0.5px; line-height: 1.25; margin-bottom: 12px;
        }
        .info-heading span { color: #a5b4fc; }
        .info-desc { font-size: 13px; color: rgba(255,255,255,.4); line-height: 1.7; font-weight: 500; }

        .info-features { position: relative; z-index: 1; display: flex; flex-direction: column; gap: 10px; margin-top: 28px; }
        .feat {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 10px;
        }
        .feat-icon {
            width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
            background: rgba(99,102,241,.25); border: 1px solid rgba(99,102,241,.3);
            display: flex; align-items: center; justify-content: center;
            color: #a5b4fc; font-size: 13px;
        }
        .feat-title { font-size: 12px; font-weight: 700; color: rgba(255,255,255,.8); }
        .feat-desc  { font-size: 10px; color: rgba(255,255,255,.3); margin-top: 1px; }

        .info-footer { position: relative; z-index: 1; font-size: 11px; color: rgba(255,255,255,.2); margin-top: 24px; }

        /* Right form panel */
        .card-form { padding: 44px 44px; display: flex; flex-direction: column; justify-content: center; }

        .form-eyebrow {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.1em; color: #6366f1;
            background: #eef2ff; padding: 4px 10px; border-radius: 99px;
            margin-bottom: 16px; border: 1px solid #c7d2fe;
        }
        .form-heading { font-size: 26px; font-weight: 800; letter-spacing: -0.5px; color: #0f0e2a; margin-bottom: 6px; }
        .form-sub { font-size: 13px; color: #94a3b8; margin-bottom: 28px; font-weight: 500; line-height: 1.6; }

        .field { margin-bottom: 16px; }
        .field label { display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 7px; }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 14px; pointer-events: none; transition: color .15s;
        }
        .input-wrap input {
            width: 100%; height: 46px; padding: 0 44px 0 40px;
            border: 1.5px solid #e2e8f0; border-radius: 12px;
            font-size: 13.5px; font-family: inherit; color: #0f172a;
            background: #f8fafc; outline: none; transition: all .2s;
        }
        .input-wrap input:focus {
            border-color: #6366f1; background: #fff;
            box-shadow: 0 0 0 4px rgba(99,102,241,.12);
        }
        .input-wrap:focus-within .input-icon { color: #6366f1; }
        .input-wrap input::placeholder { color: #cbd5e1; }
        .eye-btn {
            position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #94a3b8; cursor: pointer;
            font-size: 15px; padding: 0; transition: color .15s;
        }
        .eye-btn:hover { color: #6366f1; }

        .btn-submit {
            width: 100%; height: 48px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff; border: none; border-radius: 12px;
            font-size: 14px; font-weight: 800; font-family: inherit;
            cursor: pointer; transition: all .2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 8px;
            box-shadow: 0 6px 20px rgba(99,102,241,.4);
            letter-spacing: 0.02em;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(99,102,241,.5); }
        .btn-submit:active { transform: translateY(0); }

        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 20px 0; color: #cbd5e1; font-size: 12px; font-weight: 600;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: #e2e8f0;
        }

        .role-pills {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px;
        }
        .role-pill {
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            padding: 8px 4px; border-radius: 10px;
            background: #f8fafc; border: 1.5px solid #e2e8f0;
            font-size: 10px; font-weight: 700; color: #94a3b8;
            transition: all .15s;
        }
        .role-pill i { font-size: 16px; }
        .role-pill.student { color: #6366f1; background: #eef2ff; border-color: #c7d2fe; }
        .role-pill.teacher { color: #059669; background: #ecfdf5; border-color: #a7f3d0; }
        .role-pill.coord   { color: #b45309; background: #fffbeb; border-color: #fde68a; }
        .role-pill.admin   { color: #0284c7; background: #f0f9ff; border-color: #bae6fd; }

        .form-footer { text-align: center; margin-top: 20px; font-size: 13px; color: #94a3b8; font-weight: 500; }
        .form-footer a { color: #6366f1; font-weight: 700; text-decoration: none; }
        .form-footer a:hover { text-decoration: underline; }

        .alert-box {
            display: flex; align-items: flex-start; gap: 9px;
            padding: 11px 14px; border-radius: 10px;
            font-size: 13px; font-weight: 600; margin-bottom: 18px; border: 1px solid;
        }
        .alert-error   { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
        .alert-success { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }

        @media (max-width: 700px) {
            .auth-wrap { grid-template-columns: 1fr; }
            .card-info { display: none; }
            .hero-text h1 { font-size: 32px; }
            .stats-strip { display: none; }
        }
    </style>
</head>
<body>

<div class="mesh"></div>

<div class="page-wrap">

    <!-- Brand -->
    <div class="top-brand">
        <div class="brand-mark">DA</div>
        <div class="brand-info">
            <div class="brand-name">Digimon Academy</div>
            <div class="brand-sub">School Management System</div>
        </div>
    </div>

    <!-- Hero -->
    <div class="hero-text">
        <h1>Your school.<br><span class="grad">One powerful portal.</span></h1>
        <p>Built for administrators, teachers, coordinators, and students — track progress, manage records, and collaborate seamlessly.</p>
    </div>

    <!-- Auth card -->
    <div class="auth-wrap">

        <!-- Left info -->
        <div class="card-info">
            <div class="info-top">
                <div class="info-tag"><i class="bi bi-mortarboard-fill"></i> Academic Platform</div>
                <div class="info-heading">Everything your<br>school needs,<br><span>in one place.</span></div>
                <div class="info-desc">Streamline enrollment, track academic performance, and manage your institution with confidence.</div>

                <div class="info-features">
                    <div class="feat">
                        <div class="feat-icon"><i class="bi bi-shield-lock-fill"></i></div>
                        <div>
                            <div class="feat-title">Role-based access control</div>
                            <div class="feat-desc">Admin · Teacher · Coordinator · Student</div>
                        </div>
                    </div>
                    <div class="feat">
                        <div class="feat-icon"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <div class="feat-title">Student & staff management</div>
                            <div class="feat-desc">Profiles, records, and enrollment tracking</div>
                        </div>
                    </div>
                    <div class="feat">
                        <div class="feat-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <div>
                            <div class="feat-title">Real-time analytics</div>
                            <div class="feat-desc">Enrollment trends and performance insights</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="info-footer">© <?= date('Y') ?> Digimon Academy. All rights reserved.</div>
        </div>

        <!-- Right form -->
        <div class="card-form">
            <div class="form-eyebrow"><i class="bi bi-mortarboard-fill"></i> Digimon Academy</div>
            <div class="form-heading">Sign in to your account</div>
            <div class="form-sub">Enter your credentials below to access the portal.</div>

            <?php if (session()->getFlashdata('notif_error')): ?>
            <div class="alert-box alert-error">
                <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;margin-top:1px;"></i>
                <span><?= session()->getFlashdata('notif_error') ?></span>
            </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('notif_success')): ?>
            <div class="alert-box alert-success">
                <i class="bi bi-check-circle-fill" style="flex-shrink:0;margin-top:1px;"></i>
                <span><?= session()->getFlashdata('notif_success') ?></span>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="POST">
                <div class="field">
                    <label for="inputEmail">Email address</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope-fill input-icon"></i>
                        <input type="email" id="inputEmail" name="inputEmail"
                               placeholder="you@school.edu" required autocomplete="email">
                    </div>
                </div>
                <div class="field">
                    <label for="inputPassword">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" id="inputPassword" name="inputPassword"
                               placeholder="Enter your password" required autocomplete="current-password">
                        <button type="button" class="eye-btn" onclick="togglePwd()">
                            <i class="bi bi-eye" id="eyeIco"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-box-arrow-in-right"></i> Sign in to Digimon Academy
                </button>
            </form>

            <div class="form-footer">
                Don't have an account? <a href="<?= base_url('register') ?>">Create one</a>
            </div>
        </div>

    </div>
</div>

<script>
function togglePwd() {
    const p = document.getElementById('inputPassword'), i = document.getElementById('eyeIco');
    p.type = p.type === 'password' ? 'text' : 'password';
    i.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
