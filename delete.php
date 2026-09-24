<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $pdo = Database::getInstance()->getConnection();

    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: index.php?msg=deleted');
    exit;
} else {
    header('Location: index.php');
    exit;
}