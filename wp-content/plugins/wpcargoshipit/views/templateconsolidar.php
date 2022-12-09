<?php 
	$orders = getorderuser();	
?>
<div id="shipment-list">
	<div class="tablaenvios">
		<div class="cabecera rowenvios">
			   <div>No. seguimiento</div>
			   <div>Detalles</div>
		</div>
       
		
	

		<?php if ( $orders->have_posts() ) : while ( $orders->have_posts() ) : $orders->the_post(); ?>

	
			
						<div class="rowenvios">
						 	<div><?= get_the_title(); ?></div>															
							<div class="containerbotones">
								<a class="verdetalles" href="<?= site_url()."/envio?idenvio=".get_the_ID() ?>" data-id="<?= get_the_ID(); ?>">Ver detalles</a>
								<?php if (get_post_meta(get_the_ID(), 'wpcargo_status', true) == get_estadoparaconsolidar()): ?>
									<a href="" class="btnshipit btnconsolidar" data-id="<?= get_the_ID(); ?>">CONSOLIDAR</a>
								<?php else: ?>
									<span class="consolidado">CONSOLIDADO</span>
								<?php endif; ?>								 
							</div>								
						 </div>
			

		<?php	endwhile; endif;
			wp_reset_query();?>
			
	</div>	
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

	.btnconsolidar{ 
		color: #FFF !important;
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
        

/*
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

	    });*/

	        $(".btnconsolidar").on('click',function(event) {

	        	if (confirm("¿Estas seguro de consolidar este pedido?") == true) {			        	
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
			    }
	    		    	

	    	});
	});
	
</script>
<h1>test</h1>
<?php 

$agentes = get_users(array("role"=>"cargo_agent ")  );
print_r($agentes);
/*print_r(wp_roles());*/
?>