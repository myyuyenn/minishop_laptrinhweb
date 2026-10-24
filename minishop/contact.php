<?php
require_once __DIR__ . '/includes/init.php';

$pageTitle = 'Liên hệ';
require_once __DIR__ . '/includes/header.php';
?>
        <h2>Liên hệ</h2>

        <form action="<?= e(url('contact.php')) ?>" method="get" class="form" id="contact-form">
            <p>
                <label for="fullname">Họ và tên</label><br>
                <input type="text" id="fullname" name="fullname" required>
            </p>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" required>
            </p>
            <p>
                <label for="subject">Tiêu đề</label><br>
                <input type="text" id="subject" name="subject" required>
            </p>
            <p>
                <label for="message">Nội dung</label><br>
                <textarea id="message" name="message" rows="5" cols="40" required></textarea>
                <span class="error" id="message-error"></span>
            </p>
            <p>
                <button type="submit" class="btn">Gửi</button>
            </p>
        </form>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
