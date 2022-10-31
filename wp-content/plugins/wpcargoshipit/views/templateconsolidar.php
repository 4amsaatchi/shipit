<?php 
	$orders = getorderuser();	
?>
<div id="shipment-list">
	<table class="table wpcargo-table-responsive-md wpcargo-table">
        <thead>
            <tr>
                <th>No. seguimiento :</th>
				<th>Ver más</th>
			</tr>
		</thead>
		<tbody>
	

		<?php if ( $orders->have_posts() ) : while ( $orders->have_posts() ) : $orders->the_post(); ?>

	
			
						<tr>
						 	<td><?= get_the_title(); ?></td>															
							<td><a class="view-shipment" href="#" data-id="<?= get_the_ID(); ?>">Ver detalles</a></td>								
						 </tr>
			

		<?php	endwhile; endif;
			wp_reset_query();?>
		</tbody>		
	</table>		
</div>

    



<div id="view-shipment-modalcustom" class="wpcargo-modal">
			
			<div class="modal-content">
				<div class="modal-header">
					<span class="close">×</span>
				</div>
				<div class="modal-body">	
					<div id="wpc-multiple-package" class="print-section wpcargo-table-responsive table-responsive">
					   <p class="header-title"><strong>Paquetes</strong></p>
					   <table class="table wpcargo-table" style="width:100%;">
					      <thead>
					         <tr>
					            <th>Cant.</th>
					            <th>Tipo de pieza</th>
					            <th>Descripción</th>
					            <th>Peso (lbs)</th>
					            <th>Imagen paquete</th>
					            <th>Tienda</th>
					            <th>Tracking</th>					            
					         </tr>
					      </thead>
					      <tbody>					       
					      </tbody>
					   </table>
					</div>
					<a id="btnconsolidar">Consolidar Pedido</a>
				</div> <!-- End modal body -->
			</div>
</div>

<style type="text/css">
	
	.wpcargo-modal {
		display: none;
	}

	#btnconsolidar {
	    margin: 0px auto;
	    /* display: table-caption; */
	    background: #000000;
	    width: fit-content;
	    display: block;
	    text-align: center;
	    color: #FFF;
	    padding: 5px 12px;
	    border-radius: 20px;
	    cursor: pointer;
	}

	.colimagepa {
		text-align: center;
	}
</style>

<script type="text/javascript">
	
	$( document ).ready(function() {

		var url = "<?= admin_url( 'admin-ajax.php' ); ?>";
        var nonce = "<?= wp_create_nonce( 'my-ajax-nonce' ); ?>";
        


	    $(".view-shipment").on('click',function(event) {
	    	var idorder = $(this).attr("data-id");
	    	console.log(idorder);
	    	event.preventDefault();

	    	jQuery.ajax({
            type: "post",
            url: url,
            data: "action=loadorder&nonce=" + nonce +"&idorder="+idorder,
            success: function(result){            		
            		$("#btnconsolidar").attr("data-id",idorder);
	                $("#view-shipment-modalcustom .wpcargo-table tbody").html(result);
	            }
	        });
	    	$("#view-shipment-modalcustom").show();	    	

	    });

	        $("#btnconsolidar").on('click',function(event) {
	        	alert("CONSOLIDAR");
	    	var idorder = $(this).attr("data-id");
	    	console.log(idorder);
	    	event.preventDefault();

	    	jQuery.ajax({
            type: "post",
            dataType: 'json',
            url: url,
            data: "action=consolidarpedido&nonce=" + nonce +"&idorder="+idorder,
            success: function(result){            		
            	
            	console.log(result.result);
            		if (result.result == 1){
            			alert("ENVIO CONSOLIDADO");
            			location.reload();

            		}else {
            			alert("ERROR");
            		}
	            },
	          error: function (error) {
		        console.log(error);
		        
		      }

	        });
	    		    	

	    	});
	});
	
</script>