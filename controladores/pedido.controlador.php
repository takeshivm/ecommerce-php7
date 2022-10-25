<?php

class ControladorPedidos {

	public function ctrMostrarPedido($item1, $valor1, $item2, $valor2){

		$tabla = "pedido";
		$respuesta = ModeloPedidos::mdlMostrarPedido($tabla, $item1, $valor1, $item2, $valor2);
		return $respuesta;

	}

	public function ctrTraerPedido($item1, $valor1){

		$tabla = "pedido";
		$respuesta = ModeloPedidos::mdlTraerPedido($tabla, $item1, $valor1);
		return $respuesta;

	}

	public function ctrMostrarDisputa($item1, $valor1){

		$tabla = "disputa";
		$respuesta = ModeloPedidos::mdlMostrarDisputa($tabla, $item1, $valor1);
		return $respuesta;

	}

	public function ctrVerificarDipsuta($item1, $valor1){

		$tabla = "disputa";
		$respuesta = ModeloPedidos::mdlVerificarDisputa($tabla, $item1, $valor1);
		return $respuesta;

	}

	public function ctrMostrarNombreEnvio($valor){

		$nameEnvio = "";

		switch ($valor) {
			case 0:
				 $nameEnvio = 'Realizar pedido';
				 break;
			case 1:
				 $nameEnvio = 'Pago correcto';
				 break;
			case 2:
				 $nameEnvio = 'Envío';
				 break;
			case 3:
				 $nameEnvio = 'Pedido completado';
				break;
			default:
				break;
		}

		return $nameEnvio;

	}
	
}