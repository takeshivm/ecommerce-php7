<?php

    $url = Ruta::ctrRuta();


	/*=============================================
	DIVISA DEL COMERCIO
	=============================================*/

	$comercio = "comercio";
	$infoComercio = ControladorPlantilla::ctrTraerDivisa($comercio);
	$divisa = $infoComercio["divisa"];
	$signo = "";

	if ($divisa == "PEN") {
		
		$signo = "S/.";  

	}
	else if ($divisa == "USD"){

		$signo = "$";

	}
	else if ($divisa == "EUR"){
		// € = ALT + 0128 
		$signo = "€";  
		
	}

 ?>

<!--=====================================
BREADCRUMB CARRITO DE COMPRAS
======================================-->

<div class="container-fluid well well-sm">
	
	<div class="container">
		
		<div class="row">
			
			<ul class="breadcrumb fondoBreadcrumb text-uppercase">
				
				<li><a href="<?php echo $url;  ?>">CARRITO DE COMPRAS</a></li>
				<li class="active pagActiva"><?php echo $rutas[0] ?></li>

			</ul>

		</div>

	</div>

</div>

<!--=====================================
TABLA CARRITO DE COMPRAS
======================================-->

<div class="container-fluid">

	<div class="container">

		<div class="panel panel-default">
			
			<!--=====================================
			CABECERA CARRITO DE COMPRAS
			======================================-->

			<div class="panel-heading cabeceraCarrito">
				
				<div class="col-md-6 col-sm-7 col-xs-12 text-center">
					
					<h3>
						<small>PRODUCTO</small>
					</h3>

				</div>

				<div class="col-md-2 col-sm-1 col-xs-0 text-center">
					
					<h3>
						<small>PRECIO</small>
					</h3>

				</div>

				<div class="col-sm-2 col-xs-0 text-center">
					
					<h3>
						<small>CANTIDAD</small>
					</h3>

				</div>

				<div class="col-sm-2 col-xs-0 text-center">
					
					<h3>
						<small>SUBTOTAL</small>
					</h3>

				</div>

			</div>

			<!--=====================================
			CUERPO CARRITO DE COMPRAS
			======================================-->

			<div class="panel-body cuerpoCarrito">

				

			</div>

			<!--=====================================
			SUMA DEL TOTAL DE PRODUCTOS
			======================================-->

			<div class="panel-body sumaCarrito">

				<div class="col-md-4 col-sm-6 col-xs-12 pull-right well">
					
					<div class="col-xs-6">
						
						<h4>TOTAL:</h4>

					</div>

					<div class="col-xs-6">

						<h4 class="sumaSubTotal">
							
							

						</h4>

					</div> 

				</div>

			</div>

			<!--=====================================
			BOTÓN CHECKOUT
			======================================-->

			<div class="panel-heading cabeceraCheckout">

			<?php

				if(isset($_SESSION["validarSesion"])){

					if($_SESSION["validarSesion"] == "ok"){

						if (isset($_SESSION["domicilio"]) && $_SESSION["domicilio"] != "") {
							
							echo '<a id="btnCheckout" href="#modalCheckout" data-toggle="modal" idUsuario="'.$_SESSION["id"].'"><button class="btn btn-default backColor btn-lg pull-right">REALIZAR PAGO</button></a>';

						}else{

							echo '<a id="btnDireccion" href="#modalDireccion" data-toggle="modal" idUsuario="'.$_SESSION["id"].'"><button class="btn btn-default backColor btn-lg pull-right verificarDomicilio">REALIZAR PAGO</button></a>';

						}


					}


				}else{

					echo '<a href="#modalIngreso" data-toggle="modal"><button class="btn btn-default backColor btn-lg pull-right">REALIZAR PAGO</button></a>';
				}

			?>	

			</div>

		</div>

	</div>

</div>

<!--=====================================
VENTANA MODAL PARA CHECKOUT
======================================-->

