// procesar_reserva.php

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];

    // Procesar la reserva como antes

    $response = array(
        'mensaje' => '¡Reserva exitosa! Se ha enviado una confirmación a tu correo electrónico y al administrador del sitio.',
        'error' => null  // No hay error en este caso
    );

    echo json_encode($response);
} else {
    $response = array(
        'mensaje' => null,
        'error' => 'Error: Método no permitido'
    );

    echo json_encode($response);
}
