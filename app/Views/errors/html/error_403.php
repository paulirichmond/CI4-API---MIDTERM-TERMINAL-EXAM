<?php
/**
 * Custom 403 Access Denied view
 * Expects an optional $message variable passed by controllers.
 */
$message = $message ?? 'You do not have permission to access this page.';
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>403 Access Denied</title>
    <style>
        :root{--bg:#0b0b0d;--card:#0f1720;--muted:#9ca3af;--accent:#ff6b81}
        html,body{height:100%;margin:0}
        body{background:linear-gradient(180deg,#07070a 0%, #0b0b0d 100%);font-family:Inter,Segoe UI,Roboto,Arial,sans-serif;color:#fff;display:flex;align-items:center;justify-content:center}
        .box{max-width:820px;padding:48px 36px;text-align:center}
        .shield{width:84px;height:84px;margin:0 auto 22px;background:linear-gradient(180deg,#ff8a9e,#ff5b7a);border-radius:18px;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 30px rgba(0,0,0,0.6)}
        .shield svg{filter:drop-shadow(0 6px 18px rgba(255,80,120,0.15))}
        h1{font-size:36px;margin:8px 0 12px;color:#fff}
        p{color:var(--muted);margin:0 0 18px;font-size:14px;line-height:1.45}
        .hint{margin-top:18px;color:rgba(255,255,255,0.06);font-size:12px}
        .btn{display:inline-block;margin-top:18px;padding:10px 18px;border-radius:8px;background:rgba(255,255,255,0.04);color:#fff;text-decoration:none;border:1px solid rgba(255,255,255,0.04)}
        @media(max-width:560px){.box{padding:28px 18px}.shield{width:64px;height:64px}}
    </style>
</head>
<body>
    <div class="box">
        <div class="shield" aria-hidden="true">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L3 5v6c0 5.25 3.95 10.74 9 11 5.05-.26 9-5.75 9-11V5l-9-3z" fill="#fff" opacity="0.12"/>
                <path d="M12 7a3 3 0 100 6 3 3 0 000-6z" fill="#fff"/>
            </svg>
        </div>
        <h1>403 Access Denied</h1>
        <p><?php echo esc($message); ?></p>
        <div class="hint">If you believe this is an error, contact your system administrator.</div>
        <a class="btn" href="<?= base_url('dashboard') ?>">Return to dashboard</a>
    </div>
</body>
</html>