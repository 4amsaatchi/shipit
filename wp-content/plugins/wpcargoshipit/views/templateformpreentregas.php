 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
</script>

<form id="formpreentregas" action="" method="post" enctype="multipart/form-data">
	<div class="rowform">
		<input type="text" name="tienda" placeholder="Tienda" required>
	</div>
	<div class="rowform">
		<input type="text" name="nombre" placeholder="Nombre paquete" required>
	</div>
	<div class="rowform">
		<input type="text" name="trackingid" placeholder="Tracking id" required>
	</div>
	<div class="rowform">
		<label> Factura - Soporte </label>
		<input type="file" name="factura" placeholder="Factura o soporte" required>
	</div>
	<div class="rowform">		
		<input type="datepicker" name="datepicker" id="datepicker" placeholder="Fecha estimada de ingreso" required>
		<input type="hidden" name="action" value="registrar_preentrega">
		

	</div>

	<input type="submit" value="Agregar" id="btnsubmit">
</form>
<style type="text/css">
	.rowform {
		margin-bottom: 15px;
	}

	label, input {
		width: 100%;
	}

	#btnsubmit{
		display: block;
		margin: 0px auto;
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
						            		console.log(data);
						            		alert("PREENTREGA REGISTRADA");
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
	
</script>