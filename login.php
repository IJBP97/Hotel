<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardamos el nombre de usuario opcionalmente
    $_SESSION['user'] = $_POST['usuario'] ?? 'Invitado';
    header('Location: menu principal.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Hotel</title>
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: url('https://images.pexels.com/photos/258154/pexels-photo-258154.jpeg') no-repeat center center fixed;
    background-size: cover;
}
.form-box {
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 12px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
}
.form-box h2 { text-align: center; margin-bottom: 20px; color: #0f172a; }
.field { margin-bottom: 16px; }
label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: bold; color: #1e293b; }
input { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; outline: none; }
input:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2); }
.btn { width: 100%; padding: 12px; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; color: #fff; background: #0ea5e9; }
.btn:hover { opacity: 0.9; }
</style>
</head>
<body>

<div class="form-box">
    <h2>Login</h2>
    <form method="post">
        <div class="field">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" placeholder="Opcional">
        </div>
        <div class="field">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Opcional">
        </div>
        <button type="submit" class="btn">Ingresar</button>
    </form>
</div>

</body>
</html>
