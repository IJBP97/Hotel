<?php
require 'db.php';

// Borrar reservación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    try {
        // 1. Borrar CheckInOut
        $pdo->prepare("DELETE FROM CheckInOut WHERE id_reservacion=?")->execute([$id]);

        // 2. Borrar Cobros asociados
        $pdo->prepare("DELETE FROM Cobro WHERE id_ticket IN (SELECT id_ticket FROM Ticket WHERE id_reservacion=?)")->execute([$id]);

        // 3. Borrar Tickets
        $pdo->prepare("DELETE FROM Ticket WHERE id_reservacion=?")->execute([$id]);

        // 4. Borrar Habitacion_Servicio relacionado a los Servicios de esta reservación
        $pdo->prepare("DELETE hs FROM Habitacion_Servicio hs
                       INNER JOIN Servicio s ON hs.id_servicio = s.id_servicio
                       WHERE s.id_reservacion = ?")->execute([$id]);

        // 5. Borrar Servicios
        $pdo->prepare("DELETE FROM Servicio WHERE id_reservacion=?")->execute([$id]);

        // 6. Finalmente, borrar la reservación
        $pdo->prepare("DELETE FROM Reservacion WHERE id_reservacion=?")->execute([$id]);

    } catch (PDOException $e) {
        echo "Error al borrar: " . $e->getMessage();
    }
}

// Guardar edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha_reservacion'];
    $id_habitacion = $_POST['id_habitacion'];

    try {
        $pdo->beginTransaction();
        // Actualizar cliente
        $cliente_id = $_POST['cliente_id'];
        $stmt = $pdo->prepare("UPDATE Cliente SET nombre=?, apellido_paterno=?, apellido_materno=?, correo=?, telefono=? WHERE id_cliente=?");
        $stmt->execute([$nombre,$apellido_paterno,$apellido_materno,$correo,$telefono,$cliente_id]);

        // Actualizar reservación
        $stmt = $pdo->prepare("UPDATE Reservacion SET id_habitacion=?, fecha_reservacion=? WHERE id_reservacion=?");
        $stmt->execute([$id_habitacion,$fecha,$id]);

        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error al actualizar: " . $e->getMessage();
    }
}

// Traer datos
$reservas = $pdo->query("
  SELECT r.id_reservacion, r.fecha_reservacion,
         c.id_cliente, c.nombre, c.apellido_paterno, c.apellido_materno, c.correo, c.telefono,
         h.id_habitacion, h.numero_habitacion, h.tipo_habitacion
  FROM Reservacion r
  JOIN Cliente c ON r.id_cliente=c.id_cliente
  JOIN Habitacion h ON r.id_habitacion=h.id_habitacion
  ORDER BY r.id_reservacion DESC
")->fetchAll();

$habitaciones = $pdo->query("SELECT id_habitacion, numero_habitacion, tipo_habitacion FROM Habitacion ORDER BY numero_habitacion")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Hotel · Consultas</title>
<style>
body{font-family:system-ui;margin:0;background:#f4f5f7;color:#222;}
header{background:#1f2937;color:#fff;padding:16px 24px;}
.container{max-width:1100px;margin:24px auto;padding:0 16px;}
h1,h2,h3{margin:0;}
.btn{padding:10px 16px;border:0;border-radius:10px;cursor:pointer;font-weight:500;}
.btn-primary{background:#3b82f6;color:#fff;}
.btn-secondary{background:#6b7280;color:#fff;}
.btn-danger{background:#ef4444;color:#fff;}
.card{background:#fff;border-radius:16px;box-shadow:0 8px 24px rgba(0,0,0,.08);padding:16px;margin-bottom:16px;}
table{width:100%;border-collapse:collapse;}
th,td{padding:12px;border-bottom:1px solid #e5e7eb;text-align:left;}
.modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,.35);display:none;align-items:center;justify-content:center;z-index:10;}
.modal{background:#fff;width:100%;max-width:720px;border-radius:16px;padding:24px;max-height:90vh;overflow-y:auto;}
.row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px;}
label{font-size:14px;color:#374151;}
input,select{width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px;}
.topnav{margin-bottom:16px;}
.topnav a{display:inline-block;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:8px;text-decoration:none;font-weight:bold;margin-right:8px;}
.topnav a:hover{background:#2563eb;}
</style>
</head>
<body>
<header>
<div class="container" style="display:flex;justify-content:space-between;align-items:center;">
<h1>🏨 Hotel · Consultas</h1>
<a href="menu principal.php" class="btn btn-primary">← Menú Principal</a>
</div>
</header>

<div class="container">
<div class="card">
<h2>Reservaciones</h2>
<table>
<thead>
<tr>
<th>ID</th><th>Cliente</th><th>Correo</th><th>Teléfono</th><th>Habitación</th><th>Fecha</th><th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach($reservas as $r): 
$nombreCompleto = trim($r['nombre'].' '.$r['apellido_paterno'].' '.$r['apellido_materno']);
?>
<tr>
<td><?= $r['id_reservacion'] ?></td>
<td><?= htmlspecialchars($nombreCompleto) ?></td>
<td><?= htmlspecialchars($r['correo']) ?></td>
<td><?= htmlspecialchars($r['telefono']) ?></td>
<td>#<?= $r['numero_habitacion'] ?> · <?= $r['tipo_habitacion'] ?></td>
<td><?= $r['fecha_reservacion'] ?></td>
<td>
<form method="post" style="display:inline;">
<input type="hidden" name="edit_id" value="<?= $r['id_reservacion'] ?>">
<input type="hidden" name="cliente_id" value="<?= $r['id_cliente'] ?>">
<button type="button" class="btn btn-primary" onclick="openModal(this)">Editar</button>
</form>
<form method="post" style="display:inline;" onsubmit="return confirm('¿Borrar esta reservación?');">
<input type="hidden" name="delete_id" value="<?= $r['id_reservacion'] ?>">
<button type="submit" class="btn btn-danger">Borrar</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

<!-- Modal Editar -->
<div class="modal-backdrop" id="backdrop">
<div class="modal">
<h3>Editar reservación</h3>
<form method="post" id="editForm">
<input type="hidden" name="edit_id" id="modal_edit_id">
<input type="hidden" name="cliente_id" id="modal_cliente_id">
<div class="row">
<div><label>Nombre</label><input type="text" name="nombre" id="modal_nombre" required></div>
<div><label>Apellido paterno</label><input type="text" name="apellido_paterno" id="modal_apellido_paterno" required></div>
</div>
<div class="row">
<div><label>Apellido materno</label><input type="text" name="apellido_materno" id="modal_apellido_materno"></div>
<div><label>Correo</label><input type="email" name="correo" id="modal_correo"></div>
</div>
<div class="row">
<div><label>Teléfono</label><input type="text" name="telefono" id="modal_telefono"></div>
<div><label>Fecha</label><input type="date" name="fecha_reservacion" id="modal_fecha" required></div>
</div>
<div class="row">
<div><label>Habitación</label>
<select name="id_habitacion" id="modal_id_habitacion" required>
<option value="">--Selecciona--</option>
<?php foreach($habitaciones as $h): ?>
<option value="<?= $h['id_habitacion'] ?>">#<?= $h['numero_habitacion'] ?> · <?= $h['tipo_habitacion'] ?></option>
<?php endforeach; ?>
</select>
</div>
</div>
<div style="margin-top:12px;">
<button type="button" class="
