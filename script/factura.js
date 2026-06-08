function agregarProducto(){
    return confirm("¿Agregar producto a la factura?");
}

function eliminarProducto(){
    return confirm("¿Eliminar producto de la factura?");
}

function vaciarFactura(){
    return confirm("¿Vaciar toda la factura?");
}

function finalizarCompra(){
    return confirm("¿Desea finalizar la compra?");
}

document.addEventListener("DOMContentLoaded", function(){

    const cantidades =
        document.querySelectorAll(".cantidad");

    cantidades.forEach(function(input){

        input.addEventListener("input", function(){

            let precio =
                parseFloat(this.dataset.precio);

            let cantidad =
                parseInt(this.value) || 1;

            let subtotal =
                precio * cantidad;

            this.closest("form")
                .querySelector(".subtotal")
                .innerHTML =
                "$" + subtotal.toFixed(2);

        });

    });

});