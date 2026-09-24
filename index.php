<?php
require_once 'config/database.php';

try {
    $pdo = Database::getInstance()->getConnection();

    $sql = "SELECT p.id, p.name, p.price, p.stock, 
                   c.name AS category_name, 
                   s.name AS supplier_name 
            FROM products p
            JOIN categories c ON p.category_id = c.id
            JOIN suppliers s ON p.supplier_id = s.id
            ORDER BY p.id DESC";

    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang - CRUD PDO</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Inventaris Barang</h2>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert">
                Status operasi: <strong><?= htmlspecialchars($_GET['msg']) ?></strong>
            </div>
        <?php endif; ?>

        <div style="margin-bottom: 15px;">
            <a href="create.php" class="btn btn-primary">+ Tambah Produk</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Supplier</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['id']) ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['category_name']) ?></td>
                        <td><?= htmlspecialchars($p['supplier_name']) ?></td>
                        <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($p['stock']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-warning">Edit</a>
                            <form method="POST" action="delete.php" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Belum ada data produk.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>