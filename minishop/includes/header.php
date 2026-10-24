<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'MiniShop') ?> - MiniShop</title>
    <link rel="stylesheet" href="<?= e(url('css/style.css')) ?>">
    <script src="<?= e(url('js/main.js')) ?>" defer></script>
</head>
<body>
    <header class="site-header">
        <h1>MiniShop</h1>
        <nav class="main-nav">
            <a href="<?= e(url('index.php')) ?>"<?= basename($_SERVER['SCRIPT_NAME'] ?? '') === 'index.php' ? ' class="active"' : '' ?>>Trang chủ</a>
            <a href="<?= e(url('about.php')) ?>"<?= basename($_SERVER['SCRIPT_NAME'] ?? '') === 'about.php' ? ' class="active"' : '' ?>>Giới thiệu</a>
            <a href="<?= e(url('contact.php')) ?>"<?= basename($_SERVER['SCRIPT_NAME'] ?? '') === 'contact.php' ? ' class="active"' : '' ?>>Liên hệ</a>
            <a href="<?= e(url('cart.php')) ?>"<?= basename($_SERVER['SCRIPT_NAME'] ?? '') === 'cart.php' ? ' class="active"' : '' ?>>Giỏ hàng <span id="cart-count">0</span></a>
            <a href="<?= e(url('login.php')) ?>"<?= basename($_SERVER['SCRIPT_NAME'] ?? '') === 'login.php' ? ' class="active"' : '' ?>>Đăng nhập</a>
            <a href="<?= e(url('register.php')) ?>"<?= basename($_SERVER['SCRIPT_NAME'] ?? '') === 'register.php' ? ' class="active"' : '' ?>>Đăng ký</a>
        </nav>
    </header>
    <main>
