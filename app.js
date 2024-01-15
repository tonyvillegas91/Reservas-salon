document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('reservaForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Evita el envío del formulario por defecto
        reservar();
    });
});

function reservar() {
    var formData = new FormData(document.getElementById('reservaForm'));

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'procesar_reserva.php', true);
    xhr.onload = function () {
        if (xhr.status == 200) {
            document.getElementById('mensajeReserva').innerHTML = xhr.responseText;
        }
    };
    xhr.send(formData);
}
