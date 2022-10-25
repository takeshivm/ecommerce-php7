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

	<div class="container">

		<ul class="nav nav-tabs">
		  
	  		<li class="active">	  			
			  	<a data-toggle="tab" href="#compras">
			  	<i class="fa fa-list-ul"></i> MIS COMPRAS</a>
	  		</li>

	  		<li> 				
		  		<a data-toggle="tab" href="#deseos">
		  		<i class="fa fa-gift"></i> MI LISTA DE DESEOS</a>
	  		</li>

	  		<li>				
	  			<a data-toggle="tab" href="#perfil">
	  			<i class="fa fa-user"></i> EDITAR PERFIL</a>
	  		</li>

	  		<li>				
		 	 	<a href="<?php echo $url; ?>ofertas">
		 	 	<i class="fa fa-star"></i>	VER OFERTAS</a>
	  		</li>

	  		<li>				
	  			<a data-toggle="tab" href="#mensajes">
	  			<i class="fa fa-user"></i> MENSAJES</a>
	  		</li>
		
		</ul>

		<div class="tab-content">

			<!--=====================================
			PESTAÑA COMPRAS
			======================================-->

	  		<div id="compras" class="tab-pane fade in active">
		    
				<div class="panel-group">

				<?php

					$item = "id_usuario";
					$valor = $_SESSION["id"];

					$compras = ControladorUsuarios::ctrMostrarCompras($item, $valor);

					$seleccionarDNI = $_SESSION["tipo_documento"]=="dni"?"selected":"";
					$seleccionarRUC = $_SESSION["tipo_documento"]=="ruc"?"selected":"";

					if(!$compras){

						echo '<div class="col-xs-12 text-center error404">
				               
				    		<h1><small>¡Oops!</small></h1>
				    
				    		<h2>Aún no tienes compras realizadas en esta tienda</h2>

				  		</div>';

					}else{

						foreach ($compras as $key => $value1) {

							$ordenar = "id";
							$item = "id";
							$valor = $value1["id_producto"];

							//$id_venta = $value1["id_venta"];

							$productos = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

							foreach ($productos as $key => $value2) {
							
								echo '<div class="panel panel-default">
									    
									    <div class="panel-body">

											<div class="col-md-2 col-sm-6 col-xs-12">

												<figure>
												
													<img class="img-thumbnail" src="'.$servidor.$value2["portada"].'">

												</figure>

											</div>

											<div class="col-sm-6 col-xs-12">

												<h1><small>'.$value2["titulo"].'</small></h1>

												<p>'.$value2["titular"].'</p>';

												if($value2["tipo"] == "virtual"){

													echo '<a href="'.$url.'curso/'.$value1["id"].'/'.$value1["id_usuario"].'/'.$value1["id_producto"].'/'.$value2["ruta"].'">
														<button class="btn btn-default pull-left">Ir al curso</button>
														</a>';

												}else{

													echo '<h6>Proceso de entrega: '.$value2["entrega"].' días hábiles</h6>';

													if($value1["envio"] == 0){

														echo '<div class="progress">

															<div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%">
																<i class="fa fa-check"></i> Despachado
															</div>

															<div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%">
																<i class="fa fa-clock-o"></i> Enviando
															</div>

															<div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%">
																<i class="fa fa-clock-o"></i> Entregado
															</div>

														</div>';

													}

													if($value1["envio"] == 1){

														echo '<div class="progress">

															<div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%">
																<i class="fa fa-check"></i> Despachado
															</div>

															<div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%">
																<i class="fa fa-check"></i> Enviando
															</div>

															<div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%">
																<i class="fa fa-clock-o"></i> Entregado
															</div>

														</div>';

													}

													if($value1["envio"] == 2){

														echo '<div class="progress">

															<div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%">
																<i class="fa fa-check"></i> Despachado
															</div>

															<div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%">
																<i class="fa fa-check"></i> Enviando
															</div>

															<div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%">
																<i class="fa fa-check"></i> Entregado
															</div>

														</div>';

													}

												}

												echo '<h4 class="pull-right"><small>Comprado el '.substr($value1["fecha"],0,-8).'</small></h4>

													<button class="btn btn-warning" onclick="verDetalleVenta('.$value1["id_venta"].')">Ver detalle de venta</button>
													<button class="btn btn-warning" onclick="verDetallePedido('.$value1["id_producto"].','.$value1["id_venta"].')">Ver detalle de pedido</button>
																
											</div>

											<div class="col-md-4 col-xs-12">';

											$datos = array("idUsuario"=>$_SESSION["id"],
															"idProducto"=>$value2["id"] );

											$comentarios = ControladorUsuarios::ctrMostrarComentariosPerfil($datos);

												echo '<div class="pull-right">

													<a class="calificarProducto" href="#modalComentarios" data-toggle="modal" idComentario="'.$comentarios["id"].'">
													
														<button class="btn btn-default backColor">Calificar Producto</button>

													</a>

												</div>

												<br><br>

												<div class="pull-right">

													<h3 class="text-right">';

													if($comentarios["calificacion"] == 0 && $comentarios["comentario"] == ""){

														echo '<i class="fa fa-star-o text-success" aria-hidden="true"></i>
																<i class="fa fa-star-o text-success" aria-hidden="true"></i>
																<i class="fa fa-star-o text-success" aria-hidden="true"></i>
																<i class="fa fa-star-o text-success" aria-hidden="true"></i>
																<i class="fa fa-star-o text-success" aria-hidden="true"></i>';

													}else{

														switch($comentarios["calificacion"]){

															case 0.5:
															echo '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

															case 1.0:
															echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

															case 1.5:
															echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

															case 2.0:
															echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

															case 2.5:
															echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

															case 3.0:
															echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

															case 3.5:
															echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

															case 4.0:
															echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

															case 4.5:
															echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>';
															break;

															case 5.0:
															echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>';
															break;

														}


													}
												
														
													echo '</h3>

													<p class="panel panel-default text-right" style="padding:5px">

														<small>

														'.$comentarios["comentario"].'

														</small>
													
													</p>

												</div>

											</div>

									    </div>

									</div>';

							}
							
						}
					}
				?>
				  
				

				</div>

		  	</div>

		  	<!--=====================================
			PESTAÑA DESEOS
			======================================-->

		  	<div id="deseos" class="tab-pane fade">
		    	
			<?php

				$item = $_SESSION["id"];

				$deseos = ControladorUsuarios::ctrMostrarDeseos($item);

				if(!$deseos){

					echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center error404">
				               
			    		<h1><small>¡Oops!</small></h1>
			    
			    		<h2>Aún no tiene productos en su lista de deseos</h2>

			  		</div>';
				
				}else{

					foreach ($deseos as $key => $value1) {

						$ordenar = "id";
						$valor = $value1["id_producto"];
						$item = "id";

						$productos = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

						echo '<ul class="grid0">';

							foreach ($productos as $key => $value2) {
							
							echo '<li class="col-md-3 col-sm-6 col-xs-12">

									<figure>
										
										<a href="'.$url.$value2["ruta"].'" class="pixelProducto">
											
											<img src="'.$servidor.$value2["portada"].'" class="img-responsive">

										</a>

									</figure>

									<h4>
							
										<small>
											
											<a href="'.$url.$value2["ruta"].'" class="pixelProducto">
												
												'.$value2["titulo"].'<br>

												<span style="color:rgba(0,0,0,0)">-</span>';
												$fecha = date('Y-m-d');
												$fechaActual = strtotime('-30 day', strtotime($fecha));
												$fechaNueva = date('Y-m-d', $fechaActual);

												if($fechaNueva < $value["fecha"]){

													echo '<span class="label label-warning fontSize">Nuevo</span> ';

												}

												if($value2["oferta"] != 0){

													echo '<span class="label label-warning fontSize">'.$value2["descuentoOferta"].'% off</span>';

												}

											echo '</a>	

										</small>			

									</h4>

									<div class="col-xs-6 precio">';

									if($value2["precio"] == 0){

										echo '<h2 style="margin-top:-10px"><small>GRATIS</small></h2>';

									}else{

										if($value2["oferta"] != 0){

											echo '<h2 style="margin-top:-10px">

													<small>
								
														<strong class="oferta" style="font-size:12px">USD $'.$value2["precio"].'</strong>

													</small>

													<small>$'.$value2["precioOferta"].'</small>
												
												</h2>';

										}else{

											echo '<h2 style="margin-top:-10px"><small>USD $'.$value2["precio"].'</small></h2>';

										}
										
									}
													
									echo '</div>

									<div class="col-xs-6 enlaces">
										
										<div class="btn-group pull-right">
											
											<button type="button" class="btn btn-danger btn-xs quitarDeseo" idDeseo="'.$value1["id"].'" data-toggle="tooltip" title="Quitar de mi lista de deseos">
												
												<i class="fa fa-heart" aria-hidden="true"></i>

											</button>';

											if($value2["tipo"] == "virtual" && $value2["precio"] != 0){

												if($value2["oferta"] != 0){

													echo '<button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="'.$value2["id"].'" imagen="'.$servidor.$value2["portada"].'" titulo="'.$value2["titulo"].'" precio="'.$value2["precioOferta"].'" tipo="'.$value2["tipo"].'" peso="'.$value2["peso"].'" data-toggle="tooltip" title="Agregar al carrito de compras">

													<i class="fa fa-shopping-cart" aria-hidden="true"></i>

													</button>';

												}else{

													echo '<button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="'.$value2["id"].'" imagen="'.$servidor.$value2["portada"].'" titulo="'.$value2["titulo"].'" precio="'.$value2["precio"].'" tipo="'.$value2["tipo"].'" peso="'.$value2["peso"].'" data-toggle="tooltip" title="Agregar al carrito de compras">

													<i class="fa fa-shopping-cart" aria-hidden="true"></i>

													</button>';

												}

											}

											echo '<a href="'.$url.$value2["ruta"].'" class="pixelProducto">
											
												<button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Ver producto">
													
													<i class="fa fa-eye" aria-hidden="true"></i>

												</button>	
											
											</a>

										</div>

									</div>

								</li>';
							}

						echo '</ul>';


					}

				}

			?>


		  	</div>

			<!--=====================================
			PESTAÑA PERFIL
			======================================-->
		  	
		  	<div id="perfil" class="tab-pane fade">
		    	
				<div class="row">
					
					<form method="post" enctype="multipart/form-data" onsubmit="return actualzarUsuario()">
					
						<div class="col-md-3 col-sm-4 col-xs-12 text-center">
							
							<br>

							<figure id="imgPerfil">
								
							<?php

							echo '<input type="hidden" value="'.$_SESSION["id"].'" id="idUsuario" name="idUsuario">
							      <input type="hidden" value="'.$_SESSION["password"].'" name="passUsuario">
							      <input type="hidden" value="'.$_SESSION["foto"].'" name="fotoUsuario" id="fotoUsuario">
							      <input type="hidden" value="false" name="estadoDoc" id="estadoDoc">
							      <input type="hidden" value="'.$_SESSION["modo"].'" name="modoUsuario" id="modoUsuario">';


							if($_SESSION["modo"] == "directo"){

								if($_SESSION["foto"] != ""){

									echo '<img src="'.$url.$_SESSION["foto"].'" class="img-thumbnail">';

								}else{

									echo '<img src="'.$servidor.'vistas/img/usuarios/default/anonymous.png" class="img-thumbnail">';

								}
					

							}else{

								echo '<img src="'.$_SESSION["foto"].'" class="img-thumbnail">';
							}		

							?>

							</figure>

							<br>

							<?php

							if($_SESSION["modo"] == "directo"){
							
							echo '<button type="button" class="btn btn-default" id="btnCambiarFoto">
									
									Cambiar foto de perfil
									
									</button>';

							}

							?>

							<div id="subirImagen">
								
								<input type="file" class="form-control" id="datosImagen" name="datosImagen">

								<img class="previsualizar">

							</div>

						</div>	

						<div class="col-md-9 col-sm-8 col-xs-12">

						<br>
							
						<?php

						if($_SESSION["modo"] != "directo"){

							echo '<label class="control-label text-muted text-uppercase">Nombre:</label>
									
									<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input type="text" class="form-control"  value="'.$_SESSION["nombre"].'" readonly>

									</div>

									<br>

									<label class="control-label text-muted text-uppercase">Correo electrónico:</label>
									
									<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input type="text" class="form-control"  value="'.$_SESSION["email"].'" readonly>

									</div>

									<br>

									<label class="control-label text-muted text-uppercase">Modo de registro en el sistema:</label>
									
									<div class="input-group">
								
										<span class="input-group-addon"><i class="fa fa-'.$_SESSION["modo"].'"></i></span>
										<input type="text" class="form-control text-uppercase" id="modo" name="modo" value="'.$_SESSION["modo"].'" readonly>


									<label class="control-label text-muted text-uppercase" for="editarDocumento">Cambiar Documento:</label>

					                <div class="form-group">

					                  <div class="input-group col-xs-12">
				                      
					                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
					                    
					                    <select class="form-control col-xs-5" id="tipoDocumento" name="tipoDocumento" required>
					                      <option value="">Tipo Documento</option>
					                      <option value="dni" '.$seleccionarDNI.'>DNI</option>
					                      <option value="ruc" '.$seleccionarRUC.'>RUC</option>
					                    </select>

					                    <input type="number" class="form-control editarDocumento col-xs-7" id="editarDocumento"  placeholder="Ingresar documento" name="editarDocumento" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="'.$_SESSION["numero_documento"].'" required>

									    <span class="input-group-addon">
									    	<input-group style="padding: 12px 10px;" type="button" class="btn btn-primary validarDocumento" name="validarDocumento" id="validarDocumento" value="VALIDAR" onclick="validarDocs()">VALIDAR</input>
									    </span>

					                  </div>

									</div>

									<br>

									<label class="control-label text-muted text-uppercase" for="editarCiudad">Cambiar Ciudad:</label>

									<div class="input-group">
									
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
											<input type="text" class="form-control" id="editarCiudad" name="editarCiudad" value="'.$_SESSION["ciudad"].'" required>

										</div>

									<br>

									<label class="control-label text-muted text-uppercase" for="editarRegion">Cambiar Región:</label>

									<div class="input-group">
									
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
											<input type="text" class="form-control" id="editarRegion" name="editarRegion" value="'.$_SESSION["region"].'" required>

										</div>

									<br>

									<label class="control-label text-muted text-uppercase" for="editarCodigoPostal">Cambiar código postal:</label>

									<div class="input-group">
									
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
											<input type="text" class="form-control" id="editarCodigoPostal" name="editarCodigoPostal" value="'.$_SESSION["codigoPostal"].'">

										</div>

									<br>

									<label class="control-label text-muted text-uppercase" for="editarDireccion">Cambiar código postal:</label>

									<div class="input-group">
									
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
											<input type="text" class="form-control" id="editarDireccion" name="editarDireccion" value="'.$_SESSION["domicilio"].'" required>

										</div>

									<br>

									<label class="control-label text-muted text-uppercase" for="editarTelefono">Cambiar Teléfono:</label>

									<div class="input-group">
									
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
											<input type="text" class="form-control" id="editarTelefono" name="editarTelefono" value="'.$_SESSION["telefono"].'">

										</div>

									<br>

									<button type="submit" class="btn btn-default backColor btn-md pull-left">Actualizar Datos</button>';
		

						}else{

							echo '<label class="control-label text-muted text-uppercase" for="editarNombre">Cambiar Nombre:</label>
									
									<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input type="text" class="form-control" id="editarNombre" name="editarNombre" value="'.$_SESSION["nombre"].'">

									</div>

								<br>

								<label class="control-label text-muted text-uppercase" for="editarEmail">Cambiar Correo Electrónico:</label>

								<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
										<input type="text" class="form-control" id="editarEmail" name="editarEmail" value="'.$_SESSION["email"].'">

									</div>

								<br>

								<label class="control-label text-muted text-uppercase" for="editarPassword">Cambiar Contraseña:</label>

								<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input type="text" class="form-control" id="editarPassword" name="editarPassword" placeholder="Escribe la nueva contraseña">

									</div>
								
								<br>

								<label class="control-label text-muted text-uppercase" for="editarDocumento">Cambiar Documento:</label>

				                <div class="form-group">

				                  <div class="input-group col-xs-12">
				                      
				                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
					                    
				                    <select class="form-control col-xs-5" id="tipoDocumento" name="tipoDocumento" required>
				                      <option value="">Tipo Documento</option>
				                      <option value="dni" '.$seleccionarDNI.'>DNI</option>
					                  <option value="ruc" '.$seleccionarRUC.'>RUC</option>
				                    </select>

				                    <input type="number" class="form-control editarDocumento col-xs-7" id="editarDocumento"  placeholder="Ingresar documento" name="editarDocumento" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="'.$_SESSION["numero_documento"].'" required>

								    <span class="input-group-addon">
								    	<input-group style="padding: 12px 10px;" type="button" class="btn btn-primary validarDocumento" name="validarDocumento" id="validarDocumento" value="VALIDAR" onclick="validarDocs()">VALIDAR</input>
								    </span>

				                  </div>
				                  

				                </div>

				                <br> 

								<label class="control-label text-muted text-uppercase" for="editarCiudad">Cambiar Ciudad:</label>

								<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input type="text" class="form-control" id="editarCiudad" name="editarCiudad" value="'.$_SESSION["ciudad"].'" required>

									</div>

								<br>

								<label class="control-label text-muted text-uppercase" for="editarRegion">Cambiar Región:</label>

								<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input type="text" class="form-control" id="editarRegion" name="editarRegion" value="'.$_SESSION["region"].'" required>

									</div>

								<br>

								<label class="control-label text-muted text-uppercase" for="editarCodigoPostal">Cambiar código postal:</label>

								<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input type="text" class="form-control" id="editarCodigoPostal" name="editarCodigoPostal" value="'.$_SESSION["codigoPostal"].'">

									</div>

								<br>

								<label class="control-label text-muted text-uppercase" for="editarDireccion">Cambiar dirección:</label>

								<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input type="text" class="form-control" id="editarDireccion" name="editarDireccion" value="'.$_SESSION["domicilio"].'" required>

									</div>

								<br>

								<label class="control-label text-muted text-uppercase" for="editarTelefono">Cambiar Teléfono:</label>

								<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input type="text" class="form-control" id="editarTelefono" name="editarTelefono" value="'.$_SESSION["telefono"].'">

									</div>

								<br>
								<button type="submit" class="btn btn-default backColor btn-md pull-left">Actualizar Datos</button>';

//<button type="button" class="btn btn-default backColor btn-md pull-left" onclick="validateEmail()">validar email</button>
//<button type="button" class="btn btn-default backColor btn-md pull-left" onclick="validateEmail2()">validar email 2</button>
						}

						?>

						</div>

						<?php

							$actualizarPerfil = new ControladorUsuarios();
							$actualizarPerfil->ctrActualizarPerfil();

						?>					

					</form>

					<button class="btn btn-danger btn-md pull-right" id="eliminarUsuario">Eliminar cuenta</button>

					<?php

							$borrarUsuario = new ControladorUsuarios();
							$borrarUsuario->ctrEliminarUsuario();

						?>	

				</div>

		  	</div>

		  	<div id="mensajes" class="tab-pane fade">
		  		
		  		<?php 
		  			
		  			$plantillaMsjes = new ControladorPlantilla();
		  			$plantillaMsjes -> ctrTraerPlantillaMensajes();


		  		?>

		  	</div>

		</div>

	</div>

