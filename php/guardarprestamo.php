<?php
require_once "database.php";

$equipo   = trim($_POST['equipo']);
$serial   = trim($_POST['serial']);
$aprendiz = trim($_POST['aprendiz']);
$ficha    = trim($_POST['ficha']);

/* ================= VALIDACIONES ================= */

// Solo letras
if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $equipo)) {
    die("Error: El campo Equipo solo permite letras.");
}

if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $aprendiz)) {
    die("Error: El campo Aprendiz solo permite letras.");
}

// Letras y números
if (!preg_match("/^[A-Za-z0-9]+$/", $serial)) {
    die("Error: El Serial solo permite letras y números.");
}

// Solo números
if (!preg_match("/^[0-9]+$/", $ficha)) {
    die("Error: El campo Ficha solo permite números.");
}

/* ========== VALIDAR SERIAL ÚNICO ========== */
$check = $conn->prepare("SELECT id FROM prestamos WHERE serial = ?");
$check->bind_param("s", $serial);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    die("Error: El serial ya existe en el sistema.");
}
$check->close();

/* ========== GUARDAR ========== */
$sql = "INSERT INTO prestamos (equipo, serial, aprendiz, ficha)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $equipo, $serial, $aprendiz, $ficha);

if ($stmt->execute()) {
    header("Location: ../public/index.php");
    exit;
} else {
    echo "Error al guardar el préstamo.";
}

