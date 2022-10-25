<?php

require_once "../extensiones/paypal.controlador.php";

require_once "../extensiones/culqi.controlador.php";

require_once "../controladores/carrito.controlador.php";
require_once "../modelos/carrito.modelo.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

//$SECRET_KEY = "sk_test_XEdWqJdRNw0Ba93S";
/*
$culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

$charge = $culqi->Charges->create(
 array(
     "amount" => 1500,
     "currency_code" => "PEN",
     "email" => "test_charge@culqi.com",
     "source_id" => "id del objeto Token o id del objeto Card"
   )
);
*/


class AjaxCarrito{

	/*=============================================
	MÉTODO PAYPAL
	=============================================*/	

	public $token;
	public $email;

	public $divisa;
	public $total;
	public $totalEncriptado;
	public $impuesto;
	public $envio;
	public $subtotal;
	public $tituloArray;
	public $cantidadArray;
	public $valorItemArray;
	public $idProductoArray;

	public function ajaxEnviarPaypal(){

		if(md5($this->total) == $this->totalEncriptado){

				$datos = array(
						"divisa"=>$this->divisa,
						"total"=>$this->total,
						"impuesto"=>$this->impuesto,
						"envio"=>$this->envio,
						"subtotal"=>$this->subtotal,
						"tituloArray"=>$this->tituloArray,
						"cantidadArray"=>$this->cantidadArray,
						"valorItemArray"=>$this->valorItemArray,
						"idProductoArray"=>$this->idProductoArray,
					);

				$respuesta = Paypal::mdlPagoPaypal($datos);

				echo $respuesta;

		}
	}

	/*=============================================
	MÉTODO CULQI
	=============================================*/

	public function ajaxEnviarCulqi(){
		 
		if(md5($this->total) == $this->totalEncriptado){

				$datos = array(
						"token"=>$this->token,
						"email"=>$this->email,
						"divisa"=>$this->divisa,
						"total"=>$this->total,
						"impuesto"=>$this->impuesto,
						"envio"=>$this->envio,
						"subtotal"=>$this->subtotal,
						"tituloArray"=>$this->tituloArray,
						"cantidadArray"=>$this->cantidadArray,
						"valorItemArray"=>$this->valorItemArray,
						"idProductoArray"=>$this->idProductoArray,
					);

				$respuesta = CulqiPago::mdlPagoCulqi($datos);

				//echo json_encode($respuesta);
				echo $respuesta;

		}
		//echo "ok";
	}

	/*=============================================
	MÉTODO PAYU
	=============================================*/

	public function ajaxTraerComercioPayu(){

		$respuesta = ControladorCarrito::ctrMostrarTarifas(); 

		echo json_encode($respuesta);

	}


	/*=============================================
	TRAER VENTA
	=============================================*/
	public $item_venta;
	public $id_venta;

	public function ajaxTraerVenta(){

		$respuesta = ControladorCarrito::ctrMostrarVenta($this->item_venta, $this->id_venta); 

		echo json_encode($respuesta);

	}

	/*=============================================
	TRAER DETALLE DE VENTA
	=============================================*/

	public function ajaxTraerDetalleVenta(){

		$respuesta = ControladorUsuarios::ctrMostrarCompras($this->item_venta, $this->id_venta); 

		echo json_encode($respuesta);

	}

	/*=============================================
	VERIFICAR QUE NO TENGA EL PRODUCTO ADQUIRIDO
	=============================================*/

	public $idUsuario;
	public $idProducto;

	public function ajaxVerificarProducto(){

		$datos = array("idUsuario"=>$this->idUsuario,
					   "idProducto"=>$this->idProducto);

		$respuesta = ControladorCarrito::ctrVerificarProducto($datos);

		echo json_encode($respuesta);

	}

}

/*=============================================
MÉTODO PAYPAL
=============================================*/	