</div>

<!--=====================================
VENTANA MODAL PARA COMENTARIOS
======================================-->

<div  class="modal fade modalFormulario" id="modalComentarios" role="dialog">
	
	<div class="modal-content modal-dialog">
		
		<div class="modal-body modalTitulo">
			
			<h3 class="backColor">CALIFICA ESTE PRODUCTO</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<form method="post" onsubmit="return validarComentario()">

				<input type="hidden" value="" id="idComentario" name="idComentario">
				
				<h1 class="text-center" id="estrellas">

		       		<i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>

				</h1>

				<div class="form-group text-center">

		       		<label class="radio-inline"><input type="radio" name="puntaje" value="0.5">0.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="1.0">1.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="1.5">1.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="2.0">2.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="2.5">2.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="3.0">3.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="3.5">3.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="4.0">4.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="4.5">4.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="5.0" checked>5.0</label>

				</div>

				<div class="form-group">
			  		
			  		<label for="comment" class="text-muted">Tu opinión acerca de este producto: <span><small>(máximo 300 caracteres)</small></span></label>
			  		
			  		<textarea class="form-control" rows="5" id="comentario" name="comentario" maxlength="300" required></textarea>

			  		<br>
					
					<input type="submit" class="btn btn-default backColor btn-block" value="ENVIAR">

				</div>

				<?php

					$actualizarComentario = new ControladorUsuarios();
					$actualizarComentario -> ctrActualizarComentario();

				?>

			</form>

		</div>

		<div class="modal-footer">
      	
      	</div>

	</div>

