/*=============================================
CAPTURA DE RUTA
=============================================*/

var rutaActual = location.href;

$(".btnIngreso, .facebook, .google").click(function(){

	localStorage.setItem("rutaActual", rutaActual);

})

$(function(){

	var numeroDocumento = $("#editarDocumento").val();

	if (numeroDocumento != "") {

		cambiarEstadoDoc(true);
		activarInputDocumento();

	}

	$("#tipoDocumento").on("change", function(){

		activarInputDocumento();

	});


});

/*=============================================
FORMATEAR LOS IPUNT
=============================================*/

$("input").focus(function(){

	$(".alert").remove();
})

/*=============================================
VALIDAR EMAIL REPETIDO
=============================================*/

var validarEmailRepetido = false;

$("#regEmail").change(function(){

	var email = $("#regEmail").val();

	var datos = new FormData();
	datos.append("validarEmail", email);

	$.ajax({

		url:rutaOculta+"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(respuesta){
			
			if(respuesta == "false"){

				$(".alert").remove();
				validarEmailRepetido = false;

			}else{

				var modo = JSON.parse(respuesta).modo;
				
				if(modo == "directo"){

					modo = "esta página";
				}

				$("#regEmail").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> El correo electrónico ya existe en la base de datos, fue registrado a través de '+modo+', por favor ingrese otro diferente</div>')

					validarEmailRepetido = true;

			}

		}

	})

})

function validateEmail() {
	var email = $("#editarEmail").val();
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	
	if(!re.test(email)){

  		console.log("false");

	}else{

  		console.log("true");

	}
}

function validateEmail2() {
	var email = $("#editarEmail").val();
  var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
  console.log(re.test(email));
}
/*=============================================
VALIDAR EL REGISTRO DE USUARIO
=============================================*/
function registroUsuario(){

	/*=============================================
	VALIDAR EL NOMBRE
	=============================================*/

	var nombre = $("#regUsuario").val();

	if(nombre != ""){

		var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;

		if(!expresion.test(nombre)){

			$("#regUsuario").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten números ni caracteres especiales</div>')

			return false;

		}

	}else{

		$("#regUsuario").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	/*=============================================
	VALIDAR EL EMAIL
	=============================================*/

	var email = $("#regEmail").val();

	if(email != ""){

		var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

		if(!expresion.test(email)){

			$("#regEmail").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Escriba correctamente el correo electrónico</div>')

			return false;

		}

		if(validarEmailRepetido){

			$("#regEmail").parent().before('<div class="alert alert-danger"><strong>ERROR:</strong> El correo electrónico ya existe en la base de datos, por favor ingrese otro diferente</div>')

			return false;

		}

	}else{

		$("#regEmail").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}


	/*=============================================
	VALIDAR CONTRASEÑA
	=============================================*/

	var password = $("#regPassword").val();

	if(password != ""){

		var expresion = /^[a-zA-Z0-9]*$/;

		if(!expresion.test(password)){

			$("#regPassword").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten caracteres especiales</div>')

			return false;

		}

	}else{

		$("#regPassword").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	/*=============================================
	VALIDAR POLÍTICAS DE PRIVACIDAD
	=============================================*/

	var politicas = $("#regPoliticas:checked").val();
	
	if(politicas != "on"){

		$("#regPoliticas").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Debe aceptar nuestras condiciones de uso y políticas de privacidad</div>')

		return false;

	}

	return true;

}

/*=============================================
CAMBIAR FOTO
=============================================*/

$("#btnCambiarFoto").click(function(){

	$("#imgPerfil").toggle();
	$("#subirImagen").toggle();

})

$("#datosImagen").change(function(){

	var imagen = this.files[0];

	/*=============================================
	VALIDAMOS EL FORMATO DE LA IMAGEN
	=============================================*/
	
	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

		$("#datosImagen").val("");

		swal({
		  title: "Error al subir la imagen",
		  text: "¡La imagen debe estar en formato JPG o PNG!",
		  type: "error",
		  confirmButtonText: "¡Cerrar!",
		  closeOnConfirm: false
		},
		function(isConfirm){
				 if (isConfirm) {	   
				    window.location = rutaOculta+"perfil";
				  } 
		});

	}

	else if(Number(imagen["size"]) > 2000000){

		$("#datosImagen").val("");

		swal({
		  title: "Error al subir la imagen",
		  text: "¡La imagen no debe pesar más de 2 MB!",
		  type: "error",
		  confirmButtonText: "¡Cerrar!",
		  closeOnConfirm: false
		},
		function(isConfirm){
				 if (isConfirm) {	   
				    window.location = rutaOculta+"perfil";
				  } 
		});

	}else{

		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function(event){

			var rutaImagen = event.target.result;
			$(".previsualizar").attr("src",  rutaImagen);

		})

	}


})

