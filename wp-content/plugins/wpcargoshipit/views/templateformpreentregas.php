 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
</script>
<div class="cimagtra">
				<img src="<?= get_stylesheet_directory_uri() ?>/assets/images/logo-ship-it.png" alt="Logo shipit" id="logoshipit">
</div>

<form id="formpreentregas" action="" method="post" enctype="multipart/form-data">
	<div class="rowform">
		<input type="text" name="tienda" placeholder="Tienda*" required>
	</div>
	<div class="rowform">
		<input type="text" name="nombre" placeholder="Descripción paquete*" required>
	</div>
	<div class="rowform">
		<input type="text" name="trackingid" placeholder="No. Tracking*" required>
	</div>
	<div class="rowform">		
		<div class="file-select" id="src-file1" >
			  <input id="filefactura" type="file" name="factura" aria-label="Archivo" required>
		</div>
		<!--<input type="file" name="factura" placeholder="Factura o soporte" required>-->
	</div>
	<div class="rowform">		
		<input type="datepicker" name="datepicker" id="datepicker" placeholder="Fecha estimada de ingreso*" required>
		<input type="hidden" name="action" value="registrar_preentrega">
		
		<p style="font-size: 10px; margin-top: 30px;">Los campos marcados con <span style="color: red;">*</span> son obligatorios</p>
	</div>

	<input class="btnshipit" type="submit" value="ENVIAR" id="btnsubmit">
</form>
<style type="text/css">

	.file-select {
  position: relative;
  display: inline-block;
  cursor: pointer;
  background: #f43c5c;
  width: 100%;
  border-radius: 20px;
}

.file-select::before {
  background-color: #f43c5c;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 20px;
  content: 'Seleccionar'; /* testo por defecto */
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

.file-select input[type="file"] {
  opacity: 0;
  width: 100%;
  height: 32px;
  display: inline-block;
  cursor: pointer;
}

#src-file1::before {
  content: 'ADJUNTAR FACTURA PDF PNG O JPG *';
}

	.rowform {
		margin-bottom: 15px;
	}

	label, input {
		width: 100%;
	}

	#btnsubmit{		
		display: block;
		margin: 90px auto -10px;
	}

	#formpreentregas {
		margin-top: 20px;
	}

	#src-file1.archivocargado, #src-file1.archivocargado::before{
		background: #4F3356;
	}

	#src-file1.archivocargado::before{
		content: 'Factura: ' attr(archivocargado);
	}
</style>

<script type="text/javascript">
	
	$( document ).ready(function() {

		

		var url = "<?= admin_url( 'admin-ajax.php' ); ?>";
    var nonce = "<?= wp_create_nonce( 'my-ajax-nonce' ); ?>";
        

    
				    $( "#formpreentregas" ).submit(function(event) {

				    	event.preventDefault();

				    	var a = $("#formpreentregas").validate();
				    	

				    	if ($("#formpreentregas").valid()) {
							    var form = $('#formpreentregas')[0];

						    	var data = new FormData(form);

							   $.ajax({
						            type: "POST",
						            enctype: 'multipart/form-data',            
						            data: data,
						            url: url,
						            processData: false,
						            contentType: false,
						            cache: false,
						            timeout: 600000,
						            success: function (data) {

						            	if (data.result != -1){						            		
						            		elementorProFrontend.modules.popup.showPopup( { id: 2153 } );
						            		form.reset();
						            	} else {
						            		alert("ERROR INTENTE NUEVAMENTE");
						            	}
						                

						            },
						            error: function (e) {
						            	console.log(e.responseText);
						                
						                console.log("ERROR : ", e);
						                

						            }
						        });
							 }
				    });
	  

	       
	});
	
	jQuery(function($){
$(document).on('click','.elementor-location-popup a', function(event){
elementorProFrontend.modules.popup.closePopup( {}, event);
});
});
	/*
	$('#filefactura').change(function() {	
  	var file = $('#filefactura')[0].files[0].name;
  	$("#src-file1").addClass("archivocargado");
  	$("#src-file1").attr("archivocargado",file);  
  
});*/

</script>