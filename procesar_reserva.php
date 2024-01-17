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

        // Aumentar el nivel de depuración
        $mail->SMTPDebug = 3;

        // Intentar conectarse al servidor SMTP varias veces
        for ($intentos = 1; $intentos <= 3; $intentos++) {
            try {
                // Configuración del remitente y destinatario
                $mail->setFrom('tonyvillegas91@hotmail.com', 'Tony Villegas Brea');
                $mail->addAddress($correo, $nombre); // $correo y $nombre son variables obtenidas del formulario

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Confirmación de Reserva';
                $mail->Body = 'Gracias por tu reserva.';

                // Antes de iniciar la conexión SMTP
                error_log('Antes de iniciar la conexión SMTP');

                // Enviar el correo
                $mail->send();

                // Después de enviar el correo
                error_log('Correo enviado exitosamente');
                
                return true; // Éxito, salimos de la función
            } catch (Exception $e) {
                // Intentar de nuevo después de un breve intervalo
                sleep(1);
            }
        }

        // Si llegamos aquí, todos los intentos fallaron
        error_log('Error al enviar el correo: No se pudo conectar al servidor SMTP después de varios intentos');
        throw new Exception('Error al enviar el correo: No se pudo conectar al servidor SMTP después de varios intentos');
    } catch (Exception $e) {
        // Lanzar excepción para manejar errores fuera de esta función
        error_log('Error al enviar el correo: ' . $e->getMessage());
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
