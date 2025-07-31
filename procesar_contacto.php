<?php
// procesar_contacto.php

// Configuraci�n de la base de datos (reemplaza con tus credenciales de Hostinger)
$servername = "127.0.0.1:3306";
$username = "u239220606_rompharma_user";
$password = "Rompharma1244";
$dbname = "u239220606_ROMPHARMADB";

// Validar que el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: contact.html");
    exit();
}

// Recoger y sanitizar los datos del formulario
$nombre = htmlspecialchars(trim($_POST['nombre']));
$correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
$telefono = preg_replace('/[^0-9+]/', '', trim($_POST['telefono']));
$localidad = htmlspecialchars(trim($_POST['localidad']));
$cedula = htmlspecialchars(trim($_POST['cedula']));
$institucion = htmlspecialchars(trim($_POST['institucion']));
$especialidad = htmlspecialchars(trim($_POST['especialidad']));
$mensaje = htmlspecialchars(trim($_POST['mensaje']));

// Validaciones adicionales
if (empty($nombre) || empty($correo) || empty($telefono) || empty($localidad) || empty($cedula) || empty($especialidad)) {
    die("Por favor complete todos los campos requeridos.");
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    die("El formato del correo electr�nico no es v�lido.");
}

// Crear conexi�n a la base de datos
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Preparar la consulta SQL con par�metros
    $stmt = $conn->prepare("INSERT INTO contactos_profesionales 
        (nombre, correo, telefono, localidad, cedula, institucion, especialidad, mensaje, fecha_registro) 
        VALUES (:nombre, :correo, :telefono, :localidad, :cedula, :institucion, :especialidad, :mensaje, NOW())");
    
    // Vincular par�metros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':localidad', $localidad);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':institucion', $institucion);
    $stmt->bindParam(':especialidad', $especialidad);
    $stmt->bindParam(':mensaje', $mensaje);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Enviar correo de confirmaci�n (opcional)
    $asunto = "Confirmaci�n de contacto - Rom Pharma";
    $cuerpo = "Estimado/a $nombre,\n\nHemos recibido su solicitud de contacto. Un representante se pondr� en contacto con usted pronto.\n\n";
    $cuerpo .= "Resumen de su informaci�n:\n";
    $cuerpo .= "Nombre: $nombre\n";
    $cuerpo .= "C�dula: $cedula\n";
    $cuerpo .= "Especialidad: $especialidad\n";
    $cuerpo .= "Tel�fono: $telefono\n\n";
    $cuerpo .= "Gracias por contactar a Rom Pharma.";
    
    $headers = "From: no-reply@rompharma.com" . "\r\n" .
               "Reply-To: contacto@rompharma.com" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();
    
    mail($correo, $asunto, $cuerpo, $headers);
    
    // Redireccionar a p�gina de �xito
    header("Location: contacto_exitoso.html");
    exit();
    
} catch(PDOException $e) {
    // Registrar el error (no mostrar detalles al usuario)
    error_log("Error en la base de datos: " . $e->getMessage());
    
    // Redireccionar a p�gina de error
    header("Location: error_contacto.html");
    exit();
}

$conn = null;
?>