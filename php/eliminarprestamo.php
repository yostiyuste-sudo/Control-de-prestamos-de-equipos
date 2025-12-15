<?php
require_once 'Database.php';

$conn = Database::conectar();

$sql = "DELETE FROM prestamos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]);

header("Location: ../index.php");
