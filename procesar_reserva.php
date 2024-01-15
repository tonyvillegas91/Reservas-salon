<?php

require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];

    // Crea una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Hotmail (Outlook)
        $mail->isSMTP();
        $mail->Host       = 'smtp-mail.outlook.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tonyvillegas91@hotmail.com'; // Reemplaza con tu dirección de Hotmail
        $mail->Password   = 'tony271191'; // Reemplaza con tu contraseña de Hotmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet = 'UTF-8';

        // Destinatario y asunto para el administrador del sitio
        $mail->setFrom('tonyvillegas91@hotmail.com', 'Tony Villegas Brea');
        $mail->addAddress('tonyvillegas91@hotmail.com'); // Reemplaza con tu dirección de correo de destino
        $mail->Subject = 'Confirmación de Reserva';

        // Contenido del mensaje para el administrador del sitio
        $mail->Body = "¡Reserva exitosa!\nNombre: $nombre\nCorreo: $correo\nFecha: $fecha\nHora: $hora";

        // Envía el correo electrónico
        $mail->send();

        // Destinatario y asunto para el usuario que ha hecho la reserva
        $mail->clearAddresses();
        $mail->addAddress($correo); // Utiliza el correo proporcionado por el usuario
        $mail->Subject = 'Confirmación de tu Reserva';

        // Contenido del mensaje para el usuario que ha hecho la reserva
        $mail->Body = "¡Reserva exitosa!\nGracias por reservar en nuestro sitio.\nNombre: $nombre\nFecha: $fecha\nHora: $hora";

        // Envía el correo electrónico al usuario
        $mail->send();

        echo "¡Reserva exitosa! Se ha enviado una confirmación a tu correo electrónico y al administrador del sitio.";
    } catch (Exception $e) {
        echo "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
    }
} else {
    // Redireccionar si se intenta acceder directamente al archivo sin enviar datos del formulario.
    header("Location: index.html");
}
?>
