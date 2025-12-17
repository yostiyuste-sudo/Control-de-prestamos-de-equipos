<?php
require_once 'php/Database.php';
$conn = Database::conectar();

/* ===============================
   ACTIVAR / INACTIVAR PRESTAMO
   =============================== */
if (isset($_GET['accion']) && $_GET['accion'] === 'estado') {
    $id = (int) $_GET['id'];
    $estado = (int) $_GET['estado'];

    $stmt = $conn->prepare("UPDATE prestamos SET activo = :estado WHERE id = :id");
    $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

/* ===============================
   LISTAR PRESTAMOS
   =============================== */
$prestamos = $conn->query("SELECT * FROM prestamos ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Préstamos</title>
    <link rel="stylesheet" href="public/assets/style.css">
</head>
<body>

<h1>Control de Préstamos de Equipos</h1>

<form action="php/GuardarPrestamo.php" method="POST" id="formPrestamo">

    <div class="campo">
        <input type="text" name="equipo" placeholder="Equipo" required>
    </div>

    <div class="campo">
        <input type="text" name="serial" placeholder="Serial">
    </div>

    <div class="campo">
        <input type="text" name="aprendiz" placeholder="Aprendiz" required>
    </div>

    <div class="campo">
        <input type="text" name="ficha" placeholder="Ficha">
    </div>

    <div class="campo">
        <input type="date" name="fecha_prestamo" required>
    </div>

    <div class="campo">
        <textarea name="observaciones" placeholder="Observaciones"></textarea>
    </div>

    <button type="submit">Guardar Préstamo</button>
</form>

<hr>

<table>
    <thead>
        <tr>
            <th>Equipo</th>
            <th>Aprendiz</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($prestamos as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['equipo']) ?></td>
            <td><?= htmlspecialchars($p['aprendiz']) ?></td>
            <td><?= htmlspecialchars($p['fecha_prestamo']) ?></td>
            <td><?= $p['devuelto'] ? 'Devuelto' : 'En préstamo' ?></td>
            <td><?= $p['activo'] ? 'Activo' : 'Inactivo' ?></td>

            <td>
                <?php if ($p['activo'] && !$p['devuelto']): ?>
                    <a href="php/ActualizarPrestamo.php?id=<?= $p['id'] ?>">Devolver</a> |
                <?php endif; ?>

                <?php if ($p['activo']): ?>
                    <a href="index.php?accion=estado&id=<?= $p['id'] ?>&estado=0"
                       onclick="return confirm('¿Inactivar este préstamo?')">
                        Inactivar
                    </a>
                <?php else: ?>
                    <a href="index.php?accion=estado&id=<?= $p['id'] ?>&estado=1"
                       onclick="return confirm('¿Activar este préstamo?')">
                        Activar
                    </a>
                <?php endif; ?>

                | <a href="php/EliminarPrestamo.php?id=<?= $p['id'] ?>"
                     onclick="return confirm('¿Eliminar este préstamo?')">
                    Eliminar
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="public/assets/app.js"></script>
</body>
</html>
