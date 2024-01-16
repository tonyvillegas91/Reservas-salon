document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('reservaForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Evita el envío del formulario por defecto
        reservar();
    });
});

function reservar() {
    var formData = new FormData(document.getElementById('reservaForm'));

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://tuservidor.herokuapp.com/procesar_reserva.php', true); // Reemplaza con la URL correcta de tu servidor
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status == 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                document.getElementById('mensajeReserva').innerHTML = response;
            } catch (error) {
                console.error("Error al procesar la respuesta JSON:", error);
            }
        }
    };
    xhr.send(formData);
}
