<?php

include_once "../extensiones/Requests/library/Requests.php";
Requests::register_autoloader();
include_once "../extensiones/culqi-php/lib/culqi.php";

require_once "../modelos/rutas.php";
require_once "../controladores/carrito.controlador.php";
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


class CulqiPago
{
	public $mensaje;
	public $url;
	
	static public function mdlPagoCulqi($datos)
	{
		$email = $datos["email"];
		//$cantidadArray = explode(",", $datos["cantidadArray"]);
		//$valorItemArray = explode(",", $datos["valorItemArray"]);
		$idProductos = str_replace(",","-", $datos["idProductoArray"]);
		$cantidadProductos = str_replace(",","-", $datos["cantidadArray"]);
		$pagoProductos = str_replace(",","-", $datos["valorItemArray"]);
		
		$productos = explode(",", $datos['idProductoArray']);
		$cantidad = explode(",", $datos['cantidadArray']);

		for($i = 0; $i < count($productos); $i++){

			$url = Ruta::ctrRuta();
		
			$ordenar = "id";
		    $item = "id";
		    $valor = $productos[$i];

			$productosCompra = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

		    foreach ($productosCompra as $key => $value) {	

				//$item3 = "stock";
		        //$valor3 = $value["stock"] - $cantidad[$i];
		        //$actualizarCompra2 = ControladorProductos::ctrActualizarProducto($item3, $valor3, $item2, $valor2);

		        if ($value["stock"] <= $cantidad[$i]) {
		        	$object = new CulqiPago();
		        	$object->mensaje = "Stock insuficiente en el producto ".$value["titulo"];
					$object->url = "$url/carrito-de-compras";

					$redireccionar = json_encode($object);
			   		//$redireccionar = "$url/carrito-de-compras?mensaje=".$mssge;
					return $redireccionar;
		        }

		    }

		}


		try {
			
			$comercio = ControladorCarrito::ctrMostrarTarifas(); 

			$SECRET_KEY = $comercio["secretKeyCulqi"];
			//$SECRET_KEY = "sk_test_XEdWqJdRNw0Ba93S";

			$culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

			$charge = $culqi->Charges->create(
			 array(
			     "amount" => str_replace(".", "", $datos["total"]),
			     "capture" => true,
			     "currency_code" => $datos["divisa"],
			     "description" => "Venta en modo Sanbox",
			     "email" => $datos["email"],
			     "installments" => 0,
			     "source_id" => $datos["token"]
			   )
			);

	    	$url = Ruta::ctrRuta();
			
			$redireccionar = '';
			$estado = '';
			
			if (isset($charge->outcome->type) && $charge->outcome->type == 'venta_exitosa') {
				
				$estado = $charge->outcome->type;
				$pais = $charge->source->client->ip_country_code;

				//	METODO DE CULQI PARA OBTENER UN CARGA A TRAVEZ DE SU ID 
				//	Ejemplo-> "id": "chr_test_KJpC7QaOMExtIJLk",
				//$cargoId = $culqi->Charges->get($charge->id);
				//$datosCargo = json_encode($cargoId);

				$object = new CulqiPago();
				$object->url =  "$url/index.php?ruta=finalizar-compra&culqi=true&productos=".$idProductos."&cantidad=".$cantidadProductos."&pago=".$pagoProductos."&estado=".$estado."&email=".$email."&pais=".$pais;

				$redireccionar = json_encode($object);

			}else{

				$estado = $charge->merchant_message;
				$mssge = $charge->user_message;

				$object = new CulqiPago();
				$object->mensaje = $mssge;
				$object->url = "$url/carrito-de-compras";

				$redireccionar = json_encode($object);

	   			//$redireccionar = "$url/carrito-de-compras";
			
			}
			
			return $redireccionar;

		} catch (Exception $e) {
		
			//return $e;
			$mssge = $charge->user_message;
			$object = new CulqiPago();
			$object->mensaje = $mssge;
			$object->url = "$url/carrito-de-compras";

			$redireccionar = json_encode($object);
	   		//$redireccionar = "$url/carrito-de-compras?mensaje=".$mssge;
			return $redireccionar;

		}

	}

}