/*=============================================
COMENTARIOS ID
=============================================*/

$(".calificarProducto").click(function(){

	var idComentario = $(this).attr("idComentario");

	$("#idComentario").val(idComentario);

})

/*=============================================
COMENTARIOS CAMBIO DE ESTRELLAS
=============================================*/

$("input[name='puntaje']").change(function(){

	var puntaje = $(this).val();
	
	switch(puntaje){

		case "0.5":
		$("#estrellas").html('<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "1.0":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "1.5":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "2.0":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "2.5":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "3.0":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "3.5":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "4.0":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "4.5":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i>');
		break;

		case "5.0":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i>');
		break;

	}

})

/*=============================================
VALIDAR EL COMENTARIO
=============================================*/

function validarComentario(){

	var comentario = $("#comentario").val();

	if(comentario != ""){

		var expresion = /^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;

		if(!expresion.test(comentario)){

			$("#comentario").parent().before('<div class="alert alert-danger"><strong>ERROR:</strong> No se permiten caracteres especiales como por ejemplo !$%&/?¡¿[]*</div>');

			return false;

		}

	}else{

		$("#comentario").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Campo obligatorio</div>');

		return false;

	}

	return true;

}

/*=============================================
LISTA DE DESEOS
=============================================*/

$(".deseos").click(function(){

	var idProducto = $(this).attr("idProducto");
	console.log("idProducto", idProducto);

	var idUsuario = localStorage.getItem("usuario");
	console.log("idUsuario", idUsuario);

	if(idUsuario == null){

		swal({
		  title: "Debe ingresar al sistema",
		  text: "¡Para agregar un producto a la 'lista de deseos' debe primero ingresar al sistema!",
		  type: "warning",
		  confirmButtonText: "¡Cerrar!",
		  closeOnConfirm: false
		},
		function(isConfirm){
				 if (isConfirm) {	   
				    window.location = rutaOculta;
				  } 
		});

	}else{

		$(this).addClass("btn-danger");

		var datos = new FormData();
		datos.append("idUsuario", idUsuario);
		datos.append("idProducto", idProducto);

		$.ajax({
			url:rutaOculta+"ajax/usuarios.ajax.php",
			method:"POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success:function(respuesta){
				
							
			}

		})

	}

})

/*=============================================
BORRAR PRODUCTO DE LISTA DE DESEOS
=============================================*/

$(".quitarDeseo").click(function(){

	var idDeseo = $(this).attr("idDeseo");

	$(this).parent().parent().parent().remove();

	var datos = new FormData();
	datos.append("idDeseo", idDeseo);

	$.ajax({
			url:rutaOculta+"ajax/usuarios.ajax.php",
			method:"POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success:function(respuesta){
			
			}

		});


})

/*=============================================
ELIMINAR USUARIO
=============================================*/

$("#eliminarUsuario").click(function(){

	var id = $("#idUsuario").val();

	if($("#modoUsuario").val() == "directo"){

		if($("#fotoUsuario").val() != ""){

			var foto = $("#fotoUsuario").val();

		}

	}

	swal({
		  title: "¿Está usted seguro(a) de eliminar su cuenta?",
		  text: "¡Si borrar esta cuenta ya no se puede recuperar los datos!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "¡Si, borrar cuenta!",
		  closeOnConfirm: false
		},
		function(isConfirm){
				 if (isConfirm) {	   
				    window.location = "index.php?ruta=perfil&id="+id+"&foto="+foto;
				  } 
		});

})


