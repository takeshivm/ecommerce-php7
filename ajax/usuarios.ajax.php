<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{

	/*=============================================
	VALIDAR EMAIL EXISTENTE
	=============================================*/	

	public $validarEmail;

	public function ajaxValidarEmail(){

		$datos = $this->validarEmail;

		$respuesta = ControladorUsuarios::ctrMostrarUsuario("email", $datos);

		echo json_encode($respuesta);

	}

	/*=============================================
	MODIFICAR USUARIO
	=============================================*/	

	//public $idUsuario; ya etsa inicializado
	public $ciudad;
	public $region;
	public $codigoPostal;
	public $domicilio;
	public $telefono;

	public function ajaxModificarUsuario(){

		$datos = array("idUsuario"=>$this->idUsuario,
					   "ciudad"=>$this->ciudad,
					   "region"=>$this->region,
					   "codigoPostal"=>$this->codigoPostal,
					   "domicilio"=>$this->domicilio,
					   "telefono"=>$this->telefono
					   );

		$respuesta = ControladorUsuarios::ctrModificarUsuario($datos);

		echo json_encode($respuesta);

	}

	/*=============================================
	REGISTRO CON FACEBOOK
	=============================================*/

	public $email;
	public $nombre;
	public $foto;

	public function ajaxRegistroFacebook(){

		$datos = array("nombre"=>$this->nombre,
					   "email"=>$this->email,
					   "foto"=>$this->foto,
					   "password"=>"null",
					   "modo"=>"facebook",
					   "verificacion"=>0,
					   "emailEncriptado"=>"null");

		$respuesta = ControladorUsuarios::ctrRegistroRedesSociales($datos);

		echo $respuesta;

	}	

	/*=============================================
	AGREGAR A LISTA DE DESEOS
	=============================================*/	

	public $idUsuario;
	public $idProducto;

	public function ajaxAgregarDeseo(){

		$datos = array("idUsuario"=>$this->idUsuario,
					   "idProducto"=>$this->idProducto);

		$respuesta = ControladorUsuarios::ctrAgregarDeseo($datos);

		echo $respuesta;

	}

	/*=============================================
	QUITAR PRODUCTO DE LISTA DE DESEOS
	=============================================*/

	public $idDeseo;	

	public function ajaxQuitarDeseo(){

		$datos = $this->idDeseo;

		$respuesta = ControladorUsuarios::ctrQuitarDeseo($datos);

		echo $respuesta;

	}


}

/*=============================================
VALIDAR EMAIL EXISTENTE
=============================================*/	

if(isset($_POST["validarEmail"])){

	$valEmail = new AjaxUsuarios();
	$valEmail -> validarEmail = $_POST["validarEmail"];
	$valEmail -> ajaxValidarEmail();

}

/*=============================================
REGISTRO CON FACEBOOK
=============================================*/


if(isset($_POST["email"])){

	$regFacebook = new AjaxUsuarios();
	$regFacebook -> email = $_POST["email"];
	$regFacebook -> nombre = $_POST["nombre"];
	$regFacebook -> foto = $_POST["foto"];
	$regFacebook -> ajaxRegistroFacebook();

}

/*=============================================
AGREGAR A LISTA DE DESEOS
=============================================*/	

if(isset($_POST["idUsuario"])){

	$deseo = new AjaxUsuarios();
	$deseo -> idUsuario = $_POST["idUsuario"];
	$deseo -> idProducto = $_POST["idProducto"];
	$deseo ->ajaxAgregarDeseo();
}

/*=============================================
QUITAR PRODUCTO DE LISTA DE DESEOS
=============================================*/

if(isset($_POST["idDeseo"])){

	$quitarDeseo = new AjaxUsuarios();
	$quitarDeseo -> idDeseo = $_POST["idDeseo"];
	$quitarDeseo ->ajaxQuitarDeseo();
}


/*=============================================
MODIFICAR EL DOMICILIO DEL USUA+RIO
=============================================*/

if(isset($_POST["domicilio"]) && isset($_POST["idUsuarioDomicilio"])){

	$quitarDeseo = new AjaxUsuarios();
	$quitarDeseo -> idUsuario = $_POST["idUsuarioDomicilio"];
	$quitarDeseo -> ciudad = $_POST["ciudad"];
	$quitarDeseo -> region = $_POST["region"];
	$quitarDeseo -> codigoPostal = $_POST["codigoPostal"];
	$quitarDeseo -> domicilio = $_POST["domicilio"];
	$quitarDeseo -> telefono = $_POST["telefono"];
	$quitarDeseo ->ajaxModificarUsuario();
}
