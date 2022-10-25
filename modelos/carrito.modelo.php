<?php

require_once "conexion.php";

class ModeloCarrito{

	/*=============================================
	MOSTRAR TARIFAS
	=============================================*/

	static public function mdlMostrarTarifas($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt =null;

	}


	/*=============================================
	MOSTRAR VENTA
	=============================================*/

	static public function mdlMostrarVenta($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

		//$stmt->bindParam(":item", $item, PDO::PARAM_STR);
		$stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt =null;

	}

	/*=============================================
	ÚLTIMA VENTA
	=============================================*/

	static public function mdlUltimaVenta($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT MAX(CAST(numero AS UNSIGNED)) numero FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	NUEVA VENTA (DESPUES DE REALIZAR LA VENTA)
	=============================================*/

	static public function mdlNuevaVenta($tabla, $datos){

		$db = Conexion::conectar();

		$stmt = $db->prepare("INSERT INTO $tabla (serie, numero, sub_total, igv, total, anular, modo, documento, tipo_documento, id_cliente) VALUES (:serie, :numero, :sub_total, :igv, :total, 0, :modo, :documento, :tipo_documento, :id_cliente)");

		$stmt->bindParam(":serie", $datos["serie"], PDO::PARAM_STR);
		$stmt->bindParam(":numero", $datos["numero"], PDO::PARAM_STR);
		$stmt->bindParam(":sub_total", $datos["sub_total"], PDO::PARAM_STR);
		$stmt->bindParam(":igv", $datos["igv"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":modo", $datos["modo"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);

		if($stmt->execute()){

			$stmte = $db->query("SELECT LAST_INSERT_ID()");
			$idVenta = $stmte->fetchColumn();

			$json = array(
						'estado' => 'ok',
						'id' => $idVenta
						);

			$jsonVenta = json_encode($json, JSON_FORCE_OBJECT);
			return $jsonVenta;
			//return "ok"; 

		}else{ 

			$json = array('estado' => 'error');

			$jsonVenta = json_encode($json, JSON_FORCE_OBJECT);
			return $jsonVenta;
			//return "error"; 

		}

		$stmt->close();

		$stmt =null;
	}

	/*=============================================
	NUEVAS COMPRAS
	=============================================*/

	static public function mdlNuevasCompras($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_usuario, id_producto, metodo, email, direccion, pais, cantidad, detalle, pago, id_venta) VALUES (:id_usuario, :id_producto, :metodo, :email, :direccion, :pais, :cantidad, :detalle, :pago, :id_venta)");

		$stmt->bindParam(":id_usuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_INT);
		$stmt->bindParam(":metodo", $datos["metodo"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":pais", $datos["pais"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
		$stmt->bindParam(":pago", $datos["pago"], PDO::PARAM_STR);
		$stmt->bindParam(":id_venta", $datos["id_venta"], PDO::PARAM_INT);

		if($stmt->execute()){ 

			return "ok"; 

		}else{ 

			return "error"; 

		}

		$stmt->close();

		$stmt =null;
	}

	/*=============================================
	VERIFICAR PRODUCTO COMPRADO
	=============================================*/

	static public function mdlVerificarProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario AND id_producto = :id_producto");

		$stmt->bindParam(":id_usuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt =null;

	}

}