<div id="modalCheckout" class="modal fade modalFormulario" role="dialog">
	
	 <div class="modal-content modal-dialog">
	 	
		<div class="modal-body modalTitulo">
			
			<h3 class="backColor">REALIZAR PAGO</h3>

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<div class="contenidoCheckout">

				<?php

				$respuesta = ControladorCarrito::ctrMostrarTarifas();

				echo '<input type="hidden" id="tasaImpuesto" value="'.$respuesta["impuesto"].'">
					  <input type="hidden" id="envioNacional" value="'.$respuesta["envioNacional"].'">
				      <input type="hidden" id="envioInternacional" value="'.$respuesta["envioInternacional"].'">
				      <input type="hidden" id="tasaMinimaNal" value="'.$respuesta["tasaMinimaNal"].'">
				      <input type="hidden" id="tasaMinimaInt" value="'.$respuesta["tasaMinimaInt"].'">
				      <input type="hidden" id="tasaPais" value="'.$respuesta["pais"].'">

				';

				?>
				
				<div class="formEnvio row">
					
					<h4 class="text-center well text-muted text-uppercase">Información de envío</h4>

					<div class="col-xs-12 seleccionePais">
						
						

					</div>

				</div>

				<br>

				<div class="formaPago row">
					
					<h4 class="text-center well text-muted text-uppercase">Elige la forma de pago</h4>

					<figure class="col-xs-4">
						
						<center>
							
							<input id="checkPaypal" type="radio" name="pago" value="paypal">

						</center>	
						
						<img src="<?php echo $url; ?>vistas/img/plantilla/paypal.jpg" class="img-thumbnail">		

					</figure>
					<!-- 	Payu desactivado por correciones de los terminos de contrato    -->
					<figure class="col-xs-4" >
						
						<center>
							
							<input id="checkPayu" type="radio" name="pago" value="payu" style="display: none;">

						</center>

						<img src="<?php echo $url; ?>vistas/img/plantilla/payu.jpg" class="img-thumbnail" style="display: none;">

					</figure>


					<figure class="col-xs-4">
						
						<center>
							
							<input id="checkCulqi" type="radio" name="pago" value="culqi" checked>

						</center>

						<img src="<?php echo $url; ?>vistas/img/plantilla/culqi2.png" class="img-thumbnail" style="height: 80px">

					</figure>

				</div>

				<br>

				<div class="listaProductos row">
					
					<h4 class="text-center well text-muted text-uppercase">Productos a comprar</h4>

					<table class="table table-striped tablaProductos">
						
						 <thead>
						 	
							<tr>		
								<th>Producto</th>
								<th>Cantidad</th>
								<th>Precio</th>
							</tr>

						 </thead>

						 <tbody>
						 	


						 </tbody>

					</table>

					<div class="col-sm-6 col-xs-12 pull-right">
						
						<table class="table table-striped tablaTasas">
							
							<tbody>
								
								<tr>
									<td>Subtotal</td>	
									<td><span class="cambioDivisa"><?php echo $divisa?></span> $<span class="valorSubtotal" valor="0">0</span></td>	
								</tr>

								<tr>
									<td>Envío</td>	
									<td><span class="cambioDivisa"><?php echo $divisa?></span> $<span class="valorTotalEnvio" valor="0">0</span></td>	
								</tr>

								<tr>
									<td>Impuesto</td>	
									<td><span class="cambioDivisa"><?php echo $divisa?></span> $<span class="valorTotalImpuesto" valor="0">0</span></td>	
								</tr>

								<tr>
									<td><strong>Total</strong></td>	
									<td><strong><span class="cambioDivisa"><?php echo $divisa?></span> $<span class="valorTotalCompra" valor="0">0</span></strong></td>	
								</tr>

							</tbody>	

						</table>

						 <div class="divisa">

						 	<select class="form-control" id="cambiarDivisa" name="divisa">
						 		
							

						 	</select>	

						 	<br>

						 </div>

					</div>

					<div class="clearfix"></div>

					<form class="formPayu" style="display:none">
					 
						<input name="merchantId" type="hidden" value=""/>
						<input name="accountId" type="hidden" value=""/>
						<input name="description" type="hidden" value=""/>
						<input name="referenceCode" type="hidden" value=""/>	
						<input name="amount" type="hidden" value=""/>
						<input name="tax" type="hidden" value=""/>
						<input name="taxReturnBase" type="hidden" value=""/>
						<input name="shipmentValue" type="hidden" value=""/>
						<input name="currency" type="hidden" value=""/>
						<input name="lng" type="hidden" value="es"/>
						<input name="confirmationUrl" type="hidden" value="" />
						<input name="responseUrl" type="hidden" value=""/>
						<input name="declinedResponseUrl" type="hidden" value=""/>
						<input name="displayShippingInformation" type="hidden" value=""/>
						<input name="test" type="hidden" value="" />
						<input name="signature" type="hidden" value=""/>

					  <input name="Submit" class="btn btn-block btn-lg btn-default backColor" type="submit"  value="PAGAR" >
					</form>
					
					<button style="display: none;" class="btn btn-block btn-lg btn-default backColor btnPagar">PAGAR</button>

					<button class="btn btn-block btn-lg btn-default backColor btnPagarCulqi">PAGAR CON TARJETA</button>

				</div>

			</div>

		</div>

		<div class="modal-footer">
      	
      	</div>

	</div>

