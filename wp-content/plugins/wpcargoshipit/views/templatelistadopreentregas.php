<h1 id="titpre">Notificaciones</h1>
<div id="listadopreentregas">
	
<div class="rowth rowpreentregas">
	<div class="colpreentrega">
		<label>Nombre de usuario</label>
	</div>
	<div class="colpreentrega">
		<label>Nombre paquete</label>
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
			$display_name = get_the_author_meta( 'display_name' , $author_id ); /*." ".get_the_author_meta( 'last_name' , $author_id ); */
			$email = get_the_author_meta( 'email' , $author_id ); 
		?>

	<div class="rowpreentregas">
		<div class="colpreentrega">
			<label class="onlymobiletxt">Nombre de usuario</label>
			<?= $display_name; ?>
		</div>
		<!--<div class="colpreentrega">
			<?php //get_the_ID(); ?>
		</div>-->
		<div class="colpreentrega">
			<label class="onlymobiletxt">Nombre paquete</label>
			<?= htmlspecialchars(get_the_title(get_the_ID())); ?>
		</div>
		<div class="colpreentrega">
			<label class="onlymobiletxt">Fecha preevista</label>
			<?= get_post_meta(get_the_ID(), 'fechaestimada', TRUE); ?>
		</div>
		<div class="colpreentrega">
			<label class="onlymobiletxt">Tracking</label>
			<?= htmlspecialchars(get_post_meta(get_the_ID(), 'trackingid', TRUE)); ?>		
		</div>
		<div class="colpreentrega">
			<label class="onlymobiletxt">Tienda ingreso</label>
			<?= htmlspecialchars(get_post_meta(get_the_ID(), 'tienda', TRUE)); ?>
		</div>

		<div class="colpreentrega">
			<label class="onlymobiletxt">Carrier</label>
			<?= htmlspecialchars(get_post_meta(get_the_ID(), 'carrier', TRUE)); ?>
		</div>
		<div class="colpreentrega">
			<label class="onlymobiletxt">Email</label>
			<a href="mailto:<?= $email; ?>" target="_blank"><?= $email; ?></a>		
		</div>
		<div class="colpreentrega">
			<label class="onlymobiletxt">Factura</label>
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

	.onlymobiletxt {
		display: none;
	}
	@media only screen and (max-width: 600px) {
		.colpreentrega {
			width: 100%;
		}

		div.rowpreentregas{
			flex-direction: column;
			width: 100%;
		}
		.onlymobiletxt {
			display: block;
			color: #f53c5e;
			font-weight: bold;
		}
		.btncons {
			margin: 0px auto;
		}

		.rowth{
			display: none!important;
		}

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
<?php 
/*
$out = '<style>
.flex-columns {
    column-count: 4;
    column-gap: 3em;
    column-rule: 1px solid #000;
}        
</style>';
    $out .= '<p class="flex-columns">';
    $users = get_users();
    foreach ( $users as $user ) {
    	//wpcargo_employee
        if ( $user->caps['cargo_agent'] ) {
            $allcaps = array_keys( $user->allcaps );
            print_r($allcaps);
            foreach ( $allcaps as $cap ) {
                $out .= $cap . '<br>';
            }
            $out .= '</p>';
     echo $out;
        }
    }

$admin_role_set = get_role( 'cargo_agent' )->capabilities;

print_r($admin_role_set);*/
?>