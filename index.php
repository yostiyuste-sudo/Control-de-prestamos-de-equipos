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

    <script>
        function validarSoloLetras(input, mensaje) {
            const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
            input.setCustomValidity(
                regex.test(input.value) ? "" : mensaje
            );
        }

        function validarSerial(input) {
            const regex = /^[A-Za-z0-9]+$/;
            input.setCustomValidity(
                regex.test(input.value) ? "" : "El Serial solo permite letras y números"
            );
        }

        function validarSoloNumeros(input, mensaje) {
            const regex = /^[0-9]+$/;
            input.setCustomValidity(
                regex.test(input.value) ? "" : mensaje
            );
        }
    </script>
</head>

<body>
<div class="app-container">
<h1>Control de Préstamos de Equipos</h1>

<form action="php/guardarprestamo.php" method="POST">

    <!-- EQUIPO -->
    <input type="text"
           name="equipo"
           placeholder="Equipo"
           required
           oninput="validarSoloLetras(this, 'El campo Equipo solo permite letras')">

    <!-- SERIAL -->
    <input type="text"
           name="serial"
           placeholder="Serial"
           required
           oninput="validarSerial(this)">

    <!-- APRENDIZ -->
    <input type="text"
           name="aprendiz"
           placeholder="Aprendiz"
           required
           oninput="validarSoloLetras(this, 'El campo Aprendiz solo permite letras')">

    <!-- FICHA -->
    <input type="text"
           name="ficha"
           placeholder="Ficha"
           required
           oninput="validarSoloNumeros(this, 'La ficha solo permite números')">

    <input type="date" name="fecha_prestamo" required>

    <textarea name="observaciones" placeholder="Observaciones"></textarea>

    <button type="submit">Guardar Préstamo</button>
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
        <td><?= htmlspecialchars($p['equipo']) ?></td>
        <td><?= htmlspecialchars($p['aprendiz']) ?></td>
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
</div>
<script src="public/assets/app.js"></script>
</body>
</html>

