<?php

function getorderuser() {
	/*$args = array(
       'post_type' => 'wpcargo_shipment',
        'meta_key' => 'registered_shipper',
       'meta_value' => get_current_user_id()
     );*/

     $args = array(

    'post_type'        => 'wpcargo_shipment',   
    'meta_query'       => array(
        //comparison between the inner meta fields conditionals
        'relation'    => 'AND',
        //meta field's first condition
        array(
            'key'          => 'registered_shipper',
            'value'        => get_current_user_id(),
            'compare'      => '=',
        ),
        //meta field's second condition
        array(
            'key'          => 'wpcargo_status',
            'value'        => 'SU ENVIO ESTA SIENDO CONSOLIDADO',
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => '=',
        )
    ),

);

    $query = new WP_Query( $args );

    return $query;
}


function loadorder() {
	 $idorder = $_POST['idorder'];	 
	 $paquetes = get_post_meta($idorder, 'wpc-multiple-package', true); 
	
	foreach ($paquetes as $paquete): 
		echo '<tr class="package-row">';
			echo "<td>".$paquete["wpc-pm-qty"]."</td>";			               
			echo "<td>".$paquete["wpc-pm-piece-type"]."</td>";					            
			echo "<td>".$paquete["wpc-pm-description"]."</td>";					               				            
			echo "<td>".$paquete["wpc-pm-weight"]."</td>";					               
			echo "<td class='colimagepa'><img src='".wp_get_attachment_image_src($paquete["imagen_paquete"])[0]."'></td>";					               					            
			echo "<td>".$paquete["store"]."</td>";					               					            
			echo "<td>".$paquete["tracking"]."</td>";
	    echo '</tr>';
	 endforeach;

	 wp_die();

}

add_action( 'wp_ajax_nopriv_loadorder', 'loadorder' );
add_action( 'wp_ajax_loadorder', 'loadorder' );


function consolidarpedido() {
	$result = 1;
	$idorder = $_POST['idorder'];	 
	update_post_meta($idorder, 'wpcargo_status', 'ENVIO CONSOLIDADO Y EN COLA DE SALIDA DE BODEGA MIAMI');
	$agente = get_post_meta($idorder, 'agent_fields', true);
	enviarcorreoconsolidado($agente, $idorder);
	echo json_encode(array("result"=>$result));
	wp_die();

}

add_action( 'wp_ajax_nopriv_consolidarpedido', 'consolidarpedido' );
add_action( 'wp_ajax_consolidarpedido', 'consolidarpedido' );


function enviarcorreoconsolidado($agente, $idorder){
	$user = get_user_by( 'id', intval($agente) );  
	$nombrepedido = get_post_meta($idorder, 'post_name', true);
	$message = "EL pedido ".$nombrepedido." ha sido consolidado";
	wp_mail( strval($user->user_email), "Consolidación de pedido", $message);
}

?>