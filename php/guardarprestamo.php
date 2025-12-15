<?php
require_once "Database.php";

$conn = Database::conectar();

$equipo   = trim($_POST['equipo']);
$serial   = trim($_POST['serial']);
$aprendiz = trim($_POST['aprendiz']);
$ficha    = trim($_POST['ficha']);
$fecha    = $_POST['fecha_prestamo'] ?? date('Y-m-d');

/* ================= VALIDACIONES BACKEND ================= */

// Solo letras (Equipo)
if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $equipo)) {
    die("Error: El campo Equipo solo permite letras.");
}

// Solo letras (Aprendiz)
if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $aprendiz)) {
    die("Error: El campo Aprendiz solo permite letras.");
}

// Letras y números (Serial)
if (!preg_match("/^[A-Za-z0-9]+$/", $serial)) {
    die("Error: El Serial solo permite letras y números.");
}

// Solo números (Ficha)
if (!preg_match("/^[0-9]+$/", $ficha)) {
    die("Error: El campo Ficha solo permite números.");
}

/* ========== VALIDAR SERIAL ÚNICO ========== */
$check = $conn->prepare("SELECT id FROM prestamos WHERE serial = ?");
$check->execute([$serial]);

if ($check->rowCount() > 0) {
    die("Error: El serial ya existe en el sistema.");
}

/* ========== GUARDAR PRÉSTAMO ========== */
$sql = "INSERT INTO prestamos 
        (equipo, serial, aprendiz, ficha, fecha_prestamo, devuelto)
        VALUES (?, ?, ?, ?, ?, 0)";

$stmt = $conn->prepare($sql);

if ($stmt->execute([$equipo, $serial, $aprendiz, $ficha, $fecha])) {
    header("Location: ../public/index.php");
    exit;
} else {
    die("Error al guardar el préstamo.");
}

