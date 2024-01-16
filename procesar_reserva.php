// procesar_reserva.php

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];

    // Procesar la reserva como antes

    $response = "¡Reserva exitosa! Se ha enviado una confirmación a tu correo electrónico y al administrador del sitio.";
    echo json_encode($response);
} else {
    echo json_encode("Error: Método no permitido");
}
