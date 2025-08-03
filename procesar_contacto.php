<?php

$servername = "127.0.0.1:3306";
$username = "u239220606_rompharma_user";
$password = "Rompharma1244";
$dbname = "u239220606_ROMPHARMADB";

// Inicializar variable de mensaje
$mensaje_respuesta = '';

// Validar que el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $mensaje_respuesta = "Error: El formulario debe ser enviado por POST.";
    echo $mensaje_respuesta;
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
    $mensaje_respuesta = "Error: Por favor complete todos los campos requeridos.";
    echo $mensaje_respuesta;
    exit();
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $mensaje_respuesta = "Error: El formato del correo electrónico no es válido.";
    echo $mensaje_respuesta;
    exit();
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("INSERT INTO contactos_profesionales 
        (nombre, correo, telefono, localidad, cedula, institucion, especialidad, mensaje, fecha_registro) 
        VALUES (:nombre, :correo, :telefono, :localidad, :cedula, :institucion, :especialidad, :mensaje, NOW())");
    
    // [Vinculación de parámetros permanece igual...]
    
    if ($stmt->execute()) {
        // Enviar correo de confirmación
        $asunto = "Confirmación de contacto - Rom Pharma";
        $cuerpo = "Estimado/a $nombre,\n\nHemos recibido su solicitud de contacto. Un representante se pondrá en contacto con usted pronto.\n\n";
        $cuerpo .= "Resumen de su información:\n";
        $cuerpo .= "Nombre: $nombre\n";
        $cuerpo .= "Cédula: $cedula\n";
        $cuerpo .= "Especialidad: $especialidad\n";
        $cuerpo .= "Teléfono: $telefono\n\n";
        $cuerpo .= "Gracias por contactar a Rom Pharma.";
        
        $headers = "From: no-reply@rompharma.com" . "\r\n" .
                 "Reply-To: contacto@rompharma.com" . "\r\n" .
                 "X-Mailer: PHP/" . phpversion();
        
        mail($correo, $asunto, $cuerpo, $headers);
        
        echo "Su mensaje ha sido enviado con éxito. Gracias por contactarnos.";
    } else {
        echo "Error: Hubo un problema al enviar su mensaje. Por favor intente nuevamente.";
    }
    
} catch(PDOException $e) {
    error_log("Error en la base de datos: " . $e->getMessage());
    echo "Error: Hubo un problema al procesar su solicitud. Por favor intente nuevamente más tarde.";
}

if (isset($conn)) {
    $conn = null;
}
exit();
?>