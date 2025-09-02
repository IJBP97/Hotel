<?php
require 'db.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $numero = $_POST['numero'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];
    $estado = $_POST['estado'];
    $personas = $_POST['personas'];

    $stmt = $pdo->prepare("INSERT INTO Habitacion (numero_habitacion, precio, tipo_habitacion, estado, cantidad_personas) VALUES (?,?,?,?,?)");
    $stmt->execute([$numero,$precio,$tipo,$estado,$personas]);
    header('Location:index.php');
}
?>

