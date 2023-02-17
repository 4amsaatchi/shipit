<?php


if (!isset($_GET['idenvio'])){
	echo "<h3>Pedido no encontrado</h3>";
	die();
}

$norder = $_GET['idenvio'];
$orden = get_post($norder);
if (!$orden){
	echo "<h3>Pedido no encontrado</h3>";
	die();
}
$estados = get_option("wpcargo_option_settings")["settings_shipment_status"];
$estados = explode(",", $estados);
$nestados = count($estados);
$estadoactual = 	get_post_meta($norder, 'wpcargo_status', true);

if ($estadoactual == "Envío consolidado"){
	$estadoactual = get_estadoparaconsolidar();
}
$estadoactivo = "estadoactivo";
$cont = 1;
?>

<div id="containerenvio">
	<div class="info1">
		<h1>Orden No. <?= $orden->post_name; ?></h1>
		<p>Gracias por confiar <?= do_shortcode( '[nombreusuario]' ); ?></p>
		<span>Tu envío se encuentra <?= $estadoactual; ?></span>
		<?php if ( get_post_meta($norder, 'wpshipit_paymentstatus', true) != "") : ?>
			<p> Estado de pago: <?= get_post_meta($norder, 'wpshipit_paymentstatus', true); ?> </p>
		<?php endif; ?>
	</div>
	<div class="estadospedido">
		
		<?php
		foreach ($estados as $estado) : ?>						
			<div class="estadopedido e<?= $nestados; ?> <?= $estadoactivo; ?>">				
				<!--<img src="<?= get_stylesheet_directory_uri() ?>/assets/images/ico<?= $cont; ?>.svg" alt="img<?= $estado; ?>">-->
				<div class="cimgestado">
					<object type="image/svg+xml" data="<?= get_stylesheet_directory_uri() ?>/assets/images/ico<?= $cont; ?>.svg" class="<?= $estadoactivo; ?>">				    
					</object>					
					<hr class="sepimg"></hr>
				</div>

				<span class="txtestado"><?= $estado; ?></span>
				<?php $cont++; ?>
			</div>

			<?php if (trim($estado) == trim($estadoactual)):
					$estadoactivo = "estadoinactivo";
				  endif;
			?>
		<?php
		 endforeach;
		?>

	</div>

	<div class="actualizaciones">
		<h2> Actualizaciones de la orden </h2>
		<p>También recibirá actualizaciones de embarco y entregar por medio de email </p>
	</div>
	<div class="paquetesenvio">
		<?php
		$cont = 1;
			 $paquetes = get_post_meta($norder, 'wpc-multiple-package', true); 			
			foreach ($paquetes as $paquete): ?>
				<div class="singlepaquete">
					<div class="colimg">
						
						<?php if ($paquete["imagen_paquete"] != "")?>
						<img src='<?= wp_get_attachment_image_src($paquete["imagen_paquete"])[0]; ?>'>	
					</div>
					<div class="content">
						<h5>Paquete <?= $cont; ?></h5>
						<p><?= $paquete["wpc-pm-description"]; ?></p>
					</div>
					<div class="accion">
						<p class="subtitulo">Tracking <?= $cont; ?></p>
						<p class="ptracking"><?= $paquete["tracking"]; ?></p>
						<?php 
						$factura = $paquete["factura"];
						if (wp_get_attachment_url($factura)): 
						$factura = wp_get_attachment_url($factura);						
						 endif; ?>

						<a class="ds" href="<?= $factura; ?>" download="<?= $factura; ?>">Descargar Factura</a>
						<p class="not"> Revisa antes de consolidar: Haz click en nuestro chat si quieres corregir datos o necesitas ayuda <a href="#">LINK CHAT</a></p>
					</div>
					
					
				</div>
			<?php 
					$cont++; 
					/*echo '<tr class="package-row">';
					echo "<td>".$paquete["wpc-pm-qty"]."</td>";			               
					echo "<td>".$paquete["wpc-pm-piece-type"]."</td>";					            
					echo "<td>".$paquete["wpc-pm-description"]."</td>";					               				            
					echo "<td>".$paquete["wpc-pm-weight"]."</td>";					               
					echo "<td class='colimagepa'><img src='".wp_get_attachment_image_src($paquete["imagen_paquete"])[0]."'></td>";					               					            
					echo "<td>".$paquete["store"]."</td>";					               					            
					echo "<td>".$paquete["tracking"]."</td>";
			    echo '</tr>';*/
			 endforeach;
	 ?>
	</div>
	<div class="historialpedido">		
		<?php $historial = get_post_meta($norder, 'wpcargo_shipments_update', true); ?>
		<?php if ($historial): ?>
		<h2>¿En dónde está tu pedido?</h2>

		<?php 
			/*	Ordernar por fecha */

		  foreach ($historial as $key => $part) {
       			$sort[$key] = strtotime($part['date'].$part['time']);
  			}
  			array_multisort($sort, SORT_DESC, $historial);

		?>

		<div class="tablaenvios">
			<div class="cabecera rowenvios">
				   <div>Estado</div>
				   <div>Fecha</div>
				   <div>Observaciones</div>
			</div>
			
				<?php foreach ($historial as $histo): ?>
				<div class="rowenvios">
					<div><?= $histo["status"]; ?></div>
					<div><?= $histo["date"]; ?> <?= $histo["time"]; ?> </div>
					<div><?= $histo["remarks"]; ?></div>					
				</div>
				<?php endforeach; ?>
			

		<?php endif; ?>
	       
			
		

				
		</div>
		
	</div>
