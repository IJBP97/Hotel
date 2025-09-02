<?php
// menu.php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hotel · Menú Principal</title>
<style>
body{margin:0;font-family:system-ui;background:#f0f4f8;color:#222;}
header{background:#0f172a;color:#fff;padding:16px 24px;display:flex;justify-content:space-between;align-items:center;}
header h1{margin:0;font-size:24px;}
.btn-logout{background:#ef4444;border:none;padding:10px 16px;border-radius:8px;color:#fff;font-weight:bold;cursor:pointer;}
nav{background:#0f172a;display:flex;justify-content:center;gap:16px;padding:12px 0;}
nav a{text-decoration:none;color:#fff;padding:10px 20px;border-radius:8px;background:#3b82f6;font-weight:bold;transition:0.3s;}
nav a:hover{background:#2563eb;}
.hero{margin:24px auto;max-width:1100px;border-radius:12px;overflow:hidden;box-shadow:0 8px 24px rgba(0,0,0,0.15);}
.hero img{width:100%;display:block;object-fit:cover;max-height:400px;}
.hero .intro{background:rgba(255,255,255,0.95);padding:20px;text-align:center;}
.hero .intro h2{margin-top:0;color:#0f172a;}
.hero .intro p{color:#334155;}
@media(max-width:480px){header h1{font-size:20px;}nav{flex-direction:column;gap:8px;}}
</style>
</head>
<body>
<header>
<h1>🏨 Hotel Elegante</h1>
<form method="post" action="logout.php" style="margin:0;">
<button type="submit" class="btn-logout">Cerrar Sesión</button>
</form>
</header>

<nav>
<a href="altahabitacion.php">Alta Habitación</a>
<a href="altaempleado.php">Alta Empleado</a>
<a href="consultas.php">Consultas</a>
</nav>

<div class="hero">
<img src="https://images.pexels.com/photos/258154/pexels-photo-258154.jpeg" alt="Hotel">
<div class="intro">
<h2>Bienvenido a nuestro Hotel</h2>
<p>Disfruta de una experiencia única con habitaciones elegantes, servicios exclusivos y atención personalizada para tu confort.</p>
</div>
</div>
</body>
</html>
