<?php

class ControladorPlantilla{

	/*=============================================
	LLAMAMOS LA PLANTILLA
	=============================================*/

	public function plantilla(){

		include "vistas/plantilla.php";

	}

	/*=============================================
	TRAEMOS LOS ESTILOS DINÁMICOS DE LA PLANTILLA
	=============================================*/

	public function ctrEstiloPlantilla(){

		$tabla = "plantilla";

		$respuesta = ModeloPlantilla::mdlEstiloPlantilla($tabla);

		return $respuesta;
	}

	/*=============================================
	TRAEMOS LAS CABECERAS
	=============================================*/

	static public function ctrTraerCabeceras($ruta){

		$tabla = "cabeceras";

		$respuesta = ModeloPlantilla::mdlTraerCabeceras($tabla, $ruta);

		return $respuesta;	

	}

	/*=============================================
	TRAEMOS LA DIVISA PRINCIPAL DEL COMERCIO
	=============================================*/

	static public function ctrTraerDivisa($tabla){

		$respuesta = ModeloPlantilla::mdlEstiloPlantilla($tabla);

		return $respuesta;	

	}

	public function ctrTraerPlantillaMensajes(){

		include "vistas/modulos/mensajes.php";

	} 

}