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
BREADCRUMB DISPUTA
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
SECCIÓN DISPUTA
======================================-->

<div class="container">
    
    <div class="row">    
	    
	    <div class="row bs-wizard" style="border-bottom:0;">
	        
	        <?php 

	        	if (isset($_GET["idDisputa"])!=true) {
	        		
	        		echo '<div class"col-xs-12 text-center error404">
	        				<h1><small>ERROR</small></h1>
	        				<h2><span> La disputa solicitada no existe, vuelva a recargar la pagina de productos en su perfil para visualizar su disputa1.</span></h2>
	        				</div>
	        				</div>
	        				</div>
	        				</div>
	        				';
	        				return;

	        	}else{
	        		$id = $_GET["idDisputa"];
	        		# code...
	        		$disputa = ControladorPedidos::ctrVerificarDipsuta("id",$id);
	        	}

	        	if ($disputa == "error") {
	        		echo '<div class"col-xs-12 text-center error404">
	        				<h1><small>ERROR</small></h1>
	        				<h2><span> La disputa solicitada no existe, vuelva a recargar la pagina de productos en su perfil para visualizar su disputa.</span></h2>
	        				</div>
	        				</div>
	        				</div>
	        				</div>
	        				';
	        				return;
	        	}else{

		    		$getDisputa = ControladorPedidos::ctrMostrarDisputa("id", $id);
		    	
		    		$item = "id";
		    		$valor = $getDisputa["idPedido"];
		    		$pedido = ControladorPedidos::ctrTraerPedido($item, $valor);
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
		    					<td style="color: hsl(140, 100%, 30%);">&nbsp<span> <?php echo $nameEnvio ?>  
												<br>&nbsp <?php echo $getDisputa["resolucion"] ?> </span></td>
		    				</tr>

		    				<tr>
		    					<td style="text-align: right; margin: 10px"><label>Observación:</label></td>
		    					<td>&nbsp<span> <?php echo $getDisputa["observacion"] ?>.</span></td>
		    				</tr>
		    				<tr>
		    					<td style="text-align: right; margin: 10px"><label>Resolución:</label></td>
		    					<td>&nbsp<span> <?php echo $getDisputa["resolucion"] ?>.
								</span></td>
		    				</tr>

		    			</table>
	    			</div>

				</div>

	    	</div>
	    	
	    </div>

	    <div class="panel">
			
			<div class="panel-title">
				<ul class="nav nav-pills card-header-pills">
					<li class="nav-item">
						<a class="nav-link active" href="#" style="font-weight: bold;">Detalles del pedido</a>
					</li>
				</ul>

			</div>
			<div class="panel-body" style="border-width:2px; border-style:solid; border-radius: 3px; border-color: hsl(240, 20%, 92%);">

				<div class="col-sm-8">

					<table style="margin-left: 50px; padding-top: 5px">
						<tr>
							<td style="text-align: right; margin: 10px; color: hsl(240, 20%, 70%);"><label>N.° Pedido:</label></td>
	    					<td>&nbsp<span> <?php echo $pedido["numPedido"] ?> </span></td>
						</tr>
						<tr>
							<td style="text-align: right; margin: 10px; color:  hsl(240, 20%, 70%);"><label>Total del pedido:</label></td>
	    					<td>&nbsp<span> <?php echo $pedido["totalPedido"] ?></span></td>
						</tr>
						<tr>
							<td style="text-align: right; margin: 10px; color:  hsl(240, 20%, 70%);"><label>Fecha del pedido:</label></td>
	    					<td>&nbsp<span> <?php echo $pedido["fecha"] ?></span></td>
						</tr>
						<tr>
							<td style="text-align: right; margin: 10px; color:  hsl(240, 20%, 70%);"><label>Comentarios:</label></td>
	    					<td>&nbsp<span> Leer debajo de los detalles del producto. </span></td>
						</tr>
						<tr>
							
							<td style="text-align: right; margin: 10px; color:  hsl(240, 20%, 70%);"><label>Dirección de envio:</label></td>
	    					<td>&nbsp
	    						<span> Psj.San pedro #193 - Urb. Las brisas chiclayo lambayeque PE 14820
	    						<?php echo $pedido["direccionEnvio"]." PE ".$pedido["codPostal"] ?></span>
	    					</td>

						</tr>
						<tr>
							<td style="text-align: right; margin: 10px; color:  hsl(240, 20%, 70%);"><label>Telefono:</label></td>
	    					<td>&nbsp<span> <?php echo $usuario["telefono"] ?> </span></td>
						</tr>

					</table>

				</div>

				<div class="col-sm-4" style="border-left: 2px; border-color: hsl(240, 20%, 92%);">
					
					<div class="panel">
						<div class="panel-title">
							Detalles del artículo:
						</div>

						<div class="panel-body">
							
							<div class="col-sm-4 col-xs-12">
								
								<figure>
									
									<?php echo '<img src="'.$servidor.$producto["portada"].'" class="img-thumbnail" alt="'.$producto["titulo"].'">'?>

								</figure>

							</div>

							<div class="col-sm-8 col-xs-12">

								<p style="color: hsl(225, 100%, 70%);"><?php echo $producto["descripcion"]?>.</p>

								<br>

								<p style="color: hsl(240, 20%, 70%);">Propiedades: <?php echo $detallesProducto["Color"][0]?>.
									<br>
									<span> Precio unitario: </span>
									<span style="color: hsl(0, 0%, 15%);">S/<?php echo $producto["precio"] ?></span>
									<span> Cantidad: </span>
									<span style="color: hsl(0, 0%, 15%);"><?php echo $pedido["cantidad"] ?></span>
								</p>

							</div>

						</div>

					</div>

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

								<p style="color: hsl(225, 100%, 70%);"><?php echo $producto["descripcion"]?>.</p>

								<br>

								<p style="color: hsl(240, 20%, 70%);">Color: <?php echo $detallesProducto["Color"][0]?>.
									<br>
									<span style="color: black;"> Empresa de transporte(<?php echo $pedido["empresaTransporte"]?>).</span>
								</p>

							</div>

						</td>
	    				<td>S/.4.50</td>
	    				<td>1</td>
	    				<td>S/.4.50</td>
	    				<td style="color: hsl(140, 100%, 30%);"><?php echo $nameEnvio ?></td>
	    				<td class="col-12"></td>
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
		    				<td>S/.<?php echo $producto["precio"]?></td>	
		    				<td>S/.<?php echo $pedido["gastosEnvio"]?></td>
		    				<td>S/.<?php echo $pedido["totalPedido"]?></td>
	    				</tr>
	    			</tfoot>
	    		</table>
	    		<div style="padding-right: 25px; text-align: left;">
	    			
	    		</div>

			</div>

	    </div>


		<!--=====================================
		CREAMOS EL INTERVALO DE TIEMPO DE LA DISPUTA
		======================================-->
		<div class="container" style="background-color: #ffd9b3; height: inherit;">
			<h3>Historial de disputas</h3>
			<h4 class="title_buyer">Comprador <?php echo $usuario["nombre"]?></h4>
			<div class="timeline_" style="border-top: solid;">
			  <div class="container_ left_" >
			    <div class="content_ comprador">
			      <h4>El comprador ha pagado el pedido</h4>
			      <p><span>Total: </span><?php echo $pedido["totalPedido"]?></p><br>
			    </div>
				  <div class="align-bottom date_line"><?php echo $pedido["fecha"]?></div>
			  </div>

			  <div class="container_ right_">
			    <div class="content_ vendedor">
			      
			      <h4>El vendedor envió el pedido</h4>
			      <span>N.° Seguimiento: </span><?php echo $pedido["numSeguimiento"]?><br>
			      <span>Método de envio: </span><?php echo $pedido["empresaTransporte"]?><br>
			      <span>Comentarios: <?php echo $pedido["observacion"]?></span><br>
			   
			    </div>
			  	<div class="align-bottom date_line"><?php echo $pedido["fecha"]?></div>
			  </div>

			  <?php 

			  	$comentarios = count($getDisputa["comentarios"])+1;
			  	$comens = $getDisputa["comentarios"];

			  	$decode = json_decode($comens, true);


				foreach($decode['chats'] as $k=>$v) {

				  foreach($v['mensajes'] as $k1=>$v1) {
				      
				     if ($v1["tipo"] == 'cliente') {

				     	echo '
				     		
							    <div class="container_ left_">
							    <div class="content_ comprador">
							      
							      <h4>'.$getDisputa["motivo"].'</h4>
							      <span>'.$comens[1].'<br>
							      <span>Propuesta: </span>'.$v1["propuesta"].'<br>
							      <span>Comentarios: </span>'.$v1["comentario"].'.<br>
							      <span>Prueba: </span> <br>

							    </div>
							  	<div class="align-bottom date_line">'.$getDisputa["fecha"].'</div>
							  </div>
				     	';
				     }else{
				     	echo'
				     		<div class="container_ right_">
							    <div class="content_ vendedor">
							      
							      <h4>El vendedor realizó una propuesta nueva</h4>
							      <span>Propuesta: </span>'.$v1["propuesta"].'<br>
							      <span>Comentarios: </span>'.$v1["comentario"].'<br>

							    </div>
						  		<div class="align-bottom date_line">'.$getDisputa["fecha"].'</div>

						  </div>

				     	';
				     }
				     

				  }// FIN 2do  CICLO FOR
				  

				}// FIN 1er CICLO FOR
				
				  if ($getDisputa["resolucion"] != "") {
				     	echo '
				     		<div class="container_ right_">
							    <div class="content_ finish_dispute">
							      
							      <h4>'.$getDisputa["resolucion"].'</h4>
							      <span>Propuesta: </span>'.$getDisputa["propuesta"].'<br>

							    </div>
							  	<div class="align-bottom date_line">'.$getDisputa["fecha"].'</div>
							</div>
				     	';
				     }
			  ?>

			</div>

		</div>
	
	</div>

</div>