if(isset($_POST["divisa"])){

	$idProductos = explode("," , $_POST["idProductoArray"]);
	$cantidadProductos = explode("," , $_POST["cantidadArray"]);
	$precioProductos = explode("," , $_POST["valorItemArray"]);

	$item = "id";

	for($i = 0; $i < count($idProductos); $i ++){

		$valor = $idProductos[$i];

		$verificarProductos = ControladorProductos::ctrMostrarInfoProducto($item, $valor);

		$divisa = file_get_contents("http://free.currconv.com/api/v7/convert?q=PEN_".$_POST["divisa"]."&compact=ultra&apiKey=a01ebaf9a1c69eb4ff79");

		$jsonDivisa = json_decode($divisa, true);

		$conversion = number_format($jsonDivisa["PEN_".$_POST["divisa"]],2);

		if($verificarProductos["precioOferta"] == 0){

			$precio = $verificarProductos["precio"]*$conversion;
		
		}else{

			$precio = $verificarProductos["precioOferta"]*$conversion;

		}

		$verificarSubTotal = $cantidadProductos[$i]*$precio;

		// LINEAS DE CÓDIGO COMENTADA PARA VERIFICAR LA COHERENCIA ENTRE LOS 
		// PRECIOS DE PRODUCTOS ENVIADOS.

		 //echo number_format($verificarSubTotal,2)."<br>";
		 //echo number_format($precioProductos[$i],2)."<br>";

		// return;

		if(number_format($verificarSubTotal,2) != number_format($precioProductos[$i],2)){

			echo "carrito-de-compras";

			return;

		}

	}

	$paypal = new AjaxCarrito();
	$paypal ->divisa = $_POST["divisa"];
	$paypal ->total = $_POST["total"];
	$paypal ->totalEncriptado = $_POST["totalEncriptado"];
	$paypal ->impuesto = $_POST["impuesto"];
	$paypal ->envio = $_POST["envio"];
	$paypal ->subtotal = $_POST["subtotal"];
	$paypal ->tituloArray = $_POST["tituloArray"];
	$paypal ->cantidadArray = $_POST["cantidadArray"];
	$paypal ->valorItemArray = $_POST["valorItemArray"];
	$paypal ->idProductoArray = $_POST["idProductoArray"];
	$paypal -> ajaxEnviarPaypal();


}

/*=============================================
MÉTODO PAYU
=============================================*/	

if(isset($_POST["metodoPago"]) && $_POST["metodoPago"] == "payu"){

	$idProductos = explode("," , $_POST["idProductoArray"]);
	$cantidadProductos = explode("," , $_POST["cantidadArray"]);
	$precioProductos = explode("," , $_POST["valorItemArray"]);

	$item = "id";

	for($i = 0; $i < count($idProductos); $i ++){

		$valor = $idProductos[$i];

		$verificarProductos = ControladorProductos::ctrMostrarInfoProducto($item, $valor);

		$divisa = file_get_contents("http://free.currconv.com/api/v7/convert?q=PEN_".$_POST["divisaPayu"]."&compact=ultra&apiKey=a01ebaf9a1c69eb4ff79");

		$jsonDivisa = json_decode($divisa, true);

		//DIVISA PREDETERMINADA POR DEFECTO
		//$conversion = number_format($jsonDivisa["USD_".$_POST["divisaPayu"]],2);
		$conversion = number_format($jsonDivisa["PEN_".$_POST["divisaPayu"]],2);

		if($verificarProductos["precioOferta"] == 0){

			$precio = $verificarProductos["precio"]*$conversion;
		
		}else{

			$precio = $verificarProductos["precioOferta"]*$conversion;

		}

		$verificarSubTotal = $cantidadProductos[$i]*$precio;

		// echo number_format($verificarSubTotal,2)."<br>";
		// echo number_format($precioProductos[$i],2)."<br>";

		// return;

		if(number_format($verificarSubTotal,2) != number_format($precioProductos[$i],2)){

			echo "carrito-de-compras";

			return;

		}

	}

	$payu = new AjaxCarrito();
	$payu -> ajaxTraerComercioPayu();

}


