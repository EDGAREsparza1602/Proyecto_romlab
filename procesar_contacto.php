<?php
$servername = "127.0.0.1:3306";
$username   = "u239220606_rompharma_user";
$password   = "Rompharma1244";
$dbname     = "u239220606_ROMPHARMADB";
// Crear conexi�n
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar conexi�n
if ($conn->connect_error) {
    die("Conexi�n fallida: " . $conn->connect_error);
}
// Obtener datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$localidad = $_POST['localidad'];
$cedula = $_POST['cedula'];
$institucion = $_POST['institucion'];
$especialidad = $_POST['especialidad'];
$mensaje = $_POST['mensaje'];
// Preparar y ejecutar la consulta
$sql = "INSERT INTO contactos_profesionales (nombre, correo, telefono, localidad, cedula, institucion, especialidad, mensaje) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $nombre, $correo, $telefono, $localidad, $cedula, $institucion, $especialidad, $mensaje);
if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}
$stmt->close();
$conn->close();
?>