<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluye la clase de PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

header('Content-Type: application/json');

// Función para manejar el envío de correos electrónicos
function enviarCorreo($nombre, $correo) {
    // Configuración de PHPMailer
    $mail = new PHPMailer(true); // Configuración para lanzar excepciones en caso de error

    try {
        // Configuración del servidor SMTP para Hotmail/Outlook
        $mail->isSMTP();
        $mail->Host = 'smtp.live.com'; // Puedes probar también con 'smtp.outlook.com'
        $mail->SMTPAuth = true;
        $mail->Username = 'tonyvillegas91@hotmail.com';
        $mail->Password = 'tony271191';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Habilitar el modo de depuración
        $mail->SMTPDebug = 2;

        // Configuración del remitente y destinatario
        $mail->setFrom('tonyvillegas91@hotmail.com', 'Tony Villegas Brea');
        $mail->addAddress($correo, $nombre); // $correo y $nombre son variables obtenidas del formulario

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Confirmación de Reserva';
        $mail->Body = 'Gracias por tu reserva.';

        // Enviar el correo
        $mail->send();
    } catch (Exception $e) {
        // Lanzar excepción para manejar errores fuera de esta función
        throw new Exception('Error al enviar el correo: ' . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];

    // Procesar la reserva como antes

    $response = array(
        'mensaje' => '¡Reserva exitosa! Se ha enviado una confirmación a tu correo electrónico y al administrador del sitio.',
        'error' => null // No hay error en este caso
    );

    try {
        // Llamar a la función para enviar el correo electrónico
        enviarCorreo($nombre, $correo);
    } catch (Exception $e) {
        // Manejar errores de envío de correo
        $response['error'] = $e->getMessage();
    }

    http_response_code(200);
    echo json_encode($response);
} else {
    $response = array(
        'mensaje' => null,
        'error' => 'Error: Método no permitido'
    );

    http_response_code(400); // Código de error por método no permitido
    echo json_encode($response);
}
?>