</div>

<!--=====================================
VENTANA MODAL PARA MOSTRAR VENTA, SELECCIONADA
PREVIAMENTE EN EL DETALLE DE LAS COMPRAS.
BOTON -> MOSTRAR DETALLE VENTA
======================================-->

<div  class="modal fade modalDetalleVenta" id="modalDetalleVenta" role="dialog">
	
	<div class="modal-content modal-dialog modal-lg">
		
		<div class="modal-body">
			
			<div id="inventory-invoice">

			    <div class="toolbar hidden-print">
			        <div class="text-right">
			            <button id="printInvoiceeditado" class="btn btn-info" onclick="PrintThisDiv()"><i class="fa fa-print"></i> Imprimir</button>
			            <a href="javascript:generarPDF()" class="button">
			            	<button class="btn btn-success"><i class="fa fa-file-pdf-o"></i> Exportar como PDF</button>
			            </a>
			        </div>
			        <hr>
			    </div>
			    <div class="invoice imprimirDocumento overflow-auto" id="imprimirDocumento">
			        <div style="min-width: 600px">
			            <header>
			                <div class="row">
			                    <div class="col">
			                        <a target="_blank" href="#">
			                            <img src="<?php echo $servidor.$social["logo"]; ?>" class="img-responsive">
			                            </a>
			                    </div>
			                    <div class="col company-details">
			                        <h2 class="name">
			                            <a target="_blank" href="#">
			                            Net System
			                            </a>
			                        </h2>
			                        <div>Santa catalina #120- Las brisas, Chiclayo - 14011, PERÚ</div>
			                        <div>(074) 589023</div>
			                        <div>info@netsystem.com</div>
			                    </div>
			                </div>
			            </header>
			            <main>
			                <div class="row contacts">
			                    <div class="col invoice-to">
			                        <div class="text-gray-light">Boleta para:</div>
			                        <h2 class="nombreCliente">Nombre: <?php echo $_SESSION["nombre"]?></h2>
			                        <div class="direccionCliente">Dirección: <?php echo $_SESSION["domicilio"].', '. $_SESSION["ciudad"].', '. $_SESSION["region"]?></div>
			                        <div class="emailCliente">Email: <a href="mailto:<?php echo $_SESSION["email"]?>"><?php echo $_SESSION["email"]?></a></div>
			                        <div class="telefonoCliente">Telefono: <?php echo $_SESSION["telefono"]?></div>
			                        <div class="documentoCliente">Documento: <?php echo $_SESSION["numero_documento"]?></div>
			                    </div>
			                    <div class="col invoice-details">
			                        <h1 class="numeroVenta">INVOICE 121</h1>
			                        <div class="fechaVenta">Date of Invoice: 28/11/2018</div>
			                        <!--<div class="fechaVentaVencimiento">Due Date: 28/11/2018</div>-->
			                    </div>
			                </div>
			                <table id="tablaDetalleVenta" border="0" cellspacing="0" cellpadding="0">
			                    <thead>
			                        <tr>
			                            <th>N°.</th>
			                            <th class="text-left">DESCRIPCIÓN</th>
			                            <th class="text-right">PRECIO</th>
			                            <th class="text-right">IMPUESTO (18%)</th>
			                            <th class="text-right">TOTAL</th>
			                        </tr>
			                    </thead>
			                    <tbody id="bodyDetalleVenta">
			                    	<!--
			                        <tr>
			                            <td class="no">01</td>
			                            <td class="text-left"><h3>Description 1</h3>Testing Description 1</td>
			                            <td class="unit">₹ 0.00</td>
			                            <td class="tax">10%</td>
			                            <td class="total">₹ 0.00</td>
			                        </tr>
			                        <tr>
			                            <td class="no">02</td>
			                            <td class="text-left"><h3>Description 2</h3>Testing Description 2</td>
			                            <td class="unit">₹ 40.00</td>
			                            <td class="tax">13%</td>
			                            <td class="total">₹ 1,200.00</td>
			                        </tr>
			                        -->
			                    </tbody>
			                    <tfoot id="footDetalleVenta">
			                        <tr>
			                            <td colspan="2"></td>
			                            <td colspan="2">SUBTOTAL</td>
			                            <td>S/. 5,200.00</td>
			                        </tr>
			                        <tr>
			                            <td colspan="2"></td>
			                            <td colspan="2">TAX 25%</td>
			                            <td>S/. 1,300.00</td>
			                        </tr>
			                        <tr>
			                            <td colspan="2"></td>
			                            <td colspan="2">GRAND TOTAL</td>
			                            <td>S/. 6,500.00</td>
			                        </tr>
			                    </tfoot>
			                </table>
			                <div class="thanks">Gracias por su preferencia!</div>
			                <div class="notices">
			                    <div>AVISO:</div>
			                    <div class="notice">Documento generado automaticamente por el sistema, Gracias.</div>
			                </div>
			            </main>
			            <footer>
			                Representación real del documento de venta emitido por la empresa, por lo tanto la validez es la misma.
			            </footer>
			            <div class="pageBreak"></div>
			        </div>
			        <div></div>
			    </div>
			</div>

		</div>

		<div class="modal-footer">
      	
      	</div>

	</div>

</div>