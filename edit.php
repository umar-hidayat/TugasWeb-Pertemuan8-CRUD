<?php
require_once 'config/database.php';
$pdo = Database::getInstance()->getConnection();

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: index.php');
    exit;
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$suppliers  = $pdo->query("SELECT * FROM suppliers")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $categoryId  = (int) $_POST['category_id'];
    $supplierId  = (int) $_POST['supplier_id'];
    $price       = (float) $_POST['price'];
    $stock       = (int) $_POST['stock'];

    $sql = "UPDATE products SET name = ?, category_id = ?, supplier_id = ?, price = ?, stock = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $categoryId, $supplierId, $price, $stock, $id]);

    header('Location: index.php?msg=updated');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Produk</h2>
        <form method="POST" action="">
            <label>Nama Produk:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label>Kategori:</label>
            <select name="category_id" required>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Supplier:</label>
            <select name="supplier_id" required>
                <?php foreach ($suppliers as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= $s['id'] == $product['supplier_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Harga (Rp):</label>
            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>

            <label>Stok:</label>
            <input type="number" name="stock" value="<?= $product['stock'] ?>" required>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>