/*=============================================
VALIDACIÓN FORMULARIO CONTACTENOS
=============================================*/		

function validarContactenos(){

	var nombre = $("#nombreContactenos").val();
	var email = $("#emailContactenos").val();
	var mensaje = $("#mensajeContactenos").val();

	/*=============================================
	VALIDACIÓN DEL NOMBRE
	=============================================*/	

	if(nombre == ""){

		$("#nombreContactenos").before('<h6 class="alert alert-danger">Escriba por favor el nombre</h6>');

		return false;
		
	}else{

		var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;	

		if(!expresion.test(nombre)){

			$("#nombreContactenos").before('<h6 class="alert alert-danger">Escriba por favor sólo letras sin caracteres especiales</h6>');

			return false;

		}

	}

	/*=============================================
	VALIDACIÓN DEL EMAIL
	=============================================*/	

	if(email== ""){

		$("#emailContactenos").before('<h6 class="alert alert-danger">Escriba por favor el email</h6>');
		
		return false;

	}else{

		var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

		if(!expresion.test(email)){
			
			$("#emailContactenos").before('<h6 class="alert alert-danger">Escriba por favor correctamente el correo electrónico</h6>');
			
			return false;
		}	

	}

	/*=============================================
	VALIDACIÓN DEL MENSAJE
	=============================================*/	

	if(mensaje == ""){

		$("#mensajeContactenos").before('<h6 class="alert alert-danger">Escriba por favor un mensaje</h6>');
		
		return false;

	}else{

		var expresion = /^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;

		if(!expresion.test(mensaje)){
			
			$("#mensajeContactenos").before('<h6 class="alert alert-danger">Escriba el mensaje sin caracteres especiales</h6>');
			
			return false;
		}	

	}

	return true;
}

$(".domicilio").tagsinput('items');

$(".bootstrap-tagsinput").css({"padding":"11px",
	   						   "width":"100%",
		   						   "border-radius":"1px"})


/*=============================================
	VALIDACION DEL TIPO DE DOCUMENTO
=============================================*/
//$("#editarDocumento").attr("readonly",true);

if ($("#tipoDocumento") != null) {

	$("#editarDocumento").attr("readonly", true);
	$("#validarDocumento").attr("disabled", true);

}	

// ESTABLECEMOS LOS VALORES INCIALES Y CAMBIAMOS
//	EN BASE AL CAMBIO DEL SELECT.
function activarInputDocumento(){

	//$("#tipoDocumento").on("change", function(){

		var tipo = $("#tipoDocumento").val();

		if (tipo == 'dni') {

			console.log(tipo);
			$("#editarDocumento").attr("readonly",false);
			$("#editarDocumento").attr("maxlength",8);
			$("#validarDocumento").attr("disabled", false);


		}else if (tipo == 'ruc'){

			console.log(tipo);
			$("#editarDocumento").attr("readonly",false);
			$("#editarDocumento").attr("maxlength",11);
			$("#validarDocumento").attr("disabled", false);


		}else{

			$("#editarDocumento").attr("readonly",true);
			$("#editarDocumento").attr("value","");
			$("#editarDocumento").attr("maxlength",0);
			$("#validarDocumento").attr("disabled", true);

		}

	//})
}

/*=============================================
	VALIDACION DEL TIPO DE DOCUMENTO
=============================================*/

function validarDocs(){

	var tipo = $("#tipoDocumento").val();
	var valorDocumento = $("#editarDocumento").val();

	if (tipo == 'dni' && valorDocumento.length == 8) {

		consultarReniec(tipo, valorDocumento);

	}else if (tipo == 'ruc' && valorDocumento.length == 11){

		consultarSunat(tipo, valorDocumento);

	}else{

		cambiarEstadoDoc(false);

		if (tipo == null || tipo == ""){
			
			$("#tipoDocumento").focus();

		}else{

			swal({
			  title: "Error al validar su documento",
			  text: "¡Ingrese el numero correcto de acuerdo al tipo de documento!",
			  type: "warning",
			  confirmButtonText: "¡Cerrar!",
			  closeOnConfirm: false
			});
			
			$("#editarDocumento").focus();

		}

	}

}

