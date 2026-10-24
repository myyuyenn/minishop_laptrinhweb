<?php
require __DIR__ . '/includes/init.php';

$categoryInput = $_GET['category'] ?? 0;
$categoryId = is_scalar($categoryInput) ? (int) $categoryInput : 0;
$keywordInput = $_GET['q'] ?? '';
$keyword = is_string($keywordInput) ? trim($keywordInput) : '';

$categories = $pdo->query('SELECT id, name FROM categories ORDER BY id')->fetchAll();

$sql = 'SELECT id, name, price, image FROM products';
$where = [];
$params = [];
if ($categoryId > 0) {
    $where[] = 'category_id = ?';
    $params[] = $categoryId;
}
if ($keyword !== '') {
    $where[] = 'name LIKE ?';
    $params[] = '%' . $keyword . '%';
}
if ($where !== []) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY id';

$statement = $pdo->prepare($sql);
$statement->execute($params);
$products = $statement->fetchAll();

$pageTitle = 'Trang chủ';
require __DIR__ . '/includes/header.php';
?>
<section>
    <h2>Sản phẩm</h2>

    <form action="<?= e(url('index.php')) ?>" method="get" class="search-form">
        <input type="search" name="q" value="<?= e($keyword) ?>" placeholder="Tìm sản phẩm...">
        <?php if ($categoryId > 0): ?>
            <input type="hidden" name="category" value="<?= e($categoryId) ?>">
        <?php endif; ?>
        <button type="submit" class="btn">Tìm</button>
    </form>

    <p class="category-bar">
        <a href="<?= e(url('index.php')) ?>" class="<?= $categoryId === 0 ? 'active' : '' ?>">Tất cả</a>
        <?php foreach ($categories as $category): ?>
            <a href="<?= e(url('index.php?category=' . $category['id'])) ?>"
               class="<?= $categoryId === (int) $category['id'] ? 'active' : '' ?>"><?= e($category['name']) ?></a>
        <?php endforeach; ?>
    </p>

    <?php if ($products === []): ?>
        <p>Không tìm thấy sản phẩm nào.</p>
    <?php endif; ?>

    <div class="product-list">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <img src="<?= e(url($product['image'])) ?>" alt="<?= e($product['name']) ?>">
                <h3><?= e($product['name']) ?></h3>
                <p class="price"><?= e(format_price($product['price'])) ?></p>
                <a href="<?= e(url('product.php?id=' . $product['id'])) ?>" class="btn">Xem chi tiết</a>
                <button type="button" class="btn btn-accent add-to-cart"
                        data-id="<?= e($product['id']) ?>">Thêm vào giỏ</button>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
