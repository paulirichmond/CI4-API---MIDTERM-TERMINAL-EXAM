<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account — Digimon Academy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: #0a0a1a;
            display: flex; align-items: center; justify-content: center;
            padding: 32px 16px;
            -webkit-font-smoothing: antialiased;
        }

        .bg-orbs { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .orb { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.35; animation: drift 12s ease-in-out infinite alternate; }
        .orb-1 { width: 500px; height: 500px; background: #4f46e5; top: -150px; left: -100px; animation-delay: 0s; }
        .orb-2 { width: 400px; height: 400px; background: #7c3aed; bottom: -100px; right: -100px; animation-delay: -4s; }
        .orb-3 { width: 300px; height: 300px; background: #2563eb; top: 40%; left: 50%; animation-delay: -8s; }
        @keyframes drift { from { transform: translate(0,0) scale(1); } to { transform: translate(40px,30px) scale(1.08); } }

        .register-wrap { width: 100%; max-width: 500px; position: relative; z-index: 1; }

        .reg-brand {
            display: flex; align-items: center; gap: 10px;
            justify-content: center; margin-bottom: 24px;
        }
        .brand-mark {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 13px; font-weight: 800;
            box-shadow: 0 4px 14px rgba(99,102,241,.5);
        }
        .brand-name { font-size: 16px; font-weight: 700; color: #fff; }

        .reg-card {
            background: rgba(255,255,255,.97);
            border-radius: 24px;
            box-shadow: 0 32px 80px rgba(0,0,0,.35), 0 0 0 1px rgba(255,255,255,.1);
            overflow: hidden;
        }

        .reg-card-head {
            padding: 28px 36px 22px;
            border-bottom: 1px solid #f1f0ff;
        }
        .reg-eyebrow {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.1em; color: #6366f1;
            background: #eef2ff; padding: 4px 10px; border-radius: 99px;
            margin-bottom: 12px;
        }
        .reg-card-head h1 { font-size: 22px; font-weight: 800; letter-spacing: -0.4px; color: #0f0e2a; margin-bottom: 4px; }
        .reg-card-head p  { font-size: 13px; color: #94a3b8; }

        .reg-card-body { padding: 24px 36px; }

        /* Role selector */
        .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 20px; }
        .role-card { position: relative; cursor: pointer; }
        .role-card input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .role-label {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            cursor: pointer; transition: all .15s; background: #f8fafc;
        }
        .role-label:hover { border-color: #a5b4fc; background: #eef2ff; }
        .role-card input:checked + .role-label {
            border-color: #6366f1; background: #eef2ff;
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        }
        .role-icon {
            width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; background: #e0e7ff; color: #6366f1; transition: all .15s;
        }
        .role-card input:checked + .role-label .role-icon { background: #6366f1; color: #fff; }
        .role-text-name { font-size: 12px; font-weight: 700; color: #0f172a; }
        .role-text-desc { font-size: 10px; color: #94a3b8; margin-top: 1px; }

        .field { margin-bottom: 15px; }
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 15px; }
        .field label { display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px; }
        .input-wrap { position: relative; }
        .input-wrap .input-icon {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 13px; pointer-events: none; transition: color .15s;
        }
        .input-wrap input {
            width: 100%; height: 42px; padding: 0 12px 0 36px;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 13px; font-family: inherit; color: #0f172a;
            background: #f8fafc; outline: none; transition: all .2s;
        }
        .input-wrap input:focus {
            border-color: #6366f1; background: #fff;
            box-shadow: 0 0 0 4px rgba(99,102,241,.12);
        }
        .input-wrap:focus-within .input-icon { color: #6366f1; }
        .input-wrap input::placeholder { color: #cbd5e1; }

        .section-label {
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em; color: #94a3b8; margin-bottom: 10px;
        }

        .btn-submit {
            width: 100%; height: 46px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff; border: none; border-radius: 10px;
            font-size: 14px; font-weight: 700; font-family: inherit;
            cursor: pointer; transition: all .2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 4px;
            box-shadow: 0 4px 16px rgba(99,102,241,.4);
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(99,102,241,.5); }
        .btn-submit:active { transform: translateY(0); }

        .reg-card-foot {
            padding: 16px 36px 20px;
            background: #fafaf9; border-top: 1px solid #f1f0ff;
            text-align: center; font-size: 13px; color: #94a3b8;
        }
        .reg-card-foot a { color: #6366f1; font-weight: 700; text-decoration: none; }
        .reg-card-foot a:hover { text-decoration: underline; }

        .alert-box {
            display: flex; align-items: flex-start; gap: 9px;
            padding: 11px 14px; border-radius: 10px;
            font-size: 13px; font-weight: 500; margin-bottom: 16px; border: 1px solid;
        }
        .alert-error { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
    </style>
</head>
<body>

<div class="bg-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>

<div class="register-wrap">
    <div class="reg-brand">
        <div class="brand-mark">DA</div>
        <span class="brand-name">Digimon Academy</span>
    </div>

    <div class="reg-card">
        <div class="reg-card-head">
            <div class="reg-eyebrow"><i class="bi bi-person-plus-fill"></i> New account</div>
            <h1>Create your account</h1>
            <p>Join Digimon Academy — select your role and fill in your details.</p>
        </div>

        <div class="reg-card-body">
            <?php if (session()->getFlashdata('notif_error')): ?>
            <div class="alert-box alert-error">
                <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;margin-top:1px;"></i>
                <span><?= session()->getFlashdata('notif_error') ?></span>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="POST">
                <div class="field">
                    <label>Select your role</label>
                    <div class="role-grid">
                        <?php
                        $roles = [
                            ['student',     'bi-mortarboard-fill',  'Student',     'Enrolled learner'],
                            ['teacher',     'bi-person-workspace',  'Teacher',     'Faculty member'],
                            ['coordinator', 'bi-diagram-3-fill',    'Coordinator', 'Program coordinator'],
                            ['admin',       'bi-shield-fill',       'Admin',       'System administrator'],
                        ];
                        $selectedRole = old('inputRole', 'student');
                        foreach ($roles as [$val, $icon, $name, $desc]):
                        ?>
                        <label class="role-card">
                            <input type="radio" name="inputRole" value="<?= $val ?>" <?= $selectedRole === $val ? 'checked' : '' ?> required>
                            <div class="role-label">
                                <div class="role-icon"><i class="bi <?= $icon ?>"></i></div>
                                <div>
                                    <div class="role-text-name"><?= $name ?></div>
                                    <div class="role-text-desc"><?= $desc ?></div>
                                </div>
                            </div>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="section-label">Personal information</div>

                <div class="field">
                    <label>Full name</label>
                    <div class="input-wrap">
                        <i class="bi bi-person-fill input-icon"></i>
                        <input type="text" name="inputFullname" placeholder="Juan dela Cruz" value="<?= old('inputFullname') ?>" required autocomplete="name">
                    </div>
                </div>
                <div class="field">
                    <label>Email address</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope-fill input-icon"></i>
                        <input type="email" name="inputEmail" placeholder="you@school.edu" value="<?= old('inputEmail') ?>" required autocomplete="email">
                    </div>
                </div>

                <div class="section-label" style="margin-top:4px;">Security</div>

                <div class="field-row">
                    <div class="field" style="margin-bottom:0;">
                        <label>Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" name="inputPassword" placeholder="Min. 6 characters" required>
                        </div>
                    </div>
                    <div class="field" style="margin-bottom:0;">
                        <label>Confirm password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" name="inputPassword2" placeholder="Repeat password" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit" style="margin-top:20px;">
                    <i class="bi bi-person-check-fill"></i> Create account
                </button>
            </form>
        </div>

        <div class="reg-card-foot">
            Already have an account? <a href="<?= base_url('/') ?>">Sign in</a>
        </div>
    </div>
</div>

</body>
</html>