function cambiarEstadoDoc($valor){
	
	var estadoDoc = $valor;
    
    $("#estadoDoc").attr({
      value: estadoDoc
    });

}

/*=============================================
	CONSULTAR DNI A LA RENIEC
=============================================*/

function consultarReniec($tipo, $documento){

	console.log("consultando a la RENIEC");

	if ($tipo == 'dni' && $documento.length == 8) {

		$.ajax({
	        type: "GET", //GET, POST, PUT
	        url: 'https://apiperu.dev/api/dni/'+$documento,  //the url to call
	        contentType: "application/json",           
	        beforeSend: function (xhr) {   //Set token here
	            xhr.setRequestHeader("Authorization", 'Bearer '+ '8b616a6e9997310fcf5b727d479a30ec3bd33e094041ab4c37fe11460a2aed1b');
	        }
	    })
	     .done(function(json){
	          
	          //console.log(json);
	         //if(json.result.RUC.length != undefined || json.success != false){
	         if(json.success != false){
	            
	            swal({
	              title: "¡Datos encontrados con exito!, puede continuar.",
	              text: "DNI: " + json.data.numero+ "; Nombre: " + json.data.nombre_completo,
	              type: "success",
	              confirmButtonText: "¡Ok!"
	            });
	            
	            cambiarEstadoDoc(true);
	            $("#editarCiudad").focus();

	         }else{

	         	cambiarEstadoDoc(false);
	            var mensajeSunat = "Documento no existe en RENIEC";
	            mensajeErrorSwal(mensajeSunat);

	         }
	    });
	     /*
		cambiarEstadoDoc(true);
		
		swal({
			  title: "¡Documento validado!",
			  text: "Puede continuar llenando el formulario, gracias.",
			  type: "success",
			  confirmButtonText: "OK!",
			  closeOnConfirm: false
			});
			*/
		

	}else{

		cambiarEstadoDoc(false);

		swal({
			  title: "¡DNI incorrecto!",
			  text: "Ingrese el numero de DNI correcto, un total de 8 digitos, por favor.",
			  type: "error",
			  confirmButtonText: "¡Cerrar!",
			  closeOnConfirm: false
			});
			
		$("#editarDocumento").focus();

	}

};

/*=============================================
	CONSULTAR RUC A LA SUNAT
=============================================*/

function consultarSunat($tipo, $valorDocumento){

	console.log("consultando a la SUNAT");
		
	if ($tipo == 'ruc' && $valorDocumento.length == 11) {

		//$.getJSON("https://apis.sitefact.pe/api/ConsultaRuc",{ruc:$valorDocumento})
		$.ajax({
	        type: "GET", //GET, POST, PUT
	        url: 'https://apiperu.dev/api/ruc/'+$valorDocumento,  //the url to call
	        contentType: "application/json",           
	        beforeSend: function (xhr) {   //Set token here
	            xhr.setRequestHeader("Authorization", 'Bearer '+ '8b616a6e9997310fcf5b727d479a30ec3bd33e094041ab4c37fe11460a2aed1b');
	        }
	    })
	     .done(function(json){
	          
	          //console.log(json);
	         //if(json.result.RUC.length != undefined || json.success != false){
	         if(json.success != false){
	            
	            //$('input[name="nuevoDocumentoId"]').val(json.result.RUC);
	            //$('input[name="nuevaDireccion"]').val(json.result.DireccionFiscal);
	            //$('input[name="nuevaRazon"]').val(json.result.RazonSocial);
	            
	            swal({
	              title: "¡Datos encontrados con exito!",
	              text: "RUC: " + $valorDocumento + "; Razon Social: " + json.data.nombre_o_razon_social,
	              type: "success",
	              confirmButtonText: "¡Ok!"
	            });
	            
	            cambiarEstadoDoc(true);

	         }else{

	            cambiarEstadoDoc(false);

	            var mensajeSunat = "Documento no existe en SUNAT";
	            mensajeErrorSwal(mensajeSunat);

	         }
	     });

	 }else{

	 	cambiarEstadoDoc(false);

	 	swal({
			  title: "RUC incorrecto!",
			  text: "Ingrese el numero del RUC correcto, un total de 11 digitos, por favor.",
			  type: "error",
			  confirmButtonText: "¡Cerrar!",
			  closeOnConfirm: false
			});
			
		$("#editarDocumento").focus();

	 }

};

