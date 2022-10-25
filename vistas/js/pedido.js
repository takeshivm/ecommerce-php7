
/*=============================================
BOTON VER DETALLE DE PEDIDO
=============================================*/

function verDetallePedido(idProducto, idVenta){

  var idCompra = $(this).attr("idProducto","idVenta");

  window.location = "index.php?ruta=pedido&idProducto="+idProducto+"&idVenta="+idVenta;
  console.log(idProducto," ,",idVenta);

}

/*=============================================
BOTON VER DETALLE DE DISPUTA
=============================================*/

function verDetalleDisputa(idDisputa){

  window.location = "index.php?ruta=disputa&idDisputa="+idDisputa;

}