</div>

<!--=====================================
VENTANA MODAL PARA ACTUALIZAR DIRECCIÓN
======================================-->

<div class="modal fade modalDireccion" id="modalDireccion" role="dialog">
  
	<div class="modal-content modal-dialog">
		 	
			<div class="modal-body modalTitulo">
				
				<button type="button" class="close" data-dismiss="modal" style="padding: 10px 12px 0 10px">&times;</button>

							
				<h3 class="backColor">ACTUALIZAR DIRECCIÓN</h3>

				<div class="contenidoDireccion">

					<br>

					<div class="form-group">
		            
			            <!--=====================================
			            AGREGAR PRECIO, PESO Y ENTREGA
			            ======================================-->

			            <div class="form-group row">
			               
			              <!-- DEPARTAMENTO -->

			              <div class="col-md-4 col-xs-12">
			  
			                <div class="panel">CIUDAD</div>
			                
			                <div class="input-group">
			                
			                  <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span> 

			                  <input type="text" class="form-control input-lg textCiudad" maxlength="50" required>

			                </div>

			              </div>

			              <!-- PROVINCIA -->

			              <div class="col-md-4 col-xs-12">
			  
			                <div class="panel">Estado/Provincia/Región</div>
			              
			                <div class="input-group">
			              
			                  <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span> 

			                  <input type="text" class="form-control input-lg textRegion" maxlength="50" required>

			                </div>

			              </div>

			              <!-- DISTRITO -->

			              <div class="col-md-4 col-xs-12">
			  
			                <div class="panel">CÓDIGO POSTAL</div>
			              
			                <div class="input-group">
			              
			                  <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span> 

			                  <input type="number" class="form-control input-lg codigoPostal" min="0" step="any" value="0" required>

			                </div>

			              </div>

			            </div>
              
		                <div class="input-group">
		              
		                  <span class="input-group-addon"><i class="fa fa-truck"></i></span> 

		                  <input type="text" class="form-control input-lg textDireccion"  placeholder="Ingrese su domicilio: Calle/Psj #numero - URB">

		                </div>
		                <br>

						<div class="input-group">
		              
		                  <span class="input-group-addon"><i class="fa fa-phone-square"></i></span> 

		                  <input type="text" class="form-control input-lg textTelefono"  placeholder="Ingrese su numero de celular">

		                </div>

				</div>

			</div>

			<div class="modal-footer">
          	
          		<button type="button" class="btn btn-primary guardarDireccion">Guardar Informacion</button>
	      		
	      	</div>

		</div>
  
</div>