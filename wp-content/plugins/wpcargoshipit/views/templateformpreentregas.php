 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="<?= plugin_dir_url(__DIR__ ) ?>/assets/repeater.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="https://bootswatch.com/3/paper/bootstrap.min.css" />
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
		<div class="file-select" id="src-file1" >
			  <input id="filefactura" type="file" name="factura" aria-label="Archivo" accept="image/*,.pdf" required>			  
		</div>
		<span id="archivocargado"></span>
		<!--<input type="file" name="factura" placeholder="Factura o soporte" required>-->
	</div>
	<div class="rowform">		
		<input type="datepicker" name="datepicker" id="datepicker" placeholder="Fecha estimada de ingreso*" required>
		<input type="hidden" name="action" value="registrar_preentrega2">
	</div>
	<div class="rowform">
		<!-- <select name="tipoenvio" id="tipoenvio" required>

			<option value="Tipo de envío" selected="true" disabled>Tipo de envío</option>

		<?php /* $terms = get_terms("wpcargo_shipment_cat", array(
    'hide_empty' => false,
)); 
		
		foreach ($terms as $cat) { */ ?>
			<option value="<?= $cat->term_id ?>"> <?= $cat->name; ?></option>
		<?php 
			/* } */
		 ?>
		</select> -->
		
		


		<p style="font-size: 10px; margin-top: 30px;">Los campos marcados con <span style="color: red;">*</span> son obligatorios</p>
	</div>

<div id="repeater">
                    <!-- Repeater Heading -->
                    <div class="repeater-heading">
                        <h5 class="text-center">Paquetes </h5>
                        <button id="agregar" class="btn btn-primary pt-5 pull-right repeater-add-btn hidden">
                             Agregar otro paquete a la factura
                        </button>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Repeater Items -->
                    <div class="items" data-group="paquetes">
                        <!-- Repeater Content -->
                        <div class="item-content">
                            <div class="form-group">                                
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputdescripcion" placeholder="Descripción del paquete*" data-name="descripcion" required>
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <div class="col-lg-10 tracking">
                                    <input type="text" class="form-control" id="inputtracking" placeholder="No. Tracking" data-name="tracking">
                                </div>
                            </div>

                             <div class="form-group">
                                
                                <div class="col-lg-10">
                                	<select name="carrier" id="carrier" class="carrier" data-name="carrier" required>
                                		<option disabled selected>Courrier</option>                                    	
                                    		<?php $carriers = get_option("carrier_setting");
                                    		$carriers = explode(',', $carriers);
											    
													
													foreach ($carriers as $carrier):   ?>
														<option value="<?= $carrier; ?>"> <?= $carrier; ?></option>
													<?php endforeach; ?>													
                                	</select>
                                </div>
                            </div>                            
                        </div>
                        <!-- Repeater Remove Btn -->
                        <div class="pull-right repeater-remove-btn">
                            <button class="btn btn-danger remove-btn">
                                Quitar
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    
                </div>
                <div class="rowform text-center">	
															<button id="agregar2" class="text-center">
			                             Agregar otro paquete a la factura
			                        </button>
                </div>
	<input class="btnshipit" type="submit" value="ENVIAR" id="btnsubmit">
</form>
<style type="text/css">
	.carrier::placeholder {
		color: #ddd;
	}
	.hidden {
		display: none;
	}
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
		/*content: 'Factura: ' attr(archivocargado);*/
		content: 'Factura cargada, presiona para reemplazar' ;
	}

	#archivocargado {
		color: #4f3356;
	    margin-top: 6px;
	    display: block;
	    text-align: center;
	}
	@media (max-width: 768px) {
		.file-select::before {
			font-size: 12px;
		}
		#agregar2 {
			margin-top: 20px;
		}
	}
</style>

<script type="text/javascript">
	
	$( document ).ready(function() {

 $('.tracking input').on('keydown', function(e) {
    if (e.keyCode === 32) {
      e.preventDefault();
    }
  });
		

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
						            		$("#src-file1").removeClass("archivocargado");
						            		$("#archivocargado").html("");
						            		$(".remove-btn[disabled!='disabled']").click();
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

$(document).on('click','#agregar2', function(event){
	$("#agregar").click();
	 $('.tracking input').on('keydown', function(e) {
    if (e.keyCode === 32) {
      e.preventDefault();
    }
  });
});

});
	
	$('#filefactura').change(function() {	

		var fileName = document.getElementById("filefactura").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile=="pdf"){
            var file = $('#filefactura')[0].files[0].name;
		  	$("#src-file1").addClass("archivocargado");
		  	$("#src-file1").attr("archivocargado",file);  
		  	$("#archivocargado").html(file);
        }else{
            alert("Solo se permiten archivos con formato jpg,png o pdfs!");
            $("#archivocargado").html("");
            $("#filefactura").val("");
        }   

  	
  
});

</script>
<script>
        /* Create Repeater */
        $("#repeater").createRepeater({
            showFirstItemToDefault: true,
        });

       
    </script>