<?php
require_once 'Database.php';

$conn = Database::conectar();

$sql = "INSERT INTO prestamos (equipo, serial, aprendiz, ficha, fecha_prestamo, observaciones)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->execute([
    $_POST['equipo'],
    $_POST['serial'],
    $_POST['aprendiz'],
    $_POST['ficha'],
    $_POST['fecha_prestamo'],
    $_POST['observaciones']
]);

header("Location: ../index.php");

