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
        if (xhr.status >= 200 && xhr.status < 300) {
            try {
                var response = JSON.parse(xhr.responseText);
    
                // Muestra el mensaje o el error
                if (response.mensaje) {
                    alert(response.mensaje);
                } else if (response.error) {
                    alert('Error: ' + response.error);
                } else {
                    alert('Respuesta inesperada');
                }
            } catch (error) {
                // Si no se puede analizar como JSON, trata la respuesta como texto simple
                alert(xhr.responseText);
            }
        } else {
            // Si la solicitud no fue exitosa, muestra el mensaje de error
            alert('Error en la solicitud. Código de estado: ' + xhr.status);
        }
    };

    // No establezcas manualmente el Content-Type aquí para que el navegador lo maneje automáticamente
    xhr.send(formData);
}
