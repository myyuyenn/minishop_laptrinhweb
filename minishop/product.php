<?php
require __DIR__ . '/includes/init.php';

$idInput = $_GET['id'] ?? 0;
$id = is_scalar($idInput) ? (int) $idInput : 0;

$statement = $pdo->prepare(
    'SELECT p.*, c.name AS category_name
     FROM products p
     INNER JOIN categories c ON c.id = p.category_id
     WHERE p.id = ?'
);
$statement->execute([$id]);
$product = $statement->fetch();

if (!$product) {
    http_response_code(404);
    $pageTitle = 'Không tìm thấy sản phẩm';
    require __DIR__ . '/includes/header.php';
    ?>
    <h2>Không tìm thấy sản phẩm</h2>
    <p><a href="<?= e(url('index.php')) ?>">&laquo; Quay lại danh sách sản phẩm</a></p>
    <?php
    require __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $product['name'];
require __DIR__ . '/includes/header.php';
?>
<article class="product-detail">
    <div class="product-image">
        <img src="<?= e(url($product['image'])) ?>" alt="<?= e($product['name']) ?>">
    </div>

    <div class="product-info">
        <h2><?= e($product['name']) ?></h2>
        <p class="price">Giá: <strong><?= e(format_price($product['price'])) ?></strong></p>
        <?php if ($product['description'] !== null && $product['description'] !== ''): ?>
            <p><?= nl2br(e($product['description'])) ?></p>
        <?php endif; ?>

        <h3>Thông tin sản phẩm</h3>
        <table>
            <tbody>
                <tr>
                    <th>Mã sản phẩm</th>
                    <td><?= e($product['id']) ?></td>
                </tr>
                <tr>
                    <th>Danh mục</th>
                    <td><?= e($product['category_name']) ?></td>
                </tr>
                <tr>
                    <th>Tình trạng</th>
                    <td><?= (int) $product['stock'] > 0
                        ? 'Còn ' . e($product['stock']) . ' sản phẩm'
                        : 'Hết hàng' ?></td>
                </tr>
            </tbody>
        </table>

        <p><a href="<?= e(url('index.php')) ?>">&laquo; Quay lại danh sách sản phẩm</a></p>
    </div>
</article>
<?php require __DIR__ . '/includes/footer.php'; ?>
