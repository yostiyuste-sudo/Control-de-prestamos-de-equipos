<?php
require_once 'php/Database.php';
$conn = Database::conectar();

$prestamos = $conn->query("SELECT * FROM prestamos ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Préstamos</title>
    <link rel="stylesheet" href="public/assets/style.css">
</head>

<script>
function validarFormulario() {
    const equipo = document.getElementById("equipo").value;
    const serial = document.getElementById("serial").value;
    const aprendiz = document.getElementById("aprendiz").value;
    const ficha = document.getElementById("ficha").value;

    // Solo letras
    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

    // Letras y números
    const letrasNumeros = /^[A-Za-z0-9]+$/;

    // Solo números
    const soloNumeros = /^[0-9]+$/;

    if (!soloLetras.test(equipo)) {
        alert("El campo Equipo solo puede contener letras");
        return false;
    }

    if (!letrasNumeros.test(serial)) {
        alert("El Serial solo puede contener letras y números, sin símbolos");
        return false;
    }

    if (!soloLetras.test(aprendiz)) {
        alert("El campo Aprendiz solo puede contener letras");
        return false;
    }

    if (!soloNumeros.test(ficha)) {
        alert("El campo Ficha solo puede contener números");
        return false;
    }

    return true;
}
</script>

<body>
<div class="app-container">
<h1>Control de Préstamos de Equipos</h1>

<form action="php/GuardarPrestamo.php" method="POST">
    <input type="text" name="equipo" placeholder="Equipo" required>
    <input type="text" name="serial" placeholder="Serial">
    <input type="text" name="aprendiz" placeholder="Aprendiz" required>
    <input type="text" name="ficha" placeholder="Ficha">
    <input type="date" name="fecha_prestamo" required>
    <textarea name="observaciones" placeholder="Observaciones"></textarea>
    <button>Guardar Préstamo</button>
</form>

<table>
    <tr>
        <th>Equipo</th>
        <th>Aprendiz</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($prestamos as $p): ?>
    <tr>
        <td><?= $p['equipo'] ?></td>
        <td><?= $p['aprendiz'] ?></td>
        <td><?= $p['fecha_prestamo'] ?></td>
        <td><?= $p['devuelto'] ? 'Devuelto' : 'En préstamo' ?></td>
        <td>
            <?php if (!$p['devuelto']): ?>
                <a href="php/ActualizarPrestamo.php?id=<?= $p['id'] ?>">Devolver</a>
            <?php endif; ?>
            | <a href="php/EliminarPrestamo.php?id=<?= $p['id'] ?>">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<script src="public/assets/app.js"></script>
</body>
</html>
 