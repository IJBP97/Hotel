<?php
require 'db.php';
$message = '';

// Manejo de guardar habitación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_habitacion = $_POST['numero_habitacion'];
    $precio = $_POST['precio'];
    $tipo_habitacion = $_POST['tipo_habitacion'];
    $estado = $_POST['estado'];
    $cantidad_personas = $_POST['cantidad_personas'];

    try {
        $stmt = $pdo->prepare("INSERT INTO Habitacion (numero_habitacion, precio, tipo_habitacion, estado, cantidad_personas) VALUES (?,?,?,?,?)");
        $stmt->execute([$numero_habitacion, $precio, $tipo_habitacion, $estado, $cantidad_personas]);
        $message = "Habitación agregada correctamente.";
    } catch(PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Hotel · Alta Habitación</title>
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
<h1>🏨 Hotel · Alta Habitación</h1>
</div>
</header>

<div class="container">
<?php if($message): ?>
<div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<div class="card">
<h2>Agregar nueva habitación</h2>
<form method="post">
<div class="row">
<div>
<label>Número de habitación</label>
<input type="number" name="numero_habitacion" required>
</div>
<div>
<label>Precio</label>
<input type="number" step="0.01" name="precio" required>
</div>
</div>
<div class="row">
<div>
<label>Tipo de habitación</label>
<select name="tipo_habitacion" required>
<option value="">--Selecciona--</option>
<option value="Sencilla">Sencilla</option>
<option value="Doble">Doble</option>
<option value="Suite">Suite</option>
</select>
</div>
<div>
<label>Estado</label>
<select name="estado" required>
<option value="">--Selecciona--</option>
<option value="Disponible">Disponible</option>
<option value="Ocupada">Ocupada</option>
<option value="Mantenimiento">Mantenimiento</option>
</select>
</div>
</div>
<div class="row">
<div>
<label>Cantidad de personas</label>
<input type="number" name="cantidad_personas" required>
</div>
</div>
<div style="margin-top:12px;">
<button type="submit" class="btn btn-primary">Agregar Habitación</button>
</div>
</form>
</div>

<div style="margin-top:24px;">
<a href="menu principal.php" class="btn btn-secondary">← Regresar al Menú Principal</a>
</div>
</div>
</body>
</html>
