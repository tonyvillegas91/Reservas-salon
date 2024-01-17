<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

header('Content-Type: application/json');

function enviarCorreo($nombre, $correo) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.live.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USERNAME'); // Configura esta variable de entorno
        $mail->Password = getenv('SMTP_PASSWORD'); // Configura esta variable de entorno
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->SMTPDebug = 2; // Desactiva el modo de depuración en producción

        $mail->setFrom(getenv('SMTP_USERNAME'), 'Tony Villegas Brea');
        $mail->addAddress($correo, $nombre);

        $mail->isHTML(true);
        $mail->Subject = 'Confirmación de Reserva';
        $mail->Body = 'Gracias por tu reserva.';

        $mail->Timeout = 25;

        $mail->send();
    } catch (Exception $e) {
        throw new Exception('Error al enviar el correo: ' . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];

    $response = [
        'mensaje' => '¡Reserva exitosa! Se ha enviado una confirmación a tu correo electrónico y al administrador del sitio.',
        'error' => null
    ];

    try {
        enviarCorreo($nombre, $correo);
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }

    http_response_code(200);
    echo json_encode($response);
} else {
    $response = [
        'mensaje' => null,
        'error' => 'Error: Método no permitido'
    ];

    http_response_code(400);
    echo json_encode($response);
}
?>
