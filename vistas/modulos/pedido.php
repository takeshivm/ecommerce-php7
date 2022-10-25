<!--=====================================
VALIDAR SESIÓN
======================================-->

<?php

$url = Ruta::ctrRuta();
$servidor = Ruta::ctrRutaServidor();

$social = ControladorPlantilla::ctrEstiloPlantilla();


if(!isset($_SESSION["validarSesion"])){

	echo '<script>
	
		window.location = "'.$url.'";

	</script>';

	exit();

}

?>

<!--=====================================
BREADCRUMB PERFIL
======================================-->

<div class="container-fluid well well-sm">
	
	<div class="container">
		
		<div class="row">
			
			<ul class="breadcrumb fondoBreadcrumb text-uppercase">
				
				<li><a href="<?php echo $url;  ?>">INICIO</a></li>
				<li class="active pagActiva"><?php echo $rutas[0] ?></li>

			</ul>

		</div>

	</div>

</div>

<!--=====================================
SECCIÓN PERFIL
======================================-->

<div class="container-fluid">
    
    <div class="row">    
	    
	    <div class="row bs-wizard" style="border-bottom:0;">
	        
	    	<?php 

	    		$item1 = "id_producto";
	    		$item2 = "id_venta";
	    		$valor1 = $_GET["idProducto"];
	    		$valor2 = $_GET["idVenta"];
	    	
	    		$pedido = ControladorPedidos::ctrMostrarPedido($item1, $valor1, $item2, $valor2);
	    		$estadoEnvio = $pedido["estadoEnvio"];

	    		$nameEnvio = ControladorPedidos::ctrMostrarNombreEnvio($estadoEnvio);
	    		$venta = ControladorCarrito::ctrMostrarVenta("id",$pedido["id_venta"]);
	    		$usuario = ControladorUsuarios::ctrMostrarUsuario("id", $venta["id_cliente"]);
	    		$producto = ControladorProductos::ctrMostrarInfoProducto("id",$pedido["id_producto"]);
	    		$detallesProducto = json_decode($producto["detalles"], true);
	    		//echo implode("|",$producto);
	    		for ($i=0; $i < 4; $i++) {

	    			$status = '';
	    			$name = '';

	    			if ($i === $estadoEnvio || $i <= $estadoEnvio) {
	    				$status = 'complete';
	    			}else{
		    			$status = 'disabled';
	    			}

	    			switch ($i) {
		    			case 0:
		    				 $name = 'Realizar pedido';
		    				 break;
		    			case 1:
		    				 $name = 'Pago correcto';
		    				 break;
		    			case 2:
		    				 $name = 'Envío';
		    				 break;
		    			case 3:
		    				 $name = 'Pedido completado';
		    				break;
		    			default:
		    				break;
	    			}

	    			echo '<div class="col-xs-3 bs-wizard-step '.$status.'"><div class="text-center bs-wizard-stepnum">'.($i+1).'</div><div class="progress"><div class="progress-bar"></div></div><a href="#" class="bs-wizard-dot"></a><div class="bs-wizard-info text-center">'.$name.'</div></div>';
					          
	    		}

	 
	    	?>

	    </div>

	    <div class="col">
	    	
	    	<div class="card">	
	    		<div class="card-body;">
	    			<div class="well">

		    			<table style="margin-left: 100px">
		    				<tr>
		    					<td style="text-align: right; margin: 10px"><label>N° Pedido:</label></td>
		    					<td>&nbsp<span> <?php echo $pedido["numPedido"] ?> </span></td>
		    				</tr>

		    				<tr>
		    					<td style="text-align: right; margin: 10px"><label>Estado:</label></td>
		    					<td>&nbsp<span> <?php echo $nameEnvio ?> </span></td>
		    				</tr>

		    				<tr>
		    					<td style="text-align: right; margin: 10px"><label>Observación:</label></td>
		    					<td>&nbsp<span> <?php echo $pedido["observacion"] ?> </span></td>
		    				</tr>
		    			</table>
	    			</div>

				</div>

	    	</div>

	    	<div class="panel panel-default">
    			
    			<div class="panel-heading">
    				Informción del seguimiento
    			</div>

    			<div class="panel-body">
    				
		    		<table class="table">
		    			
		    			<tr style="border-top: hidden;">
		    				<td>Empresa de transporte</td>
		    				<td>N° Seguimiento</td>
		    				<td>Observaciones</td>
		    				<td>Detalles</td>
		    			</tr>
		    			<tr>
		    				<td><?php echo $pedido["empresaTransporte"] ?></td>
		    				<td><?php echo $pedido["numSeguimiento"] ?></td>
		    				<td><?php echo $pedido["observacion"] ?></td>
		    				<td><?php echo $pedido["detallesEnvio"] ?></td>
		    			</tr>
		    		</table>

    			</div>

	    	</div>

	    		
	    	
	    </div>

	    <div class="card">
			
			<div class="card-header">
				<ul class="nav nav-pills card-header-pills">
					<li class="nav-item">
						<a class="nav-link active" href="#">Datos el cliente</a>
					</li>
				</ul>

			</div>
			<div class="card-body ">

				<div class="container" style="border-style: ridge; background-color: hsl(31, 100%, 90%); padding: 15px;">
					<table style="margin-left: 50px; padding-top: 5px">
						<tr>
							<td style="text-align: right; margin: 10px; color: hsl(240, 20%, 55%);"><label>Nombre:</label></td>
	    					<td>&nbsp<span> <?php echo $usuario["nombre"]?> </span></td>
						</tr>
						<tr>
							<td style="text-align: right; margin: 10px; color:  hsl(240, 20%, 55%);"><label>Contacto:</label></td>
	    					<td>&nbsp<span> <?php echo $usuario["domicilio"]." - ".$usuario["ciudad"]." - ".$usuario["region"] ?> </span></td>
						</tr>
						<tr>
							<td style="text-align: right; margin: 10px; color:  hsl(240, 20%, 55%);"><label>Código postal:</label></td>
	    					<td>&nbsp<span> <?php echo $usuario["codigoPostal"]?> </span></td>
						</tr>
						<tr>
							<td style="text-align: right; margin: 10px; color:  hsl(240, 20%, 55%);"><label>Móvil:</label></td>
	    					<td>&nbsp<span> <?php echo $usuario["telefono"]?> </span></td>
						</tr>
						<tr>
							<td style="text-align: right; margin: 10px; color:  hsl(240, 20%, 55%);"><label>E-mail:</label></td>
	    					<td>&nbsp<span> <?php echo $usuario["email"]?> </span></td>
						</tr>
					</table>
				</div>

			</div>

		</div>	

		<div class="panel panel-default" style="margin-top: 15px">
    			
    			<div class="panel-body">
    				
		    		<table class="table">
		    			
		    			<thead >
		    				<td >Detalles del articulo</td>
		    				<td >Precio por unidad</td>
		    				<td >Cantidad</td>
		    				<td >Total pedido</td>
		    				<td >Estado</td>
		    				<td >Detalles</td>
		    			</thead>
		    			<tr>

		    				<td class="col-md-auto">
		    					<div class="col-sm-4 col-xs-12">
								
									<figure>
										<?php echo '<img src="'.$servidor.$producto["portada"].'" class="img-thumbnail" alt="'.$producto["titulo"].'">'?>

									</figure>

								</div>

								<div class="col-sm-8 col-xs-12">

									<p style="color: hsl(225, 100%, 70%);">
										<?php echo $producto["descripcion"]?>
									.</p>

									<br>

									<p style="color: hsl(240, 20%, 70%);">Color: <?php echo $detallesProducto["Color"][0]?>.
										<br>
										<span style="color: black;"> Empresa de transporte (<?php echo $pedido["empresaTransporte"]?>).</span>
									</p>

								</div>

							</td>
		    				<td><?php echo $producto["precio"]?></td>
		    				<td><?php echo $pedido["cantidad"]?></td>
		    				<td><?php echo $pedido["totalPedido"]?></td>
		    				<td style="color: hsl(140, 100%, 30%);"><?php echo $pedido["estadoEnvio"]?></td>
		    				<td class="col-12"><?php echo $pedido["detallesEnvio"]?></td>
		    			</tr>
		    			<tfoot style="align-content: flex-end; background-color: hsl(180, 20%, 75%);">
		    				<tr>
		    					<td></td>
		    					<td></td>
			    				<td></td>
			    				<td>Precio del articulo</td>	
			    				<td>Gastos de envio</td>
			    				<td>Importe total</td>
		    				</tr>
		    				<tr style="font-weight: bold; color: hsl(12, 100%, 35%);">
		    					<td></td>
		    					<td></td>
			    				<td></td>
			    				<td><?php echo $producto["precio"]?></td>
			    				<td><?php echo $pedido["cantidad"]?></td>
			    				<td><?php echo $pedido["totalPedido"]?></td>
		    				</tr>
		    			</tfoot>
		    		</table>
		    		<div style="padding-right: 25px; text-align: left;">
		    			
		    		</div>

    			</div>

	    	</div>

	</div>

</div>
