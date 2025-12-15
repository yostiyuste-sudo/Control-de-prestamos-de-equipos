<?php
require_once 'Database.php';

$conn = Database::conectar();

$sql = "UPDATE prestamos 
        SET devuelto = 1, fecha_devolucion = CURDATE()
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]);

header("Location: ../index.php");
