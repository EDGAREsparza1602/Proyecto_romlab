<?php
// [Configuración de la base de datos y validaciones anteriores permanecen igual...]

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