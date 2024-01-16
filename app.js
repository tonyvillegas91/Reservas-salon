document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('reservaForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Evita el envío del formulario por defecto
        reservar();
    });
});

function reservar() {
    var formData = new FormData(document.getElementById('reservaForm'));

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://shielded-ocean-39017-ae1344eea549.herokuapp.com/procesar_reserva.php', true);

    xhr.onload = function () {
        if (xhr.status == 200) {
            try {
                // Intenta analizar la respuesta como JSON
                var response = JSON.parse(xhr.responseText);

                // Verifica si hay un mensaje en la respuesta
                if (response.mensaje) {
                    document.getElementById('mensajeReserva').innerHTML = response.mensaje;
                } else if (response.error) {
                    // Si no hay mensaje, verifica si hay un error
                    document.getElementById('mensajeReserva').innerHTML = 'Error: ' + response.error;
                } else {
                    // Manejo de otros casos si es necesario
                    document.getElementById('mensajeReserva').innerHTML = 'Respuesta inesperada';
                }
            } catch (error) {
                // Si no se puede analizar como JSON, trata la respuesta como texto simple
                document.getElementById('mensajeReserva').innerHTML = xhr.responseText;
            }
        } else {
            // Si la solicitud no fue exitosa, muestra el mensaje de error
            document.getElementById('mensajeReserva').innerHTML = 'Error en la solicitud: ' + xhr.statusText;
        }
    };

    // No establezcas manualmente el Content-Type aquí para que el navegador lo maneje automáticamente
    xhr.send(formData);
}
