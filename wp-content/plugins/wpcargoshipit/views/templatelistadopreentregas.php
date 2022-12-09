<h1 id="titpre">Pre-entregas</h1>

<div id="listadopreentregas">
	
<div class="rowth rowpreentregas">
	<div class="colpreentrega">
		<label>Nombre de usuario</label>
	</div>
	<!--<div class="colpreentrega">
		<label>Id preentrega</label>
	</div>-->
	<div class="colpreentrega">
		<label>Fecha preevista</label>
	</div>
	<div class="colpreentrega">
		<label>Tracking</label>
	</div>	
	<div class="colpreentrega">
		<label>Tienda ingreso</label>
	</div>	
	<div class="colpreentrega">
		<label>Email</label>
	</div>	
	<div class="colpreentrega">
		<label>Factura</label>
	</div>	
	<div class="colpreentrega">
		<label>Agregar</label>
	</div>	
</div>
<?php 

$wpb_all_query = new WP_Query(array('post_type'=>'preentregas', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>
 
<?php if ( $wpb_all_query->have_posts() ) : ?>
	<?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); 
			$author_id = get_post_field ('post_author', get_the_ID());
			$display_name = get_the_author_meta( 'display_name' , $author_id ); 
			$email = get_the_author_meta( 'email' , $author_id ); 
		?>

	<div class="rowpreentregas">
		<div class="colpreentrega">
			<?= $display_name; ?>
		</div>
		<!--<div class="colpreentrega">
			<?php //get_the_ID(); ?>
		</div>-->
		<div class="colpreentrega">
			<?= get_post_meta(get_the_ID(), 'fechaestimada', TRUE); ?>
		</div>
		<div class="colpreentrega">
			<?= get_post_meta(get_the_ID(), 'trackingid', TRUE); ?>		
		</div>
		<div class="colpreentrega">
			<?= get_post_meta(get_the_ID(), 'tienda', TRUE); ?>
		</div>
		<div class="colpreentrega">
			<a href="mailto:<?= $email; ?>" target="_blank"><?= $email; ?></a>		
		</div>
		<div class="colpreentrega">
			<a href="<?= get_post_meta(get_the_ID(), 'factura', TRUE); ?>" target="_blank">Descargar </a>		
		</div>
		<div class="colpreentrega">
			<a data-id="<?= get_the_ID(); ?>" data-user="<?= $author_id; ?>" class="btncons"> Agregar a envío <br>en consolidación </a>
		</div>
	</div>
<?php endwhile; ?>
<?php endif;

wp_reset_query();

?>


</div>

<style type="text/css">
	
	.rowpreentregas:nth-child(2n+3) {
		background: #f4f4f4;
	}
	div.rowpreentregas {
		display: inline-flex;
		width: 102%;
		background: #FFF;
	}

	.colpreentrega {
		/*background: #eaeaea;*/
		padding: 20px;
		width: 14%;
	}

	div.rowth .colpreentrega{
		background: #f53c5e;
		color: #FFF;		
	}

	#titpre {
		margin: 40px auto;
	    display: block;
 	   	text-align: center;
	}

	.btncons {
		background: #f53c5e;
		color: #FFF;
		padding: 2px;
		font-size: 12px;
		text-align: center;
		border-radius: 22px;
		max-width: 150px;
		display: block;
		word-break: keep-all;
		cursor: pointer;
	}

	.btncons:hover {
		background: #000;
		color: #FFF;
	}

	#listadopreentregas {
		border: 1px solid #f53c5e;
	}
</style>


<script type="text/javascript">
	
		var url = "<?= admin_url( 'admin-ajax.php' ); ?>";
    	var nonce = "<?= wp_create_nonce( 'my-ajax-nonce' ); ?>";

	   jQuery( ".btncons" ).click(function(event) {

	   	if (confirm("Estas seguro que deseas agregar este paquete") == true) {
	   		var idpaquete = jQuery(this).attr("data-id");
	   		var iduser    = jQuery(this).attr("data-user");


	   		jQuery.ajax({
            type: "post",
            dataType: 'json',
            url: url,
            data: "action=asignarapedido&nonce=" + nonce +"&idpaquete="+idpaquete+"&iduser="+iduser,
            success: function(result){            		
            	
            	console.log(result);
            		if (result.result == 1){
            			alert("PAQUETE AGREGADO");
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

</script>