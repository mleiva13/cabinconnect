const frm = document.querySelector("#formulario");
const terminos = document.querySelector('#chb2');
document.addEventListener("DOMContentLoaded", function () {
    frm.addEventListener("submit", function (e) {
        e.preventDefault();
        if (
            frm.nombre.value == "" ||
            frm.apellido.value == "" ||
            frm.usuario.value == "" ||
            frm.correo.value == "" ||
            frm.clave.value == "" ||
            frm.confirmar.value == "") {
            alertaSW("Todos los campos son requeridos", "warning");
        } else if (!terminos.checked) {
            alertaSW("Acepte los terminos y condiciones", "warning");
        } else { 
            if (frm.clave.value == frm.confirmar.value) {
                const http = new XMLHttpRequest();
                const url = base_url + 'registro/crear';
                http.open("POST", url, true);
                http.send(new FormData(frm));
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        const res = JSON.parse(this.responseText);
                        alertaSW(res.msg, res.tipo); 
                        if (res.tipo == "success") {
                            frm.reset();
                            //MANDAR A OTRA RUTA
                            window.location = base_url + 'reserva/pendiente';
                        }
                    }
                };
            } else {
                alertaSW("Las contraseñas no Coinciden", "warning");
            }
            
        }
    });
});