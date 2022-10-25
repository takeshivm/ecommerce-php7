<?php 
///require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/rutas.php";

$url = Ruta::ctrRuta();

$dni = $_POST["dni"];
$urlEnvio = $url."extensiones/api/v1/dni/".$dni."?token=abcxyz";

$conexion = curl_init();

//GET
curl_setopt($conexion, CURLOPT_URL, $urlEnvio);
curl_setopt($conexion, CURLOPT_HTTPGET, FALSE);
curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json'));
//curl_setopt($conexion, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSV1_2);
curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($conexion, CURLOPT_USERPWD, "user:pass");

$respuesta = curl_exec($conexion);

//curl_close($conexion);

echo json_encode($respuesta);
//echo json_encode($urlEnvio);