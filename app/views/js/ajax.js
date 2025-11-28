/* Enviar formularios via AJAX */
const formularios_ajax = document.querySelectorAll(".FormularioAjax");
const campana = document.getElementById('campana-notificacion');
const dropdown = document.getElementById('dropdown-stock');
const contador = document.getElementById('contador-stock');
const listaStock = document.getElementById('lista-stock');

formularios_ajax.forEach(formularios => {

    formularios.addEventListener("submit", function (e) {

        e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Quieres realizar la acción solicitada",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, realizar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                let data = new FormData(this);
                let method = this.getAttribute("method");
                let action = this.getAttribute("action");
                let encabezados = new Headers();
                let config = {
                    method: method,
                    headers: encabezados,
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                };
                fetch(action, config)
                        .then(respuesta => respuesta.json())
                        .then(respuesta => {
                            return alertas_ajax(respuesta);
                        });
            }
        });
    });
});
function alertas_ajax(alerta) {
    if (alerta.tipo == "simple") {

        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        });
    } else if (alerta.tipo == "recargar") {

        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
    } else if (alerta.tipo == "limpiar") {

        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(".FormularioAjax").reset();
            }
        });
    } else if (alerta.tipo == "redireccionar") {
        window.location.href = alerta.url;
    }
}


function cargarNotificacionesStock() {
    fetch('../app/ajax/contadorStockAjax.php') // Ruta correcta al archivo PHP
            .then(res => res.json())
            .then(data => {
                const contador = document.getElementById('contador-stock');
                // Mostrar el total de productos con stock bajo (menor a 5)
                if (data.total > 0) {
                    // Si el total es mayor que 99, mostrar "99+" como límite
                    contador.textContent = data.total > 99 ? "99+" : data.total;
                    contador.style.display = "inline-block";
                } else {
                    contador.style.display = "none"; // Si no hay productos con stock bajo, ocultar el contador
                }

                // Opcional: Mostrar los productos con stock bajo en una lista
                
            })
            .catch(error => {
                console.error('Error al cargar las notificaciones de stock:', error);
            });
}

// Llamar al cargar la página y cada cierto tiempo
cargarNotificacionesStock();
setInterval(cargarNotificacionesStock, 30000); // cada 30 segundos

campana.addEventListener('click', () => {
    if (dropdown.style.display === "none") {
        dropdown.style.display = "block";
        cargarListaStock();
    } else {
        dropdown.style.display = "none";
    }
});

function cargarListaStock() {
    fetch(`${APP_URL}app/ajax/listarStockBajo.php`)
    .then(res => res.json())
    .then(data => {
        console.log(data); // Asegúrate de que los datos lleguen correctamente
        const listaStock = document.getElementById('lista-stock');
        listaStock.innerHTML = '';
        listaStock.style.display = "flex";
        listaStock.style.flexDirection = "column";
        listaStock.style.gap = "10px";

        if (data.length > 0) {
            data.forEach(prod => {
                const tarjeta = document.createElement('div');
                tarjeta.style.color = 'black';
                tarjeta.style.border = '1px solid #ccc';
                tarjeta.style.borderLeft = '5px solid red';
                tarjeta.style.borderRadius = '5px';
                tarjeta.style.padding = '10px';
                tarjeta.style.marginBottom = '10px';
                tarjeta.style.backgroundColor = '#fff';
                tarjeta.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';
                tarjeta.style.fontSize = '14px';

                tarjeta.innerHTML = `
                    <strong>Producto:</strong> ${prod.producto_nombre} <br>
                    <span style="color: red;"><strong>Stock:</strong> ${prod.producto_stock_total}</span> 
                `;

                listaStock.appendChild(tarjeta);
            });
        } else {
            listaStock.innerHTML = '<div>No hay productos con bajo stock.</div>';
        }
    })
    .catch(error => {
        console.error('Error al cargar la lista de productos con bajo stock:', error);
    });

}







/* Boton cerrar sesion */
let btn_exit = document.querySelectorAll(".btn-exit");
btn_exit.forEach(exitSystem => {
    exitSystem.addEventListener("click", function (e) {

        e.preventDefault();
        Swal.fire({
            title: '¿Quieres salir del sistema?',
            text: "La sesión actual se cerrará y saldrás del sistema",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, salir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = this.getAttribute("href");
                window.location.href = url;
            }
        });
    });
});