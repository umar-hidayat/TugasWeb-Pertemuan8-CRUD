<?php
require_once 'config/database.php';
$pdo = Database::getInstance()->getConnection();

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$suppliers  = $pdo->query("SELECT * FROM suppliers")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $categoryId  = (int) $_POST['category_id'];
    $supplierId  = (int) $_POST['supplier_id'];
    $price       = (float) $_POST['price'];
    $stock       = (int) $_POST['stock'];

    $sql = "INSERT INTO products (name, category_id, supplier_id, price, stock) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $categoryId, $supplierId, $price, $stock]);

    header('Location: index.php?msg=created');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk Baru</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Produk Baru</h2>
        <form method="POST" action="">
            <label>Nama Produk:</label>
            <input type="text" name="name" required>

            <label>Kategori:</label>
            <select name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Supplier:</label>
            <select name="supplier_id" required>
                <option value="">-- Pilih Supplier --</option>
                <?php foreach ($suppliers as $s): ?>
                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Harga (Rp):</label>
            <input type="number" step="0.01" name="price" required>

            <label>Stok:</label>
            <input type="number" name="stock" required>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>