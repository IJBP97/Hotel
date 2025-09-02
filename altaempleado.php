<?php
require 'db.php';
$message = '';

// Traer áreas y turnos para los select
$areas = $pdo->query("SELECT id_area, nombre_area FROM Area")->fetchAll();
$turnos = $pdo->query("SELECT id_turno, tipo_turno FROM Turno")->fetchAll();

// Manejo de guardar empleado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $telefono = $_POST['telefono'];
    $area = $_POST['area'];
    $turno = $_POST['turno'];

    try {
        $stmt = $pdo->prepare("INSERT INTO Empleado (nombre, apellido_paterno, apellido_materno, telefono, area, turno) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$nombre,$apellido_paterno,$apellido_materno,$telefono,$area,$turno]);
        $message = "Empleado agregado correctamente.";
    } catch(PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Hotel · Alta Empleado</title>
<style>
body{font-family:system-ui;margin:0;background:#f4f5f7;color:#222;}
header{background:#1f2937;color:#fff;padding:16px 24px;}
.container{max-width:800px;margin:24px auto;padding:0 16px;}
h1,h2,h3{margin:0;}
.btn{padding:10px 16px;border:0;border-radius:10px;cursor:pointer;font-weight:500;}
.btn-primary{background:#3b82f6;color:#fff;}
.btn-secondary{background:#6b7280;color:#fff;}
.card{background:#fff;border-radius:16px;box-shadow:0 8px 24px rgba(0,0,0,.08);padding:16px;margin-bottom:16px;}
.row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px;}
label{font-size:14px;color:#374151;}
input,select{width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px;}
.message{margin-bottom:16px;padding:12px;border-radius:10px;background:#d1fae5;color:#065f46;}
</style>
</head>
<body>
<header>
<div class="container">
<h1>🏨 Hotel · Alta Empleado</h1>
</div>
</header>

<div class="container">
<?php if($message): ?>
<div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<div class="card">
<h2>Agregar nuevo empleado</h2>
<form method="post">
<div class="row">
<div>
<label>Nombre</label>
<input type="text" name="nombre" required>
</div>
<div>
<label>Apellido Paterno</label>
<input type="text" name="apellido_paterno" required>
</div>
</div>
<div class="row">
<div>
<label>Apellido Materno</label>
<input type="text" name="apellido_materno">
</div>
<div>
<label>Teléfono</label>
<input type="text" name="telefono">
</div>
</div>
<div class="row">
<div>
<label>Área</label>
<select name="area" required>
<option value="">--Selecciona--</option>
<?php foreach($areas as $a): ?>
<option value="<?= $a['id_area'] ?>"><?= htmlspecialchars($a['nombre_area']) ?></option>
<?php endforeach; ?>
</select>
</div>
<div>
<label>Turno</label>
<select name="turno" required>
<option value="">--Selecciona--</option>
<?php foreach($turnos as $t): ?>
<option value="<?= $t['id_turno'] ?>"><?= htmlspecialchars($t['tipo_turno']) ?></option>
<?php endforeach; ?>
</select>
</div>
</div>
<div style="margin-top:12px;">
<button type="submit" class="btn btn-primary">Agregar Empleado</button>
</div>
</form>
</div>

<div style="margin-top:24px;">
<a href="menu principal.php" class="btn btn-secondary">← Regresar al Menú Principal</a>
</div>
</div>
</body>
</html>