</div>

<style type="text/css">
	.historialpedido {
		margin: 30px 0px;
		text-align: center;
	}

	.historialpedido h2 {
		margin: 40px 0px;
		color: #4F3356;
		font-weight: bold;
		display: block;
	}
	.subtitulo {
		font-weight: bold;
		color: #f53c5d;
	}

	.accion a {
		color: #f53c5d;	
	}

	.accion .not {
		font-size: 12px;
		margin-top: 10px;
	}
	.ptracking {
		font-weight: bold;
		color: #000;
	}
	.content h5 {
		color: #4F3356;
		font-weight: bold;
	}
	.singlepaquete {
		display: inline-flex;
		width: 100%;
	}
	.singlepaquete .colimg, .singlepaquete .accion {
		width: 20%;
	}

	.singlepaquete .content {
		width: 80%;
	}

	.info1 h1 {
		color: #4F3356;
		font-weight: bold;
	}

	.info1 p {
		color: 000;
		font-size: 20px;
		font-weight: bold;
	}

	.info1 span {
		color: #f53c5d;
		font-weight: bold;
		font-size: 20px;
		margin-top: 30px;
		display: block;

	}
	.txtestado {
		margin-left: -62px;
		margin-top: 10px;
		display: block;
	}
	.cimgestado {
		display: flex;
		align-items: center;
	}

	.estadospedido .estadopedido:last-child .sepimg {
		display: none;

	}

	.sepimg {
		background: #f53c5d;
	    height: 6px;
	    background-color: #f53c5d !important;	    
	    width: 20%;
	}
	.estadopedido object {
		width: 90px;
		margin-right: 20px;
	}

	.estadoinactivo {
		    filter: invert(0%) sepia(35%) saturate(1164%) hue-rotate(201deg) brightness(0%) contrast(0%);
		    opacity: 0.5;
	}

	.estadopedido {
		text-align: center;
	}

	.estadospedido{
		justify-content: center;
		margin: 50px 0px;
		display: inline-flex;
		width: 100%;
	}
	.e7 {
		width: 14.2%;
	}

	.info1 {
		text-align: center;
	}

	.actualizaciones {
		margin: 40px 0px;
		text-align: center;
	    background: #5ac5f1;
	    color: #FFF;
	    padding: 20px 0px;
	}

	@media (max-width: 768px) {
		

		.info1 h1 {
			font-size: 2rem;
		}

		div#containerenvio {
    		margin-top: 30px;
    		padding: 0px 6px;
		}

		.singlepaquete{
			flex-direction: column;
		}

		.singlepaquete .colimg, .singlepaquete .accion {
			width: 100%;
		}

		.estadospedido {
			flex-wrap: wrap;
			justify-content: center;
		}

		.e7 {
		    width: 25%;
		    margin-right: 3%;
		    margin-bottom: 30px;
		}

		.txtestado {
    		margin-left: auto;
		}

		.sepimg {
			display: none;
		}

		.actualizaciones {
			margin: 0px;
		}

		.rowenvios div {
			font-size: 14px;
		}

	}
</style>

<script type="text/javascript">
	 
    	$( ".ds" ).click(function(e) {   
    	var href =$(this).attr("href");
  			e.preventDefault();
  			
  			setTimeout(() => {
			  console.log("Delayed for 1 second.");
			  $(this).attr("href",href);
			}, "1000")
  			
		});
	
	
</script>