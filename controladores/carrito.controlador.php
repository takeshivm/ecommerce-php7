<?php

class ControladorCarrito{

	/*=============================================
	MOSTRAR TARIFAS
	=============================================*/

	public function ctrMostrarTarifas(){

		$tabla = "comercio";

		$respuesta = ModeloCarrito::mdlMostrarTarifas($tabla);

		return $respuesta;

	}	

	/*=============================================
	MOSTRAR VENTA
	=============================================*/

	public function ctrMostrarVenta($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloCarrito::mdlMostrarVenta($tabla, $item, $valor);

		return $respuesta;

	}	

	/*=============================================
	ULTIMA VENTA
	=============================================*/

	static public function ctrUltimaVenta(){

		$tabla = "ventas";

		$respuesta = ModeloCarrito::mdlUltimaVenta($tabla);
	 
	    return $respuesta;

		
	}


	/*=============================================
	NUEVA VENTA
	=============================================*/

	static public function ctrNuevaVenta($datos){

		$tabla = "ventas";

		$respuesta = ModeloCarrito::mdlNuevaVenta($tabla, $datos);
	 
	    return $respuesta;

		
	}

	/*=============================================
	NUEVAS COMPRAS (DESPUES DE REALIZAR LA VENTA)
	=============================================*/

	static public function ctrNuevasCompras($datos){

		$tabla = "compras";

		$respuesta = ModeloCarrito::mdlNuevasCompras($tabla, $datos);

		if($respuesta == "ok"){

			$tabla = "comentarios";
			ModeloUsuarios::mdlIngresoComentarios($tabla, $datos);

			/*=============================================
			ACTUALIZAR NOTIFICACIONES NUEVAS VENTAS
			=============================================*/

			$traerNotificaciones = ControladorNotificaciones::ctrMostrarNotificaciones();

			$nuevaVenta = $traerNotificaciones["nuevasVentas"] + 1;

			ModeloNotificaciones::mdlActualizarNotificaciones("notificaciones", "nuevasVentas", $nuevaVenta);


		}

		return $respuesta;

	}

	/*=============================================
	VERIFICAR PRODUCTO COMPRADO
	=============================================*/

	static public function ctrVerificarProducto($datos){

		$tabla = "compras";

		$respuesta = ModeloCarrito::mdlVerificarProducto($tabla, $datos);
	 
	    return $respuesta;

		
	}

}