/*=============================================
// MENSAJE PERSONZALIDO DE ERROR EN EL ENVIO DEL RUC A SUNAT
=============================================*/	
function mensajeErrorSwal($mensaje){

  if ($mensaje != "") {

    swal({
      title: $mensaje,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      type: "warning",
      confirmButtonText: "¡Ok!"
    });

  }else{

    swal({
      title: "Ingrese un número de documento",
      type: "error",
      confirmButtonText: "¡Cerrar!"
    });

  }

  //$('input[name="nuevaDireccion"]').val("");
  //$('input[name="nuevaRazon"]').val("");

}

/*=============================================
	VALIDAMOS LOS CAMPOS QUE SE ACTUALIZARAN 
	CON EXPRESIONES REGULARES
=============================================*/

function actualzarUsuario(){


	/*=============================================
	VALIDAR EL NOMBRE
	=============================================*/

	var nombre = $("#editarNombre").val();

	if(nombre != ""){

		var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;

		if(!expresion.test(nombre)){

			$("#editarNombre").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten números ni caracteres especiales</div>')

			return false;

		}

	}else{

		$("#editarNombre").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	/*=============================================
	VALIDAR EL EMAIL
	=============================================*/

	var email = $("#editarEmail").val();

	if(email != ""){

		var expresion = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

		if(!expresion.test(email)){

			$("#editarEmail").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Escriba correctamente el correo electrónico</div>')

			return false;

		}

		if(validarEmailRepetido){

			$("#editarEmail").parent().before('<div class="alert alert-danger"><strong>ERROR:</strong> El correo electrónico ya existe en la base de datos, por favor ingrese otro diferente</div>')

			return false;

		}

	}else{

		$("#editarEmail").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}


	/*=============================================
	VALIDAR CONTRASEÑA
	=============================================*/

	var password = $("#editarPassword").val();

	if(password != ""){

		var expresion = /^[a-zA-Z0-9]*$/;

		if(!expresion.test(password)){

			$("#editarPassword").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten caracteres especiales</div>')

			return false;

		}

	}

	/*=============================================
	VALIDAR DOCUMENTO
	=============================================*/

	var documento = $("#editarDocumento").val();

	if(documento != ""){

		var expresion = /^[0-9]*$/;

		if(!expresion.test(documento)){

			$("#editarDocumento").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten caracteres especiales</div>')

			return false;

		}

	}else{

		$("#editarDocumento").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	/*=============================================
	VALIDAR LA CIUDAD
	=============================================*/

	var ciudad = $("#editarCiudad").val();

	if(ciudad != ""){

		var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;

		if(!expresion.test(ciudad)){

			$("#editarCiudad").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten números ni caracteres especiales</div>')

			return false;

		}

	}else{

		$("#editarCiudad").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}//!filter_var($_POST["editarEmail"], FILTER_VALIDATE_EMAIL) &&

	/*=============================================
	VALIDAR LA REGIÓN
	=============================================*/

	var region = $("#editarRegion").val();

	if(region != ""){

		var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;

		if(!expresion.test(region)){

			$("#editarRegion").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten números ni caracteres especiales</div>')

			return false;

		}

	}else{

		$("#editarRegion").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}


	/*=============================================
	VALIDAR EL CÓDIGO POSTAL
	=============================================*/

	var codigoPostal = $("#editarCodigoPostal").val();

	if(codigoPostal != ""){

		var expresion = /^[0-9]*$/;

		if(!expresion.test(codigoPostal)){

			$("#editarCodigoPostal").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten letras ni caracteres especiales</div>')

			return false;

		}

	}else{

		$("#editarCodigoPostal").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	/*=============================================
	VALIDAR LA DIRECCIÓN
	=============================================*/

	var direccion = $("#editarDireccion").val();

	if(direccion != ""){

		var expresion = /^[#.0-9a-zA-Z\s,-]+$/i;

		if(!expresion.test(direccion)){

			$("#editarDireccion").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Dirección: No se permiten caracteres especiales</div>')

			return false;

		}

	}else{

		$("#editarDireccion").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	/*=============================================
	VALIDAR EL TELEFONO
	=============================================*/

	var telefono = $("#editarTelefono").val();

	if(telefono != ""){

		var expresion = /^[0-9- ]*$/;

		if(!expresion.test(telefono)){

			$("#editarTelefono").parent().parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Telefono: No se permiten letras ni caracteres especiales</div>')

			return false;

		}

	}else{

		$("#editarTelefono").parent().parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	return true;

}

//	AUTOR: https://bootsnipp.com/snippets/8MPnQ
/*=============================================
	IMPRIMIR EL DOCUMENTO DE VENTA.
=============================================*/
 $('#printInvoice').click(function(){

    window.print();
	/*Popup($('.invoice')[0].outerHTML);
	    function Popup(data) 
	    {
	        window.print();
	        return true;
	    }
	*/

});

function generarPDF(){

	var numeroVenta = $(".numeroVenta").html();
	var $nombre = numeroVenta.replace(/ /gi,'-');

	//html2canvas(document.body,{
	html2canvas($('#imprimirDocumento'),{
	onrendered:function(canvas){

		var img=canvas.toDataURL("image/png");
		var doc = new jsPDF();
		doc.addImage(img,'JPEG',20,20,170,250);
		doc.save($nombre+'.pdf');

		}

	});

}

function PrintThisDiv() {

	var HTMLContent = document.getElementById("imprimirDocumento");
	var Popup = window.open('about:blank', "imprimirDocumento", 'width=500,height=500');

	Popup.document.writeln('<html><head>');
	Popup.document.writeln('<style type="text/css">');
	Popup.document.writeln('body{font-family: Trebuchet MS;}');
	Popup.document.writeln('.no-print{display: none;}');
	Popup.document.writeln('</style>');
	Popup.document.writeln('</head><body>');
	Popup.document.writeln('<a href="javascript:;" onclick="window.print();">Imprimir</a>');
	Popup.document.writeln(HTMLContent.innerHTML);
	Popup.document.writeln('</body></html>');
	Popup.document.close();
	Popup.focus();

}

/*=============================================
	FUNCION PARA MOSTRAR EL MODAL CON LOS VALORES
	DEL DETALLE DE VENTA SOLICITADO.
=============================================*/
var jsonRes = "";

function limpiarModalVenta(){

	$("#footDetalleVenta tr").remove();
	$('.numeroVenta').html("");
	$('.fechaVenta').html("");
	$("#bodyDetalleVenta tr").remove();

}

function verDetalleVenta($id_venta){
	
	console.log($id_venta);
	
	limpiarModalVenta();
	agregarDetalleVenta($id_venta);


	var item = "id";

	var datos = new FormData();
	datos.append('id_venta', $id_venta);
	datos.append('item_venta', item);

	$.ajax({

		url:rutaOculta+"ajax/carrito.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(respuesta){
			
			var jsonVenta = JSON.parse(respuesta);
			console.log(respuesta);
			if(respuesta){
				
				if (jsonVenta["serie"] != null && jsonVenta["numero"]) {
					var tipoDoc = jsonVenta["tipo_documento"]=="B"?"Boleta":"Factura";
					
					$('.numeroVenta').append(tipoDoc +
						" " + jsonVenta["serie"] +' ' + jsonVenta["numero"]);

					$('.fechaVenta').append("Fecha de emisión: " + jsonVenta["fecha_emision"].substring(0,10));					

				}else{

					$('.numeroVenta').append("");
					$('.fechaVenta').append("");

				}
				console.log(jsonVenta["sub_total"]);
				if (jsonVenta["sub_total"] != null) {

					$('#footDetalleVenta').append('<tr><td colspan="2"></td><td colspan="2">SUBTOTAL</td>'+
						"<td>S/. " + jsonVenta["sub_total"] +'</td></tr>');

				}else{

					$('#footDetalleVenta').append('<tr><td colspan="2"></td><td colspan="2">SUBTOTAL</td>'+
						'<td>S/. 0.00</td></tr>');

				}

				if (jsonVenta["igv"] != null) {

					$('#footDetalleVenta').append('<tr><td colspan="2"></td><td colspan="2">IGV</td>'+
						"<td>S/. " + jsonVenta["igv"] +'</td></tr>');

				}else{

					$('#footDetalleVenta').append('<tr><td colspan="2"></td><td colspan="2">IGV</td>'+
						'<td>S/. 0.00</td></tr>');

				}

				if (jsonVenta["total"] != null) {

					$('#footDetalleVenta').append('<tr><td colspan="2"></td><td colspan="2">TOTAL</td>'+
						"<td>S/. " + jsonVenta["total"] +'</td></tr>');

				}else{

					$('#footDetalleVenta').append('<tr><td colspan="2"></td><td colspan="2">TOTAL</td>'+
						'<td>S/. 0.00</td></tr>');

				}
				
				console.log("detalles");
				//console.log(jsonVenta["total"]);
				//console.log("Cliente id: " + jsonVenta["id_cliente"]);

			}else{

				//var modo = JSON.parse(respuesta).modo;
				console.log("Sin detalles");

			}

		}

	});


	$("#modalDetalleVenta").modal("show");



}

/*=============================================
	TRAEMOS LOS DETALLES REALACIONES A LA VENTA,
	LUEGO CON UN BUCLE, CAPTURAMOS LOS VALORES Y ENVIAMOS
	AL METODO: TRAERPRODUCTO(); UNO A LA VEZ.
=============================================*/
function agregarDetalleVenta($id_venta){
	var res = "";
	var item = "id_venta";

	var datos = new FormData();
	datos.append('idVenta', $id_venta);
	datos.append('item_venta', item);
	
	$.ajax({

		url:rutaOculta+"ajax/carrito.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(respuesta){

			var jsonDetalle = JSON.parse(respuesta);

			for (var i = 0; i < jsonDetalle.length; i++) {
				var id = jsonDetalle[i]["id_producto"];
				var cantidad = jsonDetalle[i]["cantidad"];
				var subTotal = (Math.round((jsonDetalle[i]["pago"]/1.18) * 100) / 100).toFixed(2);
				var igv = (Math.round((jsonDetalle[i]["pago"]*0.18) * 100) / 100).toFixed(2);
				var total = jsonDetalle[i]["pago"];
				traerProducto(i, id, cantidad, subTotal, igv, total);

			}

		}

	});

}
//var res = "";

/*=============================================
	TRAEMOS LOS PRODUCTOS SOLICITADOS EN LOS DETALLES,
	DE ESTA MANERA OBTENEMO EL NOMBRE DEL PRODUCTO CORRESPONDIENTE.
=============================================*/
function traerProducto($iterador, $id_producto, $cantidad, $subTotal, $igv, $total){
	var datos = new FormData();
	datos.append('id', $id_producto);
	$.ajax({

		url:rutaOculta+"ajax/producto.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(respuesta){

			var jsonproducto = JSON.parse(respuesta);
			var tituloProducto = jsonproducto["titulo"];
			agregarItemDetalle(tituloProducto, $iterador+1, $cantidad, $subTotal, $igv, $total)
			
		}

	});

}

/*=============================================
	CAPTURAMOS TODOS LOS VALORES PARA MOSTRAR LOS DETALLES
	EN EL MODAL DE LA VENTA.
=============================================*/
function agregarItemDetalle($tituloProducto, $iterador, $cantidad, $subTotal, $igv, $total){

	$("#bodyDetalleVenta").append(`
		<tr>
			<td class="no">`+ $iterador +`</td>
            <td class="text-left">
            	<h3>Description `+ $iterador +`</h3>
            	`+ $tituloProducto +`
            	<br>
            	<h3>CANTIDAD: `+ $cantidad +`</h3>
            	</td>
            <td class="unit">S/. `+ $subTotal +`</td>
            <td class="tax">S/. `+ $igv +`</td>
            <td class="total">S/. `+ $total +`</td>
		</tr>
	`);

}


