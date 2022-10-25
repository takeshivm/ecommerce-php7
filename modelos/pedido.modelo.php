<?php

require_once "conexion.php";

class ModeloPedidos{

	static public function mdlMostrarPedido($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item1 = :$item1 AND $item2 = :$item2");

		$param1 = (int)$valor1;
		$param2 = (int)$valor2;

		$stmt -> bindParam(":".$item1, $param1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $param2, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	} 

	static public function mdlTraerPedido($tabla, $item1, $valor1){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item1 = :$item1");

		$param1 = (int)$valor1;

		$stmt -> bindParam(":".$item1, $param1, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarDisputa($tabla, $item1, $valor1){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item1 = :$item1");

		$param1 = (int)$valor1;

		$stmt -> bindParam(":".$item1, $param1, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	} 


	static public function mdlVerificarDisputa($tabla, $item1, $valor1){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item1 = :$item1");

		$param1 = (int)$valor1;

		$stmt -> bindParam(":".$item1, $param1, PDO::PARAM_INT);

		if($stmt -> execute()){
			if ($stmt -> fetch() != null) {
				return "ok";
			}else{
				return "error";
			}
		
		}else{

			return "error";	

		}
		
		$stmt -> close();

		$stmt = null;

	} 


}