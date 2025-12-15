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

    <style>
        .error-msg {
            color: #b00020;
            font-size: 13px;
            margin-top: 4px;
        }
    </style>
</head>

<body>
<div class="app-container">
<h1>Control de Préstamos de Equipos</h1>

<form action="php/GuardarPrestamo.php" method="POST" onsubmit="return validarFormulario();">

    <input type="text" id="equipo" name="equipo" placeholder="Equipo" required>
    <div id="error-equipo" class="error-msg"></div>

    <input type="text" id="serial" name="serial" placeholder="Serial" required>
    <div id="error-serial" class="error-msg"></div>

    <input type="text" id="aprendiz" name="aprendiz" placeholder="Aprendiz" required>
    <div id="error-aprendiz" class="error-msg"></div>

    <input type="text" id="ficha" name="ficha" placeholder="Ficha" required>
    <div id="error-ficha" class="error-msg"></div>

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

<script>
function validarFormulario() {
    let valido = true;

    const equipo = document.getElementById("equipo").value.trim();
    const serial = document.getElementById("serial").value.trim();
    const aprendiz = document.getElementById("aprendiz").value.trim();
    const ficha = document.getElementById("ficha").value.trim();

    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
    const letrasNumeros = /^[A-Za-z0-9]+$/;
    const soloNumeros = /^[0-9]+$/;

    // Limpiar mensajes
    document.querySelectorAll('.error-msg').forEach(e => e.innerText = "");

    if (!soloLetras.test(equipo)) {
        document.getElementById("error-equipo").innerText =
            "⚠️ Solo se permiten letras en el campo Equipo.";
        valido = false;
    }

    if (!letrasNumeros.test(serial)) {
        document.getElementById("error-serial").innerText =
            "⚠️ El serial solo puede tener letras y números, sin símbolos.";
        valido = false;
    }

    if (!soloLetras.test(aprendiz)) {
        document.getElementById("error-aprendiz").innerText =
            "⚠️ El campo Aprendiz solo admite letras.";
        valido = false;
    }

    if (!soloNumeros.test(ficha)) {
        document.getElementById("error-ficha").innerText =
            "⚠️ La ficha solo puede contener números.";
        valido = false;
    }

    return valido;
}
</script>

</body>
</html>
