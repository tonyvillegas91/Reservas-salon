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
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status == 200) {
            try {
                // Intenta analizar la respuesta como JSON
                var response = JSON.parse(xhr.responseText);
                document.getElementById('mensajeReserva').innerHTML = response;
            } catch (error) {
                // Si no se puede analizar como JSON, trata la respuesta como texto simple
                document.getElementById('mensajeReserva').innerHTML = xhr.responseText;
            }
        }
    };
    xhr.send(formData);
}