/*=============================================
MÉTODO CULQI
=============================================*/	

if(isset($_POST["metodoPago"]) && $_POST["metodoPago"] == "culqi"){

	$pKeyCq = 'pk_test_93BJJFemeT05ZgVx';

	if (!isset($_POST["pk"]) && $_POST('pk') != $pKeyCq) {
		
		echo "carrito-de-compras";

		return;
	}

	$idProductos = explode("," , $_POST["idProductoArray"]);
	$cantidadProductos = explode("," , $_POST["cantidadArray"]);
	$precioProductos = explode("," , $_POST["valorItemArray"]);

	$item = "id";

	for($i = 0; $i < count($idProductos); $i ++){

		$valor = $idProductos[$i];

		$verificarProductos = ControladorProductos::ctrMostrarInfoProducto($item, $valor);

		/*$divisa = file_get_contents("http://free.currconv.com/api/v7/convert?q=PEN_".$_POST["divisaCulqi"]."&compact=ultra&apiKey=a01ebaf9a1c69eb4ff79");

		$jsonDivisa = json_decode($divisa, true);
*/
		//$conversion = number_format($jsonDivisa["PEN_".$_POST["divisaCulqi"]],2);
		$conversion = number_format("1.0000",2);


		//if($verificarProductos["precioOferta"] == 0){
		if($verificarProductos["oferta"] == 0){

			$precio = $verificarProductos["precio"]*$conversion;
		
		}else{

			$precio = $verificarProductos["precioOferta"]*$conversion;

		}

		$verificarSubTotal = $cantidadProductos[$i]*$precio;

		// echo number_format($verificarSubTotal,2)."<br>";
		// echo number_format($precioProductos[$i],2)."<br>";

		// return;

		if(number_format($verificarSubTotal,2) != number_format($precioProductos[$i],2)){

			echo "carrito-de-compras";

			return;

		}

	}

	$paypal = new AjaxCarrito();
	$paypal ->token = $_POST["token"];
	$paypal ->email = $_POST["email"];
	$paypal ->divisa = $_POST["divisaCulqi"];
	$paypal ->total = $_POST["total"];
	$paypal ->totalEncriptado = $_POST["totalEncriptado"];
	$paypal ->impuesto = $_POST["impuesto"];
	$paypal ->envio = $_POST["envio"];
	$paypal ->subtotal = $_POST["subtotal"];
	$paypal ->tituloArray = $_POST["tituloArray"];
	$paypal ->cantidadArray = $_POST["cantidadArray"];
	$paypal ->valorItemArray = $_POST["valorItemArray"];
	$paypal ->idProductoArray = $_POST["idProductoArray"];
	$paypal -> ajaxEnviarCulqi();

	//$payu = new AjaxCarrito();
	//$payu -> ajaxTraerComercioPayu();

}


/*=============================================
VERIFICAR QUE NO TENGA EL PRODUCTO ADQUIRIDO
=============================================*/	

if(isset($_POST["idUsuario"])){

	$deseo = new AjaxCarrito();
	$deseo -> idUsuario = $_POST["idUsuario"];
	$deseo -> idProducto = $_POST["idProducto"];
	$deseo ->ajaxVerificarProducto();
}


/*=============================================
VERIFICAR QUE NO TENGA EL PRODUCTO ADQUIRIDO
=============================================*/	

if(isset($_POST["id_venta"])){

	$deseo = new AjaxCarrito();
	$deseo -> id_venta = $_POST["id_venta"];
	$deseo -> item_venta = $_POST["item_venta"];
	$deseo ->ajaxTraerVenta();
}


/*=============================================
MOSTRAR LOS DETALLES DE LA VENTA (COMPRAS)
=============================================*/	

if(isset($_POST["idVenta"])){

	$deseo = new AjaxCarrito();
	$deseo -> id_venta = $_POST["idVenta"];
	$deseo -> item_venta = $_POST["item_venta"];
	$deseo ->ajaxTraerDetalleVenta();
}